<?php

/**
 * This file is used to store passwords and keys. It should not be added to Git.
 * AccessManager.example.php is added to git instead with blank data.
 *
 * Enter your MySQL database connection info below.
 * Username and password are for the user account your created with privileges
 * to edit the database
 * Server is the MySQL server location.
 * Databasename is the name of the schema you created.
 * Port is the port used to connect to the MySQL database.
 * @author tiddd
 */

class AccessManagerExample
{
    private $production = false;
    public $port = "3306";

    public function __construct ()
    {
        if($this->production) {
            $this->username = "";
            $this->password = "";
            $this->server = "";
            $this->databasename = "";
        }
        else {
            $this->username = "";
            $this->password = "";
            $this->server = "";
            $this->databasename = "";
        }

        $this->mail_password = "";
    }
}