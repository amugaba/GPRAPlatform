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
else {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ERROR);
}

//set session and error handlers
set_error_handler('globalErrorHandler', E_ALL ^ E_NOTICE);
set_exception_handler('globalExceptionHandler');

require_once 'Session.php';
session_start();
setcookie(session_name(),session_id(),time()+1800,'/','',true,true);

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
    echo htmlspecialchars($_SERVER["REQUEST_URI"]);
}
function return_self() {
    return htmlspecialchars($_SERVER["REQUEST_URI"]);
}

function isAdmin() {
    if(Session::getUser())
        return Session::getUser()->hasPermission(User::ADMIN);
    return false;
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
 * For Production, redirect user to error page and log error.
 * @param Exception $ex
 */
function globalExceptionHandler ($ex) {
    try {
        ob_end_clean();
        $msg = '<b>' . get_class($ex) . ' (' . $ex->getCode() . ')</b> thrown in <b>' . $ex->getFile() . '</b> on line <b>'
            . $ex->getLine() . '</b><br>' . $ex->getMessage()
            . str_replace('#', '<br>#', $ex->getTraceAsString()) . '<br>';

        $ds = DataService::getInstance();
        $ds->logException($msg);

        if (DEBUG) {
            echo $msg;
        } else {
            if(Session::getUser() != null)
                header("Location: /error");
            else
                header("Location: /login/error");
        }
    }
    catch (Exception $e) {
        if(Session::getUser() != null)
            header("Location: /error");
        else
            header("Location: /login/error");
    }
}