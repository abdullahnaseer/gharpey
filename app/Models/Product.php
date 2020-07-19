<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'featured_image',
        'seller_id',
        'category_id',
        'price',
        'slug',
        'inventory'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'integer'
    ];

    /**
     * Get the seller that owns the product.
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id', 'id');
    }

    /**
     * Get the seller that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    /**
     * Get the orders for the product.
     */
    public function orders()
    {
        return $this->hasMany(ProductOrder::class);
    }

    /**
     * Get the orders for the product.
     */
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    /**
     * Get the orders for the product.
     */
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    /**
     * Get the orders for the product.
     */
    public function getReviewsAverageAttribute()
    {
        return $this->reviews()->average('rating');
    }

    /**
     * The wishlist buyer that belong to the product.
     */
    public function wishlist_buyers()
    {
        return $this->belongsToMany(Buyer::class, 'wishlist')
            ->withTimestamps()
            ->using(Wishlist::class);
    }

}
