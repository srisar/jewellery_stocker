<?php
declare(strict_types=1);

require_once "vendor/autoload.php";
require_once "routes.php";

use Jman\Core\Database;
use Jman\Core\AppSession;

AppSession::init();

$config = [
    "host" => "localhost",
    "dbname" => "jewellery_stock",
    "user" => "jewellery_user",
    "pass" => "admin",
    "options" => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    ]
];

/**
 * Initializing static app assets
 */
Database::init($config);

/**
 * Defining the base path for accessing assets and other resources
 * from root path
 */
define('BASE_PATH', __DIR__);

/**
 * Base Upload path
 */

define('UPLOAD_PATH', __DIR__ . '/public/uploads');
define('PROFILE_UPLOAD_PATH', UPLOAD_PATH . '/profiles');

define('APP_NAME', 'Jewellery Manager');