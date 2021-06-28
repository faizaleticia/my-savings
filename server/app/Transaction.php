<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id', 'value', 'transaction_type_id'
    ];

    /**
     * Get the transaction type associated with the transaction.
     */
    public function transactionType()
    {
        return $this->hasOne(TransactionType::class, 'id', 'transaction_type_id');
    }
}
