<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProductCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name', 'slug', 'featured_image', 'depth'
    ];

    public static function sub_categories($categories, $depth = 0)
    {
        if (is_array($categories) || $categories instanceof Collection) {
            foreach ($categories as $category) {
                $category->depth = $depth;
                $category->sub_categories = $category->child_categories()->get();
                foreach ($category->sub_categories as $sub_category)
                    $sub_category->sub_categories = self::sub_categories($sub_category, ++$depth);
            }

            return $categories;
        } else {
            $category = $categories;
            $category->depth = $depth;
            $category->sub_categories = $category->child_categories()->get();
            foreach ($category->sub_categories as $sub_category)
                $sub_category->sub_categories = self::sub_categories($sub_category, ++$depth)->sub_categories;

            return $category;
        }
    }

    public static function parent_categories($category)
    {
        $parent_category = $category->parent_category;
        $categories = collect([$category]);
        while (!is_null($parent_category)) {
            $categories->prepend($parent_category);
            $parent_category = $parent_category->parent_category;
        }

        return $categories;
    }

    public function super_parent()
    {
        $categories = self::parent_categories($this);
        return ($categories && $categories->first()->id != $this->id) ? $categories->first() : null;
    }

    /**
     * Get the products for the product category.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id')
            ->where('inventory', '>', 0);
    }

//    /**
//     * Get the products for the product category.
//     */
//    public function productsInInventory()
//    {
//        return $this->hasMany(Product::class, 'category_id')
//            ->where('inventory', '>', 0);
//    }

    /**
     * Get the sub categories for the product category.
     */
    public function child_categories()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Get the parent category for the product category.
     */
    public function parent_category()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
}
