<?php

class QuestionOption
{
    public $id;
    public $option_set_id;
    public $set_name;
    public $label;
    public $value;
    public $sequence;
    public $class = QuestionOption::class;

    public function fill($dbobj)
    {
        $this->id = isset($dbobj->id) ? intval($dbobj->id) : null;
        $this->option_set_id = isset($dbobj->option_set_id) ? intval($dbobj->option_set_id) : null;
        $this->set_name = isset($dbobj->set_name) ? $dbobj->set_name : null;
        $this->label = isset($dbobj->label) ? $dbobj->label : null;
        $this->value = isset($dbobj->value) ? $dbobj->value : null;
        $this->sequence = isset($dbobj->sequence) ? intval($dbobj->sequence) : null;
    }
}