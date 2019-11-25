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
        return $this->belongsTo(\App\Models\State::class);
    }

    /**
     * Get the areas owned by city.
     */
    public function areas()
    {
        return $this->hasMany('App\Models\CityArea');
    }

}
