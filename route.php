<?php
/**
 * Route dem files
 */


require_once "model/config.php";






$uri = $_SERVER['REQUEST_URI']; //this is the base URL + the query string
$method = $_SERVER['REQUEST_METHOD'];//GET or POST

//remove base directory, remove trailing slash, and split into parts
//$uri = str_replace("/GPRAPlatform/", "", $uri);
$uri = trim($uri, '/');
$parts = explode('/', $uri);
foreach ($parts as &$part) {
    $part = strtolower($part);
}

if($parts[0] == null || $parts[0] == '' || $parts[0] == 'index.php')
    $controller = 'home';
else
    $controller = $parts[0];
$action = $parts[1] ?? 'view';
$parameters = null;
if (count($parts) > 2) {
    $parameters = array_splice($parts, 2);
}

if ($controller === 'home') {
    require_once __DIR__ . '/controller/HomeController.php';
    $controller = new HomeController($method, $action, $parameters);
    $controller->processRequest();
}
else if ($controller === 'gpra') {
    require_once __DIR__ . '/controller/GPRAController.php';
    $controller = new GPRAController($method, $action, $parameters);
    $controller->processRequest();
} else {
    invalidRoute();
}

function invalidRoute() {
    header('HTTP/1.0 403 Forbidden');
    die('<h1>Forbidden</h1><p>You do not have permission to access this file.</p>');
}