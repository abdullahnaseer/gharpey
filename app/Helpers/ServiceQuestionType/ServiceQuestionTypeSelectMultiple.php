<?php


namespace App\Helpers\ServiceQuestionType;

use App\Models\ServiceQuestionChoices;
use App\Models\ServiceRequestAnswerChoice;
use Form;
use Illuminate\Support\HtmlString;

class ServiceQuestionTypeSelectMultiple extends ServiceQuestionType
{
    public function __construct()
    {
        parent::__construct(ServiceQuestionType::TYPES[self::class]);
    }

    public static function getHtml($name, $value = null, $is_required = false, $options = ['class' => 'form-control'], $selectList = []): HtmlString
    {
        parent::handleIsRequired($options, $is_required);
        parent::handleMultiple($options);
//        return Form::select($name . '[]', $selectList, $value, $options);

        $html = "";
        if(!empty($selectList))
        {
            foreach ($selectList as $choice)
            {
                $html .= "<div class=\"checkbox\">";
                $html .= "<label for=\"".$name."\">";
                $html .= Form::checkbox($name. '[]', $choice->id, null, ['class' => '']);
//                $html .= "<input class=\"form-check-input\" type=\"radio\" name=\"exampleRadios\" id=\"exampleRadios1\" value=\"option1\" checked>";
                $html .= "&nbsp;" . $choice->choice . (empty($choice->price_change) ? '' : ( '  <span class="'. ($choice->price_change > 0 ? 'text-danger' : 'text-success') .'">[' . 'RS.' . $choice->price_change . ']</span>' ) );
                $html .= "</label>";
                $html .= "</div>";
            }
        }
        return new HtmlString($html);
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

        $this->rules[$name][] = "array";
        $this->rules[$name . "*"][] = "integer";
        $this->rules[$name . "*"][] = "exists:service_question_choices,id";

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

        foreach ($answer as $vd)
        {
            $choice = ServiceQuestionChoices::find($vd);
            if(!is_null($choice))
                $answers[] = ServiceRequestAnswerChoice::create([
                    'choice_id' => $choice->id,
                    'choice' => $choice->choice,
                    'price_change' => $choice->price_change,
                ]);
        }

        return $answers;
    }
}
