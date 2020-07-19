<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use Notifiable;

    const PAYMENT_GATEWAY_COD = "cod";
    const PAYMENT_GATEWAY_STRIPE = "stripe";

    const PAYMENT_GATEWAYS = [
        self::PAYMENT_GATEWAY_COD,
        self::PAYMENT_GATEWAY_STRIPE,
    ];

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
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    public function routeNotificationForMail($notification)
    {
        // Return email address only...
        return $this->receipt_email;
    }

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
