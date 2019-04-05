<?php

class Client
{
    public $id;
    public $uid; //ID assigned by program

    public function fill($dbobj)
    {
        $this->id = isset($dbobj->id) ? intval($dbobj->id) : null;
        $this->uid = isset($dbobj->uid) ? $dbobj->uid : null;
    }
}