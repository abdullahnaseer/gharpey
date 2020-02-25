<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    protected $table = 'product_order';

    const STATUS_PAID = 'paid';
    const STATUS_SELLET_SENT ='seller_sent';
    const STATUS_WAREHOUSE_RECEVIED ='warehouse_received';
    const STATUS_SENT ='sent';
    const STATUS_COMPLETED ='completed';
    const STATUS_CANCELED ='canceled';

    const STATUSES = [
        self::STATUS_PAID,
        self::STATUS_SELLET_SENT,
        self::STATUS_WAREHOUSE_RECEVIED,
        self::STATUS_SENT,
        self::STATUS_COMPLETED,
        self::STATUS_CANCELED,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'product_id', 'price', 'quantity', 'status',
        'seller_send_at', 'send_at', 'warehouse_received_at', 'completed_at', 'canceled_at'
    ];

    protected $casts = [
        'price' => 'float',
        'quantity' => 'integer'
    ];

    /**
     * Get the product that owns the order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Get the product that owns the order.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
