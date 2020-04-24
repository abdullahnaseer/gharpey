<?php


namespace App\Helpers\ServiceQuestionValidationRule;

class File extends ServiceQuestionValidationRule
{
    /**
     * @return string
     */
    public function getValidatorRule()
    {
        return 'file';
    }

    /**
     * @return array|string
     */
    public function message()
    {
        return "The <b>$this->name</b> must be valid file.";
    }
}
