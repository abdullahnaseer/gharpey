<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequestQuote extends Model
{
    /**
     * Get the service request that owns the quote.
     */
    public function quote()
    {
        return $this->belongsTo('App\Models\ServiceRequest', 'request_id', 'id');
    }
}
