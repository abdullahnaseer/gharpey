<?php


namespace App\Helpers\ServiceQuestionType;

use Illuminate\Support\HtmlString;

class ServiceQuestionTypeFileMultiple extends ServiceQuestionType
{
    public function __construct()
    {
        parent::__construct(ServiceQuestionType::TYPES[self::class]);
    }

    public static function getHtml($name, $value = null, $is_required = false, $options = [], $selectList = []): HtmlString
    {
        parent::handleIsRequired($options, $is_required);
        parent::handleMultiple($options);
        return Form::file($name, $options);
    }
}
