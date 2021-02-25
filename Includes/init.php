<?php
    ob_start();
    if (!(defined('ROOT_PATH'))) {
        define("ROOT_PATH", '/opt/lampp/htdocs/EnglishProject');
    }
    if (!(defined('LOGIN_SUCCESSFUL_MESSAGE'))) {
        define('LOGIN_SUCCESSFUL_MESSAGE', 'success');
    }
    if (!(defined('LOGIN_ERROR_MESSAGE'))) {
        define('LOGIN_ERROR_MESSAGE', 'error');
    }
    spl_autoload_register(fn (string $className) => require_once ROOT_PATH . "/Classes/$className.php");
    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);