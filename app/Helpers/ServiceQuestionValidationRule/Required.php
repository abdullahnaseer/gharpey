<?php


namespace App\Helpers\ServiceQuestionValidationRule;

class Required extends ServiceQuestionValidationRule
{
    /**
     * @return string
     */
    public function getValidatorRule()
    {
        return 'required';
    }

    /**
     * @return array|string
     */
    public function message()
    {
        return "The <b>$this->name</b> is required.";
    }
}
