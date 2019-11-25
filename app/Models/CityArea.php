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
        return $this->belongsTo(\App\Models\City::class);
    }
}
