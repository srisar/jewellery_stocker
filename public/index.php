<?php

require_once "../bootstrap.php";

use Jman\Core\Router;

$url = $_SERVER['REDIRECT_URL'];
Router::route($url);