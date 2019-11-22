<?php

class User
{
	public $id;
    public $name;
    public $username;
    public $email;
    public $admin;
    public $facility;
    public $last_login;
    public $invalid_logins;
    public $last_reset;

    public const ADMIN = 'admin';
    public const USER = 'user';

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