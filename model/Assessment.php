<?php

class Assessment
{
    public $id;
    public $assessment_type;
    public $client_id;
    public $user_id;
    public $grant_id;
    public $episode_id;
    public $created_date;
    public $progress;
    public $completed;
    public $class = Assessment::class;

    const STATUS_COMPLETE = 99;

    public function fill($dbobj)
    {
        $this->id = isset($dbobj->id) ? intval($dbobj->id) : null;
        $this->assessment_type = isset($dbobj->assessment_type) ? intval($dbobj->assessment_type) : null;
        $this->client_id = isset($dbobj->client_id) ? intval($dbobj->client_id) : null;
        $this->user_id = isset($dbobj->user_id) ? intval($dbobj->user_id) : null;
        $this->episode_id = isset($dbobj->episode_id) ? intval($dbobj->episode_id) : null;
        $this->created_date = isset($dbobj->created_date) ? $dbobj->created_date : null;
        $this->status = isset($dbobj->status) ? intval($dbobj->status) : null;
    }
}