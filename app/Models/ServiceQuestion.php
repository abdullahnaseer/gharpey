<?php

namespace App\Models;

use App\Casts\ServiceQuestionAuthRuleCast;
use App\Helpers\DefaultServiceQuestionsTrait as DefaultServiceQuestions;
use App\Casts\ServiceQuestionTypeCast;
use Illuminate\Database\Eloquent\Model;

class ServiceQuestion extends Model
{
    use DefaultServiceQuestions;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'auth_rule' => ServiceQuestionAuthRuleCast::class,
        'type' => ServiceQuestionTypeCast::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_priority', 'name', 'question', 'placeholder', 'type', 'auth_rule'
    ];

    /**
     * The services that belong to the service question.
     */
    public function services()
    {
        return $this->belongsToMany('App\Models\Service', 'service_question', 'service_id', 'question_id');
    }

    /**
     * Get the choices for the question.
     */
    public function choices()
    {
        return $this->hasMany('App\Models\ServiceQuestionChoices', 'question_id');
    }

    /**
     * Get the answers for the question.
     */
    public function answers()
    {
        return $this->hasMany('App\Models\ServiceAnswer', 'question_id');
    }


    /**
     * The rules that belong to the question.
     */
    public function rules()
    {
        return $this->belongsToMany('App\Models\ServiceQuestionValidationRule', 'service_question_validation_rule', 'question_id', 'rule_id')
            ->withPivot('value');
    }
}
