<?php


namespace App\Helpers\ServiceQuestionType;

use App\Models\ServiceRequestAnswerChoice;
use App\Rules\Phone;
use Form;
use Illuminate\Support\HtmlString;

class ServiceQuestionTypeSelect extends ServiceQuestionType
{
    public function __construct()
    {
        parent::__construct(ServiceQuestionType::TYPES[self::class]);
    }

    public static function getHtml($name, $value = null, $is_required = false, $options = ['class' => 'form-control'], $selectList = null): HtmlString
    {
        parent::handleIsRequired($options, $is_required);
        if(!empty($selectList))
        {
            $selectList = $selectList->pluck('choice', 'id');
        }

        return Form::select($name, $selectList, $value, $options);
    }

    /**
     * Get Validation Rules.
     *
     * @param $is_required
     * @param array $options
     * @return array
     */
    public function getRules($is_required = true, $name): array
    {
        parent::getRules($is_required, $name);

        $this->rules[$name][] = "integer";
        $this->rules[$name][] = "exists:service_question_choices,id";

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
        $answers = [];

        $answers[] = ServiceRequestAnswerChoice::create(['choice_id' => $answer]);

        return $answers;
    }
}
