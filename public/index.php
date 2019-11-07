<?php
if(strpos($_SERVER['HTTP_HOST'], "localhost") !== false) {
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../helpers.php';
    require_once __DIR__ . '/../model/config.php';
    require_once __DIR__ . '/../routes.php';
}
else {
    require_once __DIR__ . '/../app/vendor/autoload.php';
    require_once __DIR__ . '/../app/helpers.php';
    require_once __DIR__ . '/../app/model/config.php';
    require_once __DIR__ . '/../app/routes.php';
}

use Pecee\SimpleRouter\SimpleRouter as Router;
Router::start();
