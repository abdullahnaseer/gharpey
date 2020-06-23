<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerWithdraw extends Model
{
    protected $appends = ['created_at_formatted'];

    protected $fillable = [
        'bank', 'name', 'account_no', 'seller_id', 'transaction_id', 'amount'
    ];

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->toDayDateTimeString();
    }
}
