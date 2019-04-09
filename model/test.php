<?php

$obj = new stdClass();
$obj->prop = 7;

function passRef(&$prop) {
    $prop = $prop*11;
}

var_dump($obj);
passRef($obj->prop);
var_dump($obj);