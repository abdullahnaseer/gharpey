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
        'buyer_id', 'shipping_phone', 'shipping_address', 'shipping_location_id', 'charge_id', 'paid_at', 'receipt_email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'charge_id'
    ];

    /**
     * Get the products for the order.
     */
    public function items()
    {
        return $this->hasMany(ProductOrder::class, 'order_id', 'id');
    }

    /**
     * Get the products for the order.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_order')
            ->withTimestamps();
    }

    /**
     * Get the product that owns the order.
     */
    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'id');
    }
}
