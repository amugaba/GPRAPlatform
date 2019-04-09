<?php
/**
 * Created by PhpStorm.
 * User: tiddd
 * Date: 4/8/2019
 * Time: 5:23 PM
 */

class View
{
    const VIEW_PATH = 'view/'; //path to view files (same directory for now)
    private $properties; //stores data view needs to render
    private $filename;

    public function __construct($filename) {
        $this->properties = array();
        $this->filename = $filename;
    }

    /**
     * @throws Exception
     */
    public function render(){
        $path = View::VIEW_PATH.$this->filename;
        //ob_start();
        if(file_exists($path))
        {
            include($path);
        }
        else {
            throw new Exception('View file not found.');
        }
        //return ob_get_clean();
    }

    public function __set($k, $v) {
        $this->properties[$k] = $v;
    }
    public function __get($k) {
        return $this->properties[$k];
    }
}