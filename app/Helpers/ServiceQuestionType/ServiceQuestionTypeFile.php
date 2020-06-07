<?php


namespace App\Helpers\ServiceQuestionType;

use App\Models\ServiceRequestAnswerFile;
use Form;
use Illuminate\Support\HtmlString;

class ServiceQuestionTypeFile extends ServiceQuestionType
{
    public function __construct()
    {
        parent::__construct(ServiceQuestionType::TYPES[self::class]);
    }

    public static function getHtml($name, $value = null, $is_required = false, $options = ['class' => 'form-control'], $selectList = []): HtmlString
    {
        parent::handleIsRequired($options, $is_required);
        return Form::file($name, $options);
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

        array_push($this->rules, 'image');
        $this->rules[$name][] = "image";
        $this->rules[$name][] = "max:15000";

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

        if (isset($options['path'])) {
            $path = $answer->store($options['path']);
            $answers[] = ServiceRequestAnswerFile::create(['file_path' => $path]);
        }

        return $answers;
    }
}
