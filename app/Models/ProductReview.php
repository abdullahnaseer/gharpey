<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = [
        'product_id',
        'product_order_id',
        'review',
        'rating'
    ];

    public function product_order()
    {
        return $this->hasMany(ProductOrder::class, 'order_id');
    }
}
