<?php

namespace App\Models;

use App\Models\Traits\UserApiTokenTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Moderator extends Authenticatable
{
    use HasApiTokens, Notifiable, UserApiTokenTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'address', 'location_id', 'password', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Get the location that owns the resource.
     */
    public function location()
    {
        return $this->belongsTo(CityArea::class, 'location_id', 'id');
    }
}
