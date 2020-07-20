<?php

namespace App\Models;

use Eloquent as Model;

class CityArea extends Model
{
    public $table = 'city_areas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name',
        'city_id',
        'zip'
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'zip' => 'integer'
    ];

    /**
     * Get the areas's full address.
     *
     * @return string
     */
    public function getFullAddressAttribute()
    {
        return "{$this->name}, {$this->city->name}, {$this->city->state->name}, {$this->city->state->country->name}";
    }

    /**
     * Get the city that owns the city area.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the Seller(s) associated with the CityArea.
     */
    public function seller_business_locations()
    {
        return $this->hasMany(Seller::class, 'business_location_id', 'id');
    }

    /**
     * Get the Seller(s) associated with the CityArea.
     */
    public function seller_warehouse_locations()
    {
        return $this->hasMany(Seller::class, 'warehouse_location_id', 'id');
    }

    /**
     * Get the Seller(s) associated with the CityArea.
     */
    public function seller_return_locations()
    {
        return $this->hasMany(Seller::class, 'return_location_id', 'id');
    }

    /**
     * Get the Buyer(s) associated with the CityArea.
     */
    public function buyers()
    {
        return $this->hasMany(Buyer::class, 'location_id', 'id');
    }

    /**
     * Get the ProductOrder(s) associated with the CityArea.
     */
    public function product_orders()
    {
        return $this->hasMany(Order::class, 'shipping_location_id', 'id');
    }

    /**
     * Get the owning service_seller_able model.
     */
    public function service_sellers()
    {
        return $this->belongsToMany(ServiceSeller::class, 'service_seller_location', 'location_id', 'service_seller_id')
            ->where('location_type', CityArea::class)
            ->withPivot([]);
    }
}
