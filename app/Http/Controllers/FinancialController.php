<?php

namespace App\Http\Controllers;

use App\Models\FinancialTransaction;
use App\Models\User;
use App\Repositories\FinancialRepository;
use App\Services\TransactionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class FinancialController extends Controller
{
    protected $transactionService;
    protected $financialRepository;

    public function __construct(TransactionService $transactionService, FinancialRepository $financialRepository){
        $this->transactionService = $transactionService;
        $this->financialRepository = $financialRepository;
    }

    public function index()
    {
        try{
            $transactions = $this->financialRepository->getAllTransactions();

            return view('transactions.index')->with(['transactions' => $transactions]);
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function create()
    {
        try{
            $users = User::whereNull('deleted_at')->get();
            
            return view('transactions.create')->with(['users' => $users]);
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $rules = array(
            'description' => 'required|string',
            'transaction_type' => 'required|string|in:credit,debit',
            'amount' => 'required|numeric|min:0.1'
        );

        if(Auth::user()->roles->first()->name == 'admin'){
            $rules['user_id'] = 'required';
        }
        
        try{
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            } else {
                $this->transactionService->store($request->all());

                return redirect()->route('financials.index');
            }
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function edit($id)
    {
        try{
            $transaction = FinancialTransaction::find($id);
            $users = User::whereNull('deleted_at')->get();

            return view('transactions.create')->with(['transaction' => $transaction, 'users' => $users]);
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $rules = array(
                'description' => 'required|string',
                'transaction_type' => 'required|string|in:credit,debit',
                'amount' => 'required|numeric|min:0.1'
            );
    
            if(Auth::user()->roles->first()->name == 'admin'){
                $rules['user_id'] = 'required';
            }
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all());
            } else {
                $this->transactionService->update($request->all(), $id);

                return redirect()->route('financials.index');
            }
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try{
            FinancialTransaction::find($id)->delete();

            return redirect()->route('financials.index');
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }
}
