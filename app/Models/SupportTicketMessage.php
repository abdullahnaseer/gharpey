<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicketMessage extends Model
{
    protected $fillable = ['message'];

    /**
     * Get the messages for support ticket.
     */
    public function files()
    {
        return $this->hasMany(\App\Models\SupportTicketMessageFile::class);
    }
}
