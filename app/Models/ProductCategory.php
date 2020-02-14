<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name', 'slug', 'featured_image'
    ];

    /**
     * Get the products for the product category.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

}
