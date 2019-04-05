<?php

class Result
{
    public $success;
    public $msg;
    public $data;

    public function __construct($success, $message, $data = null)
    {
        $this->success = $success;
        $this->msg = $message;
        $this->data = $data;
    }
}