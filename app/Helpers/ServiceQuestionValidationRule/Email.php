<?php


namespace App\Helpers\ServiceQuestionValidationRule;


class Email extends ServiceQuestionValidationRule
{
    /**
     * @return string
     */
    public function getValidatorRule()
    {
        return 'email';
    }

    /**
     * @return array|string
     */
    public function message()
    {
        return "The <b>$this->name</b> must be valid email.";
    }
}
