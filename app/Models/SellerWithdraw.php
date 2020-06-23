<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerWithdraw extends Model
{
    protected $fillable = [
        'bank', 'name', 'account_no', 'seller_id', 'transaction_id', 'amount'
    ];
}
