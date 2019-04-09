<?php
/**
 * Route dem files
 */


require_once "model/config.php";

$uri = $_SERVER['REQUEST_URI']; //this is the base URL + the query string
$method = $_SERVER['REQUEST_METHOD'];//GET or POST

//remove base directory, remove trailing slash, and split into parts
$uri = str_replace("/GPRAPlatform/", "", $uri);
$uri = rtrim($uri, '/');
$parts = explode('/', $uri);
foreach ($parts as &$part) {
    $part = strtolower($part);
}

$controller = $parts[0] ?? invalidRoute();
$action = $parts[1] ?? invalidRoute();
$parameters = null;
if (count($parts) > 2) {
    $parameters = array_splice($parts, 2);
}

if ($controller === 'gpra') {
    require_once dirname(__FILE__) . '/controller/GPRAController.php';
    $controller = new GPRAController($method, $action, $parameters);
    $controller->processRequest();
} else {
    invalidRoute();
}

function invalidRoute() {
    header('HTTP/1.0 403 Forbidden');
    die('<h1>Forbidden</h1><p>You do not have permission to access this file.</p>');
}