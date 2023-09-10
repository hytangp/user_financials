<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialTransaction extends Model
{
    use HasFactory, SoftDeletes;

    public const TRANSACTION_TYPE_CREDIT = 'credit';
    public const TRANSACTION_TYPE_DEBIT = 'debit';

    public const TRANSACTION_TYPES = [
        self::TRANSACTION_TYPE_CREDIT,
        self::TRANSACTION_TYPE_DEBIT
    ];

    protected $table = 'financial_transactions';

    protected $fillable = ['user_id', 'description', 'transaction_type', 'amount'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
