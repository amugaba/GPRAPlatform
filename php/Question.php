<?php

class Question
{
    public $id;
    public $assessment_type;
    public $section;
    public $code;
    public $label;
    public $type;
    public $option_set;
    //public $prepopulated_value; //this probably isn't needed in model, the front end can set any prepopulated values
    public $required;
    public $default_value;
    public $class = Question::class;

    public function fill($dbobj)
    {
        $this->id = isset($dbobj->id) ? intval($dbobj->id) : null;
        $this->assessment_type = isset($dbobj->assessment_type) ? intval($dbobj->assessment_type) : null;
        $this->section = isset($dbobj->section) ? intval($dbobj->section) : null;
        $this->code = isset($dbobj->code) ? $dbobj->code : null;
        $this->label = isset($dbobj->label) ? $dbobj->label : null;
        $this->type = isset($dbobj->type) ? $dbobj->type : null;
        $this->option_set = isset($dbobj->option_set) ? $dbobj->option_set : null;
        //$this->prepopulated_value = isset($dbobj->prepopulated_value) ? $dbobj->prepopulated_value : null;
        $this->required = isset($dbobj->required) ? intval($dbobj->required) : null;
        $this->default_value = isset($dbobj->default_value) ? $dbobj->default_value : null;
    }
}