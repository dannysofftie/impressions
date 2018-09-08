<?php

// server is offline when this is true
$offline =  preg_match('/(tekiria.net|127.0.0.1|localhost)/', $_SERVER['HTTP_HOST']);

if ($offline == 1) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// app settings
define('OFFLINE', $offline == 1);

// database configurations
define('DB_HOST', $offline ? '127.0.0.1' : '');
define('DB_PASSWORD', $offline ? '25812345Dan' : '');
define('DB_USER', $offline ? 'root' : '');
define('DB_NAME', $offline ? 'tekiriastore' : '');
define('DB_DRIVER', 'mysql');

// application level configurations
define('ROOT_PATH', '/');
define('ROOT_URL', $_SERVER['HTTP_HOST']);
define('HTTP_PROTOCOL', $_SERVER['REQUEST_SCHEME']);

// kijani configs
define('APP_EMAIL_ADDRESS', 'noreply.adexchange@gmail.com');
define('APP_EMAIL_PASSWORD', '25812345Dan');
