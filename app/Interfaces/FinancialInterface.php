<?php

namespace App\Interfaces;

interface FinancialInterface 
{
    public function getAllTransactions();
    public function getAllTransactionsForApi();
}