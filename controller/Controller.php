<?php
/**
 * Created by PhpStorm.
 * User: tiddd
 * Date: 4/8/2019
 * Time: 5:13 PM
 */
require_once dirname(__FILE__) . "/../model/DataService.php";
require_once dirname(__FILE__) . "/../view/View.php";
require_once dirname(__FILE__) . '/../model/Result.php';

class Controller
{
    protected $method;
    protected $action;
    protected $parameters;

    public function __construct($method, $action, $parameters)
    {
        $this->method = $method;
        $this->action = $action;
        $this->parameters = $parameters;
    }

    public function processRequest() {
    }
}