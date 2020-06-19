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
    protected $dates = [
        'completed_at',
        'paid_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_seller_id',
        'buyer_id',
        'location_id',
        'description',
        'completed_at',
        'total_amount',

        'shipping_phone',
        'shipping_address',
        'shipping_location_id',
        'charge_id',
        'paid_at',
        'receipt_email'
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
    public function service_seller()
    {
        return $this->belongsTo('App\Models\ServiceSeller');
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


    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnpaid($query)
    {
        return $query->whereNull('paid_at');
    }
}
