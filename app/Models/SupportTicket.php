<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = ['title'];

    /**
     * Get the owning user model.
     */
    public function user()
    {
        return $this->morphTo();
    }

    /**
     * Get the messages for support ticket.
     */
    public function messages()
    {
        return $this->hasMany(\App\Models\SupportTicketMessage::class);
    }
}
