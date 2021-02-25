<?php
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
    if ((isset($_POST['action'])) && (strcasecmp($_POST['action'], 'logout') === 0)) {
        $cookie = new Cookie();
        $session = new Session();
        $cookie->logoutUser($cookie);
        $session->destroyAllSessions();
    }