<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FinancialTransaction;
use App\Repositories\FinancialRepository;
use App\Services\TransactionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FinancialController extends Controller
{   
    protected $transactionService;
    protected $financialRepository;

    public function __construct(TransactionService $transactionService, FinancialRepository $financialRepository){
        $this->transactionService = $transactionService;
        $this->financialRepository = $financialRepository;
    }

    public function index(){
        try{
            $transactions = $this->financialRepository->getAllTransactionsForApi();

            return response()->json(['success' => true, 'transactions' => $transactions], 200);
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Transaction was not retrieved successfully'], 500);
        }
    }

    public function store(Request $request){
        $rules = array(
            'description' => 'required|string',
            'transaction_type' => 'required|string|in:credit,debit',
            'amount' => 'required|numeric|min:0.1'
        );
        
        if(Auth::guard('api')->user()->roles->first()->name == 'admin'){
            $rules['user_id'] = 'required';
        }
        
        try{
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->messages()->first()], 400);
            } else {
                $transaction = $this->transactionService->storeUsingApi($request->all());

                return response()->json(['success' => true, 'transaction' => $transaction], 200);
            }
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Transaction was not stored successfully'], 500);
        }
    }

    public function update(Request $request)
    {
        try{
            $rules = array(
                'description' => $request->has('description') ? 'required|string' : '',
                'transaction_type' => $request->has('transaction_type') ? 'required|string|in:credit,debit' : '',
                'amount' => $request->has('amount') ? 'required|numeric|min:0.1' : '',
                'transaction_id' => 'required|numeric'
            );
            $user = Auth::guard('api')->user();

            if($user->roles->first()->name == 'admin'){
                $rules['user_id'] = $request->has('user_id') ? 'required' : '';
            }else{
                if(!in_array($request->get('transaction_id'), $user->transactions->pluck('id')->toArray())){
                    return response()->json(['success' => false, 'message' => 'Transaction not found'], 500);
                }
            }

    
            if(!$request->has('description') && !$request->has('transaction_type') && !$request->has('amount') && !$request->has('user_id')){
                return response()->json(['success' => false, 'message' => 'No data to be updated'], 404);
            }

            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->messages()->first()], 400);
            } else {
                $transaction = $this->transactionService->update($request->all(), $request->get('transaction_id'));
                
                return response()->json(['success' => true, 'transaction' => $transaction], 200);
            }
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Transaction was not updated successfully'], 500);
        }
    }

    public function destroy(Request $request)
    {
        try{
            if(Auth::guard('api')->user()->roles->first()->name == 'admin'){
                $rules = array(
                    'transaction_id' => 'required|numeric'
                );
                $validator = Validator::make($request->all(), $rules);
                
                if ($validator->fails()) {
                    return response()->json(['success' => false, 'message' => $validator->messages()->first()], 400);
                } else {
                    $transaction = FinancialTransaction::find($request->get('transaction_id'));
                    if(!empty($transaction)){
                        $transaction->delete();
                    }else{
                        return response()->json(['success' => false, 'message' => 'Transaction not found'], 500);
                    }
    
                    return response()->json(['success' => true, 'message' => 'Transaction deleted successfully'], 200);
                }
            }else{
                return response()->json(['success' => false, 'message' => 'User needs to be admin to delete the transaction'], 400);
            }
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Transaction was not deleted successfully'], 500);
        }
    }
}
