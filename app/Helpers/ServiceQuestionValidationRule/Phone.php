<?php


namespace App\Helpers\ServiceQuestionValidationRule;

class Phone extends ServiceQuestionValidationRule
{
    /**
     * @return string
     */
    public function getValidatorRule()
    {
        return new \App\Rules\Phone();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Incorrect phone format for <b>$this->name</b>.';
    }

}
