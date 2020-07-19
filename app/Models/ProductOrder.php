<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model{

    const STATUS_NEW = 'new';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_SELLER_SENT = 'seller_sent';
    const STATUS_WAREHOUSE_RECEVIED = 'warehouse_received';
    const STATUS_SENT = 'sent';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELED = 'canceled';
    const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_CONFIRMED,
        self::STATUS_SELLER_SENT,
        self::STATUS_WAREHOUSE_RECEVIED,
        self::STATUS_SENT,
        self::STATUS_COMPLETED,
        self::STATUS_CANCELED,
    ];
    protected $table = 'product_order';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'product_id', 'price', 'quantity', 'status',
        'seller_send_at', 'send_at', 'warehouse_received_at', 'completed_at', 'canceled_at', 'reviewed_at', 'confirmed_at'
    ];

    protected $casts = [
        'price' => 'float',
        'quantity' => 'integer',
        'seller_send_at' => 'datetime',
        'send_at' => 'datetime',
        'warehouse_received_at' => 'datetime',
        'completed_at' => 'datetime',
        'canceled_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'confirmed_at' => 'datetime',
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


    /**
     * Get the review for the order.
     */
    public function review()
    {
        return $this->hasOne(ProductReview::class, 'product_order_id', 'id');
    }

    public function scopeCompleted()
    {
        $this->whereNotNull('completed_at');
    }
}
