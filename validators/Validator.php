<?php
require_once __DIR__.'/ValidationError.php';

class Validator {

    public $errors = [];

    /**
     * Check that the question's answer value is one of the options
     * @param $value string
     * @param $options QuestionOption[]
     * @return bool
     */
    protected static function isValidOption($value, $options) {
        if($value == null || $value == '')
            return true;
        foreach ($options as $option) {
            if($option->value == $value)
                return true;
        }
        return false;
    }

    /**
     * Returns false if input is not a valid integer
     * @param $value string
     * @return int|bool
     */
    protected static function getIntegerValue($value) {
        if($value == null || $value == "")
            return 0;
        return filter_var($value, FILTER_VALIDATE_INT);
    }

    /**
     * @param $code string
     * @param $message string
     */
    protected function addError($code, $message) {
        $this->errors[] = new ValidationError($code, $message);
    }
}