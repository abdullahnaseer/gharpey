<?php


namespace App\Helpers\ServiceQuestionValidationRule;

class Video extends ServiceQuestionValidationRule
{
    /**
     * @return string
     */
    public function getValidatorRule()
    {
        return 'video';
    }

    /**
     * @return array|string
     */
    public function message()
    {
        return "The <b>$this->name</b> must be valid video file.";
    }
}
