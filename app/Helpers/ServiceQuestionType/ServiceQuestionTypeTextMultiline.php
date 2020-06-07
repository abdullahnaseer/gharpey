<?php


namespace App\Helpers\ServiceQuestionType;

use App\Models\ServiceRequestAnswerText;
use App\Models\ServiceRequestAnswerTextMultiline;
use App\Models\ServiceRequestAnswerTime;
use Form;
use Illuminate\Support\HtmlString;

class ServiceQuestionTypeTextMultiline extends ServiceQuestionType
{
    public function __construct()
    {
        parent::__construct(ServiceQuestionType::TYPES[self::class]);
    }

    public static function getHtml($name, $value = null, $is_required = false, $options = ['class' => 'form-control'], $selectList = []): HtmlString
    {
        parent::handleIsRequired($options, $is_required);
        return Form::textarea($name, $value, $options);
    }

    /**
     * Get Validation Rules.
     *
     * @param $is_required
     * @return array
     */
    public function getRules($is_required = true, $name): array
    {
        parent::getRules($is_required, $name);

        $this->rules[$name][] = "string";
        $this->rules[$name][] = "max:1000";

        return $this->rules;
    }

    /**
     * Save Answer.
     *
     * @param $answer
     * @param array $options
     * @return array
     */
    public function saveAnswer($answer, $options = []) : array
    {
        $answers[] = ServiceRequestAnswerTextMultiline::create(['answer' => $answer]);

        return $answers;
    }
}
