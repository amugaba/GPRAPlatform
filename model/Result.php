<?php

class Result
{
    public $success;
    public $data; //used for messages as well

    public function __construct($success, $data = null)
    {
        $this->success = $success;
        $this->data = $data;
    }
}