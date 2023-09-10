<?php

namespace App\Services;

use App\Models\FinancialTransaction;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransactionService{
    public function store($data){
        try{
            $data['user_id'] = Auth::user()->roles->first()->name == 'admin' ? $data['user_id'] : Auth::user()->id;
            $transaction = $this->create($data);

            return $transaction;
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function storeUsingApi($data){
        try{
            $data['user_id'] = Auth::guard('api')->user()->roles->first()->name == 'admin' ? $data['user_id'] : Auth::guard('api')->user()->id;
            $transaction = $this->create($data);
            
            return $transaction;
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function create($data){
        try{
            $transaction = FinancialTransaction::create([
                'user_id' => $data['user_id'],
                'description' => $data['description'],
                'transaction_type' => $data['transaction_type'],
                'amount' => $data['amount'],
            ]);
            return $transaction;
        }catch(Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function update($data, $id){
        try{
            $transaction = FinancialTransaction::find($id);

            if(isset($data['user_id']) && (!empty(Auth::guard('api')->user()) && Auth::guard('api')->user()->roles->first()->name == 'admin') || (!empty(Auth::user()) && Auth::user()->roles->first()->name == 'admin')){
                $transaction->user_id = $data['user_id'];
            }
            if(isset($data['description'])){
                $transaction->description = $data['description'];
            }
            if(isset($data['transaction_type'])){
                $transaction->transaction_type = $data['transaction_type'];
            }
            if(isset($data['amount'])){
                $transaction->amount = $data['amount'];
            }
            $transaction->save();

            return $transaction;
        }catch(Exception $e){
            Log::error($e->getMessage());
            return $e;
        }
    }
}