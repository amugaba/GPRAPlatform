<?php

class Grant
{
    public $id;
    public $name;
    public $grantee;
    public $grantno;
    public $target;
    public $class = Grant::class;

    public function fill($dbobj)
    {
        $this->id = isset($dbobj->id) ? intval($dbobj->id) : null;
        $this->name = isset($dbobj->name) ? $dbobj->name : null;
        $this->grantee = isset($dbobj->grantee) ? $dbobj->grantee : null;
        $this->grantno = isset($dbobj->grantno) ? $dbobj->grantno : null;
        $this->target = isset($dbobj->target) ? intval($dbobj->target) : null;
    }
}