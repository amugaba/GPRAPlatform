<?php

class Answer
{
    public $code;
    public $value;

    public function fill($dbobj)
    {
        $this->code = isset($dbobj->code) ? $dbobj->code : null;
        $this->value = isset($dbobj->value) ? $dbobj->value : null;
    }
}
