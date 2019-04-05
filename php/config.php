<?php
/**
 * Include this file at the beginning of all pages.
 *
 * It sets environment variables, starts session, and contains utility functions such as
 * importing header and footer.
 */

if(strpos($_SERVER['HTTP_HOST'], "localhost") !== false) {
    define("DEBUG",true);
    define("HTTP_ROOT", "http://".$_SERVER['HTTP_HOST'] ."/GPRAPlatform/");
}
else {
    define("DEBUG",false);
    define("HTTP_ROOT", "https://" . $_SERVER['HTTP_HOST'] . "/GPRAPlatform/");
}

if(DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL ^ E_NOTICE);
}

set_error_handler('globalErrorHandler', E_ALL ^ E_NOTICE);
set_exception_handler('globalExceptionHandler');

define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT'] ."/GPRAPlatform/");
define("PAGE_TITLE", "GPRA Platform");

//session_save_path(ROOT_PATH."session");
ini_set("session.cache_expire", 12000); //3+h
ini_set("session.gc_maxlifetime", 12000); //3+h
require_once 'Session.php';
session_start();
date_default_timezone_set('America/New_York');

function include_styles() {
    $root = HTTP_ROOT;
    $debug = DEBUG ? 'true' : 'false';
    echo "
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src='//code.jquery.com/jquery-1.10.2.js'></script>
    <script src='//cdn.datatables.net/1.10.12/js/jquery.dataTables.js'></script>
    <script src='$root/libs/bootstrap.js'></script>
    <script src='$root/libs/vue.js'></script>
    <script src='$root/libs/moment.js'></script>
    <script src='$root/js/util.js'></script>
    <script src='$root/js/question-components.js'></script>
    <link rel='stylesheet' href='$root/css/app.css'>
    <link rel='stylesheet' href='$root/css/bootstrap.css'>
    <link rel='stylesheet' href='$root/libs/blue/style.css'>
    <link rel='stylesheet' href='//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css'>
    <script>
        HTTP_ROOT = '$root';
        DEBUG = $debug;
    </script>
    ";
}

function include_js() {
    if(DEBUG) {
        echo "
        <script src='https://code.jquery.com/jquery-3.3.1.js' integrity='sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=' crossorigin='anonymous'></script>
        <script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js' integrity='sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=' crossorigin='anonymous'></script>
        <script src='//cdn.datatables.net/1.10.19/js/jquery.dataTables.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/vue@2.6.8/dist/vue.js'></script>
        <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js' integrity='sha256-vvNL15qzI3rwnPrldX3MeOQDN0AJ/B4XItdVftTxjUA=' crossorigin='anonymous'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.js' integrity='sha256-thEUU1gJ8qPs7rO+Jr6jgIS6OwngnD8nS4RmcrpPt7U=' crossorigin='anonymous'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js' integrity='sha256-59IZ5dbLyByZgSsRE3Z0TjDuX7e1AiqW5bZ8Bg50dsU=' crossorigin='anonymous'></script>
        <script src='https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js'></script>";
    }
    else {
        echo "
        <script src='https://code.jquery.com/jquery-3.3.1.min.js' integrity='sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=' crossorigin='anonymous'></script>
        <script src='https://code.jquery.com/ui/1.12.1/jquery-ui.min.js' integrity='sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=' crossorigin='anonymous'></script>
        <script src='//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/vue@2.6.8/dist/vue.min.js'></script>
        <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js' integrity='sha256-tzkPfJgrAehd0mUYdxwWvn+TQrk2VjRJL/xP9iW5fhk=' crossorigin='anonymous'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.min.js' integrity='sha256-LVDb7bZSPhy4Arl17uHX9/FRFfhXRlbM0kXs1lNQTG4=' crossorigin='anonymous'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js' integrity='sha256-CutOzxCRucUsn6C6TcEYsauvvYilEniTXldPa6/wu0k=' crossorigin='anonymous'></script>
        <script src='https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js'></script>";
    }

    $root = HTTP_ROOT;
    $jroot = JAVA_HTTP_ROOT;
    $debug = DEBUG ? 'true' : 'false';
    $admin = isAdmin() ? 'true' : 'false';
    $session = json_encode(Session::copy());
    echo "
        <!--<script src='$root/js/vee-validate.js'></script>
        <script src='$root/js/vuejs-datepicker.js'></script>-->
        <script src='$root/js/util.js'></script>
        <script src='$root/js/pdf-helper.js'></script>
        <script>
            HTTP_ROOT = '$root';
            JAVA_HTTP_ROOT = '$jroot';
            DEBUG = $debug;
            const config = {
                classes: true
            };
            //Vue.use(VeeValidate, config);
            //Vue.use(vuejsDatepicker);
            Vue.prototype.isAdmin = $admin;
            Vue.prototype.hostname = '$root';
            Vue.prototype.session = $session;
        </script>
    ";
}

function include_header() {
    include ROOT_PATH."inc/navbar.php";
}
function include_footer() {
    include ROOT_PATH."inc/footer.php";
}
function echo_self() {
    $str = htmlspecialchars($_SERVER["PHP_SELF"]);
    if($_SERVER['QUERY_STRING'] != '')
        $str .= '?'.htmlspecialchars($_SERVER["QUERY_STRING"]);
    echo $str;
}

function check_login() {
    if(!isset($_SESSION['hiv_user_id']))    {
        header("Location: ".HTTP_ROOT."login.php");
        return false;
    }
    return true;
}
function check_admin() {
    if(!isset($_SESSION['hiv_admin']) || $_SESSION['hiv_admin']!=1)
        die("You must be an admin to view this page. <a href='".HTTP_ROOT."login.php'>Go here to log in.</a>");
}
function isAdmin()
{
    return isset($_SESSION['hiv_admin']) && $_SESSION['hiv_admin'] == 1;
}

function include_assessment_template($assessment_type, $section) {
    if($assessment_type == AssessmentTypes::GPRAIntake || $assessment_type == AssessmentTypes::GPRADischarge || $assessment_type == AssessmentTypes::GPRAFollowup) {
        include ROOT_PATH."assessment-templates/gpra/section".$section.".html";
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
    $msg = '<b>' . get_class($ex) . ' (' .  $ex->getCode() .')</b> thrown in <b>' . $ex->getFile() . '</b> on line <b>'
        . $ex->getLine(). '</b><br>' . $ex->getMessage()
        . str_replace('#','<br>#', $ex->getTraceAsString()).'<br>';

    if(DEBUG) {
        echo $msg;
    } else {
        //header("Location: ".HTTP_ROOT."error.php"); //not implemented yet
    }
}