<?php
/**
 * Class Session
 * Handles session variables
 */

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
     * @return Grant|null
     */
    static function getGrant() {
        if(isset($_SESSION['grant']))
            return $_SESSION['grant'];
        return null;
    }
    /**
     * @param Grant $grant
     */
    static function setGrant(Grant $grant) {
        $_SESSION['grant'] = $grant;
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
        $obj->grant = self::getGrant();
        $obj->client = self::getClient();
        $obj->assessment = self::getAssessment();
        return $obj;
    }
}