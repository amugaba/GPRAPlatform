<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../model/config.php';

use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\Http\Url;
use Pecee\Http\Response;
use Pecee\Http\Request;

require_once '../routes.php';

Router::start();
