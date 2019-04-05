<?php

class ValidationError {
    public $item_id;
    public $message;

    public function __construct($item_id, $message)
    {
        $this->item_id = $item_id;
        $this->message = $message;
    }
}