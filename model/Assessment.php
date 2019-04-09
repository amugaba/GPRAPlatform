<?php

class Assessment
{
    public $id;
    public $assessment_type;
    public $client_id;
    public $user_id;
    public $episode_id;
    public $class = Assessment::class;

    public function fill($dbobj)
    {
        $this->id = isset($dbobj->id) ? intval($dbobj->id) : null;
        $this->assessment_type = isset($dbobj->assessment_type) ? intval($dbobj->assessment_type) : null;
        $this->client_id = isset($dbobj->client_id) ? intval($dbobj->client_id) : null;
        $this->user_id = isset($dbobj->user_id) ? intval($dbobj->user_id) : null;
        $this->episode_id = isset($dbobj->episode_id) ? intval($dbobj->episode_id) : null;
    }
}