<?php


namespace App\Helpers\ServiceQuestionType;

use Form;
use Illuminate\Support\HtmlString;

class ServiceQuestionTypeSelect extends ServiceQuestionType
{
    public function __construct()
    {
        parent::__construct(ServiceQuestionType::TYPES[self::class]);
    }

    public static function getHtml($name, $value = null, $is_required = false, $options = [], $selectList = []): HtmlString
    {
        parent::handleIsRequired($options, $is_required);
        return Form::select($name, $selectList, $value, $options);
    }
}