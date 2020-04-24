<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ServiceSeller extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'integer'
    ];

    public static function getRules($request, $isEdit = false)
    {
        $rules = [
            'name' => 'required|min:3|max:255',
            'description' => 'required|min:10|max:1000',
            'featured_image' => $isEdit ? 'image' : 'required|image',
            'category_id' => 'required|numeric|exists:service_categories,id',

            'title' => 'required|array',
            'title.*' => 'required|min:3|max:255',
            'question' => 'required|array',
            'question.*' => 'required|min:3|max:255',
            'type' => 'required|array',
            'type.*' => 'required|string|in:' .
                ServiceQuestion::TYPE_BOOLEAN . ',' . ServiceQuestion::TYPE_TEXT . ',' . ServiceQuestion::TYPE_TEXT_MULTILINE . ',' . ServiceQuestion::TYPE_SELECT . ',' . ServiceQuestion::TYPE_SELECT_MULTIPLE . ',' . ServiceQuestion::TYPE_FILE . ',' . ServiceQuestion::TYPE_FILE_MULTIPLE . ',' . ServiceQuestion::TYPE_TIME . ',' . ServiceQuestion::TYPE_DATE . ',' . ServiceQuestion::TYPE_DATE_TIME,

            'auth_type' => 'required|array',
            'auth_type.*' => 'required|string|in:' .
                ServiceQuestion::AUTH_ANY . ',' . ServiceQuestion::AUTH_GUEST . ',' . ServiceQuestion::AUTH_REQUIRED,

            'is_required' => 'required|array',
            'is_required.*' => 'required|string|in:0,1'
        ];

//        if(!is_null($request->input('type', null)) && ($request->input('type', null) === ServiceQuestion::TYPE_SELECT || $request->input('type', null) === ServiceQuestion::TYPE_SELECT_MULTIPLE ))
//            $rules['choices'] = 'required|array';

        $i = 0;
        foreach ($request->input('type', []) as $input) {
            if ($input === ServiceQuestion::TYPE_SELECT || $input === ServiceQuestion::TYPE_SELECT_MULTIPLE) {
                $rules['choices.' . $i] = 'required|array';
                $rules['choices.' . $i . '.*'] = 'required|string|min:3|max:50';
            }
            $i++;
        }

        return $rules;
    }

    /**
     * Get the owning service_seller_able model.
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    /**
     * Get the owning service_seller_able model.
     */
    public function reviews()
    {
        return $this->hasMany(ServiceSellerReview::class, 'service_seller_id');
    }

    /**
     * Get all of the states that are assigned this service.
     */
    public function states()
    {
        return $this->morphedByMany('App\Models\State', 'location', 'service_seller_location',
            'service_seller_id', 'location_id');
    }

    /**
     * Get all of the cities that are assigned this service.
     */
    public function cities()
    {
        return $this->morphedByMany('App\Models\City', 'location', 'service_seller_location',
            'service_seller_id', 'location_id');
    }

    /**
     * Get all of the areas that are assigned this service.
     */
    public function areas()
    {
        return $this->morphedByMany('App\Models\CityArea', 'location', 'service_seller_location',
            'service_seller_id', 'location_id');
    }
}
