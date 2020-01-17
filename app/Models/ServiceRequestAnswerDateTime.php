<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequestAnswerDateTime extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'answer'
    ];

    /**
     * Get all of the answers.
     */
    public function answer()
    {
        return $this->morphMany('App\Models\ServiceRequestAnswer', 'answer');
    }
}
