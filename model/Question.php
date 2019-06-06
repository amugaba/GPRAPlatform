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
}