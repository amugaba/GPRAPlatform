<?php
/**
 * Created by PhpStorm.
 * User: tiddd
 * Date: 4/8/2019
 * Time: 5:23 PM
 */

class View
{
    const VIEW_PATH = __DIR__; //path to view files (same directory for now)
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
        $this->loadFlashData();
        $path = View::VIEW_PATH.'\\'.$this->filename;
        ob_start();
        if(file_exists($path))
        {
            include($path);
        }
        else {
            throw new Exception('View file not found: '.$path);
        }
        return ob_get_clean();
    }

    /**
     * Load flashed session data and then clear it
     */
    public function loadFlashData() {
        if(isset($_SESSION['flash'])) {
            foreach ($_SESSION['flash'] as $key => $value) {
                $this->$key = $value;
            }
        }
        $_SESSION['flash'] = [];
    }

    public function __set($k, $v) {
        $this->properties[$k] = $v;
    }
    public function __get($k) {
        return $this->properties[$k];
    }
}