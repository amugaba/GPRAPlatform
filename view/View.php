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
    private $sidebar_sections = [];

    public function __construct($filename) {
        $this->properties = array();
        $this->filename = $filename;
    }

    /**
     * @throws Exception
     */
    public function render(){
        $this->loadFlashData();
        $path = View::VIEW_PATH.'/'.$this->filename;
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

    public function addSidebarSection($filename) {
        $this->sidebar_sections[] = $filename;
    }
    public function includeSidebarSections() {
        foreach ($this->sidebar_sections as $filename) {
            $path = View::VIEW_PATH.'/'.$filename;
            if(file_exists($path))
            {
                include($path);
            }
            else {
                throw new Exception('Sidebar file not found: '.$path);
            }
        }
    }

    public function includeHeader() {
        include __DIR__ . "/../inc/navbar.php";
    }
    public function includeHeaderNoNav() {
        include __DIR__ . "/../inc/header-no-nav.php";
    }
    public function includeFooter() {
        include __DIR__ . "/../inc/footer.php";
    }
    function includeStyles() {
        require __DIR__ . "/../inc/styles.php";
    }
    function includeScripts() {
        require __DIR__ . "/../inc/scripts.php";

        //not sure if all of this is needed
        $root = HTTP_ROOT;
        $debug = DEBUG ? 'true' : 'false';
        $admin = isAdmin() ? 'true' : 'false';
        $session = json_encode(Session::copy());
        $csrf = csrf_token();
        echo "
        <script>
            HTTP_ROOT = '$root';
            DEBUG = $debug;
            Vue.prototype.isAdmin = $admin;
            Vue.prototype.hostname = '$root';
            Vue.prototype.session = $session;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '$csrf'
                }
            });
        </script>
    ";
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