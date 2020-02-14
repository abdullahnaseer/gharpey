<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
