<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequestAnswerChoice extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'choice_id'
    ];

    /**
     * Get all of the answers.
     */
    public function answers()
    {
        return $this->morphedByMany('App\Models\ServiceRequestAnswer', 'answer');
    }

    /**
     * Get the post that owns the comment.
     */
    public function choice()
    {
        return $this->belongsTo('App\Models\ServiceQuestionChoices', 'choice_id');
    }
}
