<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question_title',
        'question_description',
        'answer_description',
        'buyer_id',
        'item_id',
        'item_type',
    ];

    /**
     * Get the buyer that owns the question.
     */
    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'id');
    }

    /**
     * Get the owning item model.
     */
    public function item()
    {
        return $this->morphTo();
    }
}
