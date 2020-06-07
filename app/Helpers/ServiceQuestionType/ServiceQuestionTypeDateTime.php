<?php


namespace App\Helpers\ServiceQuestionType;

use App\Models\ServiceRequestAnswerDateTime;
use Carbon\Carbon;
use Form;
use Illuminate\Support\HtmlString;

class ServiceQuestionTypeDateTime extends ServiceQuestionType
{
    public function __construct()
    {
        parent::__construct(ServiceQuestionType::TYPES[self::class]);
    }

    public static function getHtml($name, $value = null, $is_required = false, $options = ['class' => 'form-control'], $selectList = []): HtmlString
    {
        parent::handleIsRequired($options, $is_required);
        return Form::input('datetime', $name, $value, $options);
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

        $this->rules[$name][] = 'date_format:"Y-m-d\TH:i"'; // 2018-01-01T01:01

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
        $answers[] = ServiceRequestAnswerDateTime::create(['answer' => $answer]);

        return $answers;
    }
}
