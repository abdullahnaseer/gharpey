<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const TYPE_CREDIT = 'credit';
    const TYPE_DEBIT = 'debit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'user_type', 'reference_id', 'reference_type', 'type', 'amount', 'balance', 'note',
    ];


//    /**
//     * Get the user balance that owns the log record.
//     */
//    public function balance()
//    {
//        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
//    }


    /**
     * Get all of the owning transaction_able models.
     */
    public function reference()
    {
        return $this->morphTo();
    }
}
