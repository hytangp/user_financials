<?php

namespace App\Repositories;

use App\Interfaces\FinancialInterface;
use App\Models\FinancialTransaction;
use Illuminate\Support\Facades\Auth;

class FinancialRepository implements FinancialInterface 
{
    public function getAllTransactions() 
    {
        $transactions = FinancialTransaction::whereNull('deleted_at');

        if(Auth::user()->roles->first()->name == 'user'){
            $transactions->where('user_id', Auth::user()->id);
        }

        return $transactions->paginate(5);
    }

    public function getAllTransactionsForApi() 
    {
        $transactions = FinancialTransaction::whereNull('deleted_at');

        if(Auth::guard('api')->user()->roles->first()->name == 'user'){
            $transactions->where('user_id', Auth::guard('api')->user()->id);
        }

        return $transactions->paginate(5);
    }
}
