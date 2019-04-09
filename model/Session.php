<?php
/**
 * Class Session
 * Handles session variables
 */
require_once 'User.php';//needed to store objects in session data
require_once 'Client.php';
require_once 'Assessment.php';

abstract class Session
{
    /**
     * @return User|null
     */
    static function getUser() {
        if(isset($_SESSION['user']))
            return $_SESSION['user'];
        return null;
    }
    /**
     * @param User $user
     */
    static function setUser(User $user) {
        $_SESSION['user'] = $user;
    }

    /**
     * @return Client|null
     */
    static function getClient() {
        if(isset($_SESSION['client']))
            return $_SESSION['client'];
        return null;
    }
    /**
     * @param Client $client
     */
    static function setClient(Client $client) {
        $_SESSION['client'] = $client;
    }

    /**
     * @return Assessment|null
     */
    static function getAssessment() {
        if(isset($_SESSION['assessment']))
            return $_SESSION['assessment'];
        return null;
    }
    /**
     * @param Assessment $assessment
     */
    static function setAssessment(Assessment $assessment) {
        $_SESSION['assessment'] = $assessment;
    }

    /**
     * Create a copy of the session as an object
     * @return stdClass
     */
    static function copy() {
        $obj = new stdClass();
        $obj->user = self::getUser();
        $obj->client = self::getClient();
        $obj->assessment = self::getAssessment();
        return $obj;
    }
}