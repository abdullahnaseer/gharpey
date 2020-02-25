<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'buyer_id', 'shipping_phone', 'shipping_address', 'shipping_location_id', 'charge_id', 'paid_at'
    ];

    /**
     * Get the product that owns the order.
     */
    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'id');
    }
}
