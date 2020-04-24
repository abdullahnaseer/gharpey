<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceQuestionValidationRule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rule', 'laravel_rule', 'html_rule'
    ];

}
