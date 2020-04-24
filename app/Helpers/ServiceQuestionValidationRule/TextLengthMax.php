<?php


namespace App\Helpers\ServiceQuestionValidationRule;

class TextLengthMax extends ServiceQuestionValidationRule
{
    /**
     * @return string
     */
    public function getValidatorRule()
    {
        return $this->rule_value ? 'max:10000' : 'max:' . $this->rule_value;
    }

    /**
     * @return array|string
     */
    public function message()
    {
        return "The <b>$this->name</b> should be at max $this->rule_value length.";
    }
}
