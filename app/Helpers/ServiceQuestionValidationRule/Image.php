<?php


namespace App\Helpers\ServiceQuestionValidationRule;

class Image extends ServiceQuestionValidationRule
{
    /**
     * @return string
     */
    public function getValidatorRule()
    {
        return 'image';
    }

    /**
     * @return array|string
     */
    public function message()
    {
        return "The <b>$this->name</b> must be valid image file.";
    }
}
