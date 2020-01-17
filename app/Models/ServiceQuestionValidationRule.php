<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceQuestionValidationRule extends Model
{
    const REQUIRED = 'required';
    const AUTH_REQUIRED = 'auth.required';
    const AUTH_GUEST = 'auth.guest';
    const AUTH_ANY = 'auth.any';
    const TEXT_EMAIL = 'text.email';
    const TEXT_PHONE = 'text.phone';
    const TEXT_LENGTH_MIN = 'text.length.min';
    const TEXT_LENGTH_MAX = 'text.length.max';
    const FILE_SIZE_MIN = 'file.size.min';
    const FILE_SIZE_MAX = 'file.size.max';
    const FILE_TYPE_IMAGE = 'file.type.image';
    const FILE_TYPE_VIDEO = 'file.type.video';

    const RULES = [
        self::REQUIRED,
        self::AUTH_REQUIRED,
        self::AUTH_GUEST,
        self::AUTH_ANY,
        self::TEXT_EMAIL,
        self::TEXT_PHONE,
        self::TEXT_LENGTH_MIN,
        self::TEXT_LENGTH_MAX,
        self::FILE_SIZE_MIN,
        self::FILE_SIZE_MAX,
        self::FILE_TYPE_IMAGE,
        self::FILE_TYPE_VIDEO,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rule', 'laravel_rule', 'html_rule'
    ];

}
