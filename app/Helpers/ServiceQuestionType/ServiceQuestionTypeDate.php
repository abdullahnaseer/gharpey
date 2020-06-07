<?php


namespace App\Helpers\ServiceQuestionType;

use App\Models\ServiceRequestAnswerDate;
use Carbon\Carbon;
use Form;
use Illuminate\Support\HtmlString;

class ServiceQuestionTypeDate extends ServiceQuestionType
{
    public function __construct()
    {
        parent::__construct(ServiceQuestionType::TYPES[self::class]);
    }

    public static function getHtml($name, $value = null, $is_required = false, $options = ['class' => 'form-control'], $selectList = []): HtmlString
    {
        parent::handleIsRequired($options, $is_required);
        return Form::input('date', $name, $value, $options);
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

        $this->rules[$name][] = 'date';
        $this->rules[$name][] = 'after:today';
        $this->rules[$name][] = "before:" . Carbon::today()->addMonths(12)->toDateString();

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
        $answers[] = ServiceRequestAnswerDate::create(['answer' => Carbon::parse($answer)]);

        return $answers;
    }
}

