<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequestInvoiceDetail extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id', 'detail', 'cost', 'quantity'
    ];


    /**
     * Get the invoice that owns the invoice detail.
     */
    public function invoice()
    {
        return $this->belongsTo('App\Models\ServiceRequestInvoice');
    }
}
