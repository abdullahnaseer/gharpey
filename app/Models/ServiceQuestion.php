<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceQuestion extends Model
{
    const REQUIRED = 'required';
    const AUTH_REQUIRED = 'auth.required';
    const AUTH_GUEST = 'auth.guest';
    const AUTH_ANY = 'auth.any';

    const AUTH_RULES = [
        self::AUTH_ANY,
        self::AUTH_GUEST,
        self::AUTH_REQUIRED,
    ];

    const TYPE_TEXT = 'text';
    const TYPE_TEXT_MULTILINE = 'text.multiline';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_SELECT = 'select.single';
    const TYPE_SELECT_MULTIPLE = 'select.multiple';
    const TYPE_DATE = 'date';
    const TYPE_TIME = 'time';
    const TYPE_DATE_TIME = 'datetime';
    const TYPE_FILE = 'file';
    const TYPE_FILE_MULTIPLE = 'file.multiple';

    const TYPES = [
        self::TYPE_TEXT,
        self::TYPE_TEXT_MULTILINE,
        self::TYPE_BOOLEAN,
        self::TYPE_SELECT,
        self::TYPE_SELECT_MULTIPLE,
        self::TYPE_DATE,
        self::TYPE_TIME,
        self::TYPE_DATE_TIME,
        self::TYPE_FILE,
        self::TYPE_FILE_MULTIPLE,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_priority', 'title', 'question', 'type', 'is_locked', 'is_required', 'auth_rule'
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
