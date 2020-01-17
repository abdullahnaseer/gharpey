<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequestAnswer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'request_id', 'question_id', 'answer_id', 'answer_type'
    ];

    /**
     * Get all of the owning answer models.
     */
    public function answer()
    {
        return $this->morphTo();
    }


    /**
     * Get the question for the answer.
     */
    public function question()
    {
        return $this->belongsTo('App\Models\ServiceQuestion');
    }
}
