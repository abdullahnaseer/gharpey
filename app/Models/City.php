<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class City
 * @package App\Models
 * @version September 15, 2018, 5:55 pm UTC
 *
 * @property string name
 * @property unsignedInteger state_id
 */
class City extends Model
{
    public $table = 'cities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name',
        'state_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Get the city that owns the city area.
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the areas owned by city.
     */
    public function areas()
    {
        return $this->hasMany('App\Models\CityArea', 'city_id');
    }

    /**
     * Get the owning service_seller_able model.
     */
    public function service_sellers()
    {
        return $this->belongsToMany(ServiceSeller::class, 'service_seller_location', 'location_id', 'service_seller_id')
            ->where('location_type', City::class)
            ->withPivot([]);
    }
}
