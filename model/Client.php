<?php

class Client
{
    public $id;
    public $uid; //ID assigned by program
    public $gpra_id; //ID assigned by SPARS
    public $grant_id;

    public function fill($dbobj)
    {
        $this->id = isset($dbobj->id) ? intval($dbobj->id) : null;
        $this->uid = isset($dbobj->uid) ? $dbobj->uid : null;
        $this->gpra_id = isset($dbobj->gpra_id) ? $dbobj->gpra_id : null;
        $this->grant_id = isset($dbobj->grant_id) ? intval($dbobj->grant_id) : null;
    }
}