<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    const STATUS_NEW = 'new';
//    const STATUS_NEW = 'paid';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELED = 'canceled';
    const STATUS_DISPUTED = 'disputed';

    const STATUSES = [
        self::STATUS_NEW,
//        self::STATUS_NEW,
        self::STATUS_CONFIRMED,
        self::STATUS_COMPLETED,
        self::STATUS_CANCELED,
        self::STATUS_DISPUTED,
    ];

    /**
     * The attributes that are datetime timestamps.
     *
     * @var array
     */
    protected $dates = [
        'completed_at',
        'paid_at',
        'confirmed_at',
        'canceled_at',
        'disputed_at',
        'reviewed_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_seller_id',
        'service_id',
        'seller_id',
        'buyer_id',
        'location_id',
        'status',
        'description',
        'total_amount',

        'shipping_phone',
        'shipping_address',
        'shipping_location_id',
        'charge_id',
        'receipt_email',
        'paid_at',
        'completed_at',
        'canceled_at',
        'confirmed_at',
        'disputed_at',
        'reviewed_at',
    ];

    /**
     * Get the location for the service request.
     */
    public function location()
    {
        return $this->belongsTo('App\Models\CityArea', 'location_id', 'id');
    }

    /**
     * Get the location for the service request.
     */
    public function shipping_location()
    {
        return $this->belongsTo('App\Models\CityArea', 'shipping_location_id', 'id');
    }

    /**
     * Get the service for the service request.
     */
    public function service_seller()
    {
        return $this->belongsTo('App\Models\ServiceSeller');
    }

    /**
     * Get the service for the service request.
     */
    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    /**
     * Get the service for the service request.
     */
    public function seller()
    {
        return $this->belongsTo('App\Models\Seller');
    }

    /**
     * Get the answers for the service request.
     */
    public function answers()
    {
        return $this->hasMany('App\Models\ServiceRequestAnswer', 'request_id', 'id');
    }

    /**
     * Get the buyer that owns the service request.
     */
    public function buyer()
    {
        return $this->belongsTo('App\Models\Buyer', 'buyer_id', 'id');
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
     * Get the review for the service request.
     */
    public function review()
    {
        return $this->hasOne(ServiceSellerReview::class, 'service_request_id', 'id');
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

    public function scopeCompleted()
    {
        $this->where('status', self::STATUS_COMPLETED);
    }
}
