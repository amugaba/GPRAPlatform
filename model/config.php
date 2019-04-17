<?php
/**
 * Include this file at the beginning of all pages.
 *
 * It sets environment variables, starts session, and contains utility functions such as
 * importing header and footer.
 */

if(strpos($_SERVER['HTTP_HOST'], "localhost") !== false) {
    define("DEBUG",true);
    define("HTTP_ROOT", "http://".$_SERVER['HTTP_HOST']);
}
else {
    define("DEBUG",false);
    define("HTTP_ROOT", "https://" . $_SERVER['HTTP_HOST']);
}

if(DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL ^ E_NOTICE);
}

//set session and error handlers
set_error_handler('globalErrorHandler', E_ALL ^ E_NOTICE);
set_exception_handler('globalExceptionHandler');
ini_set("session.cache_expire", 12000); //3+h
ini_set("session.gc_maxlifetime", 12000); //3+h
require_once 'Session.php';
session_start();
date_default_timezone_set('America/New_York');

function include_styles() {
    require __DIR__ . "/../inc/styles.php";
}
function include_js() {
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
function include_header() {
    include __DIR__ . "/../inc/navbar.php";
}
function include_header_no_nav() {
    include __DIR__ . "/../inc/header-no-nav.php";
}
function include_footer() {
    include __DIR__ . "/../inc/footer.php";
}

function echo_self() {
    $str = htmlspecialchars($_SERVER["PHP_SELF"]);
    if($_SERVER['QUERY_STRING'] != '')
        $str .= '?'.htmlspecialchars($_SERVER["QUERY_STRING"]);
    echo $str;
}
function return_self() {
    $str = htmlspecialchars($_SERVER["PHP_SELF"]);
    if($_SERVER['QUERY_STRING'] != null && $_SERVER['QUERY_STRING'] != '')
        $str .= '?'.$_SERVER["QUERY_STRING"];
    return $str;
}
function check_login() {
    if(Session::getUser() == null)
        header("location: ".HTTP_ROOT."login.php");
}
function check_admin() {
    if(!isAdmin())
        die("You must be an administrator to view this page. <a href='".HTTP_ROOT."login.php'>Log in</a>");
}
function isAdmin()
{
    if(Session::getUser())
        return Session::getUser()->hasPermission(User::ADMIN);
    return false;
}

function include_assessment_template($assessment_type, $section) {
    if($assessment_type == AssessmentTypes::GPRAIntake || $assessment_type == AssessmentTypes::GPRADischarge || $assessment_type == AssessmentTypes::GPRAFollowup) {
        include __DIR__."/../assessment-templates/gpra/section".$section.".html";
    }
}

/**
 * Class ErrorOrWarningException
 * The following is used to globally handle errors and exceptions
 */
class ErrorOrWarningException extends Exception
{
    protected $_Context = null;
    public function getContext()
    {
        return $this->_Context;
    }
    public function setContext( $value )
    {
        $this->_Context = $value;
    }

    public function __construct( $code, $message, $file, $line, $context )
    {
        parent::__construct( $message, $code );

        $this->file = $file;
        $this->line = $line;
        $this->setContext( $context );
    }
}

/**
 * Convert error to exception so that global exception handler handles it.
 * @param int $code
 * @param string $message
 * @param string|null $file
 * @param int|null $line
 * @param array|null $context
 * @return bool
 */
function globalErrorHandler ($code, $message, $file, $line, $context) {
    globalExceptionHandler(new ErrorException($message, $code, E_ERROR, $file, $line));
    return true;
}

/**
 * For Debug, print a readable error message and stack trace.
 * For Production, tell user that an error has occurred, log error, and email admin.
 * @param Exception $ex
 */
function globalExceptionHandler ($ex) {
    ob_end_clean();
    $msg = '<b>' . get_class($ex) . ' (' .  $ex->getCode() .')</b> thrown in <b>' . $ex->getFile() . '</b> on line <b>'
        . $ex->getLine(). '</b><br>' . $ex->getMessage()
        . str_replace('#','<br>#', $ex->getTraceAsString()).'<br>';

    if(DEBUG) {
        echo $msg;
    } else {
        //header("Location: ".HTTP_ROOT."error.php"); //not implemented yet
    }
}