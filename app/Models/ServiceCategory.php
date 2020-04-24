<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ServiceCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'service_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'featured_image', 'depth', 'parent_id'
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

    /**
     * The services that belong to the service category.
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }

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
