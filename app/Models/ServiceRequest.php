<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    /**
     * The attributes that are datetime timestamps.
     *
     * @var array
     */
    protected $dates = ['completed_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_seller_id', 'buyer_id', 'location_id', 'description', 'completed_at'
    ];

    /**
     * Get the location for the service request.
     */
    public function location()
    {
        return $this->belongsTo('App\Models\CityArea', 'city_area_id', 'id');
    }

    /**
     * Get the service for the service request.
     */
    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    /**
     * Get the answers for the service request.
     */
    public function answers()
    {
        return $this->hasMany('App\Models\ServiceRequestAnswer', 'request_id', 'id');
    }


    /**
     * Get the user that owns the service request.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * Get the quote record associated with the service request.
     */
    public function quote()
    {
        return $this->hasOne('App\Models\ServiceRequestQuote', 'request_id', 'id');
    }

    /**
     * Get the invoice records associated with the service request.
     */
    public function invoices()
    {
        return $this->hasMany('App\Models\ServiceRequestInvoice', 'request_id', 'id');
    }
}
