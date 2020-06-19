<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceSellerReview extends Model
{
    /**
     * Get the buyer that owns the review.
     */
    public function buyer()
    {
        return $this->belongsTo(\App\Models\Buyer::class);
    }

    /**
     * Get the service_seller that owns the review.
     */
    public function service_seller()
    {
        return $this->belongsTo(\App\Models\ServiceSeller::class);
    }

    /**
     * Get the service_request that owns the review.
     */
    public function service_request()
    {
        return $this->belongsTo(\App\Models\ServiceRequest::class);
    }
}
