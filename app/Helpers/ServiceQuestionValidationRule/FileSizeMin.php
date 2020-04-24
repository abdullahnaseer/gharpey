<?php


namespace App\Helpers\ServiceQuestionValidationRule;

class FileSizeMin extends ServiceQuestionValidationRule
{
    /**
     * @return string
     */
    public function getValidatorRule()
    {
        return $this->rule_value ? '' : 'min:' . $this->rule_value;
    }

    /**
     * @return array|string
     */
    public function message()
    {
        return "The <b>$this->name</b> file should be at least $this->rule_value KBs.";
    }
}
