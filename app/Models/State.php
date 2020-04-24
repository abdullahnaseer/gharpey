<?php

namespace App\Models;

use Eloquent as Model;

class State extends Model
{
    public $table = 'states';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name',
        'iso',
        'country_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    public function cities()
    {
        return $this->hasMany('App\Models\City');
    }


    /**
     * Get the country that owns the state.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
