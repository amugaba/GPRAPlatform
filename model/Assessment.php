<?php

class Assessment
{
    public $id;
    public $assessment_type; //determines its question set
    public $client_id;
    public $user_id;
    public $grant_id;
    public $episode_id;
    public $created_date;
    public $progress;
    public $status;
    //gpra only fields
    public $gpra_type; //determines GPRA business logic
    public $interview_conducted;
}