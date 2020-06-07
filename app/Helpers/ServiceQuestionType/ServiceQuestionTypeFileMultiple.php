<?php


namespace App\Helpers\ServiceQuestionType;

use App\Models\ServiceRequestAnswerFile;
use Illuminate\Support\HtmlString;
use Form;

class ServiceQuestionTypeFileMultiple extends ServiceQuestionType
{
    public function __construct()
    {
        parent::__construct(ServiceQuestionType::TYPES[self::class]);
    }

    public static function getHtml($name, $value = null, $is_required = false, $options = ['class' => 'form-control'], $selectList = []): HtmlString
    {
        parent::handleIsRequired($options, $is_required);
        parent::handleMultiple($options);
        return Form::file($name . '[]', $options);
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
        $this->rules[$name][] = "max:10";

        $this->rules[$name . '.*'] = 'image|max:15000';

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
            foreach ($answer as $vd) {
                if (isset($vd)) {
                    $path = $vd->store($options['path']);
                    $answers[] = ServiceRequestAnswerFile::create(['file_path' => $path]);
                }
            }
        }

        return $answers;
    }
}
