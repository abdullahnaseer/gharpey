<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'name', 'slug', 'featured_image'
    ];

    /**
     * The services that belong to the service category.
     */
    public function services()
    {
        return $this->belongsToMany('App\Models\Service', 'service_category', 'category_id', 'service_id');
    }
}
