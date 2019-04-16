<?php

class Episode
{
    public $id;
    public $client_id;
    public $number;
    public $start_date;
    public $closed;
    public $class = Episode::class;

    public function fill($dbobj)
    {
        $this->id = isset($dbobj->id) ? intval($dbobj->id) : null;
        $this->client_id = isset($dbobj->client_id) ? intval($dbobj->client_id) : null;
        $this->number = isset($dbobj->number) ? intval($dbobj->number) : null;
        $this->start_date = isset($dbobj->start_date) ? $dbobj->start_date : null;
        $this->closed = isset($dbobj->closed) ? intval($dbobj->closed) : null;
    }
}