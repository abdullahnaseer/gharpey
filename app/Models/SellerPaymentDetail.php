<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerPaymentDetail extends Model
{
    protected $fillable = [
        'bank', 'name', 'account_no', 'seller_id', 'threshold'
    ];
}
