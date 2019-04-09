<?php

class User
{
	public $id;
    public $username;
    public $email;
    public $admin;
    public $facility;

    public const ADMIN = 'admin';
    public const USER = 'user';

    public function fill($dbobj)
    {
        $this->id = isset($dbobj->id) ? $dbobj->id : null;
        $this->username = isset($dbobj->username) ? $dbobj->username : null;
        $this->email = isset($dbobj->email) ? $dbobj->email : null;
        $this->admin = isset($dbobj->admin) ? $dbobj->admin : null;
        $this->facility = isset($dbobj->facility) ? $dbobj->facility : null;
    }

    /**
     * @param $security_level string
     * @return bool
     */
    public function hasPermission($security_level) {
        if($security_level == User::ADMIN)
            return $this->admin == 1;
        if($security_level == User::USER)
            return true;
        return false;
    }
}