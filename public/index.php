<?php

require_once "../bootstrap.php";

use Jman\Core\Router;

//var_dump($_SERVER['REDIRECT_URL']);
//
////die();

$url = $_SERVER['REDIRECT_URL'];

error_log($url);

Router::route($url);