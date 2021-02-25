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
    if (isset($_POST['action']) && strcasecmp($_POST['action'], 'login') === 0) {
        $isFormValid = true;
        $username = trim(strip_tags($_POST['login_username_submit']));
        $password = trim($_POST['login_password_submit']);

        if ((empty($username)) || (empty($password))) {
            $isFormValid = false;
        }
        if ((($user = User::verifyCredentials($username, $password)) !== null) && ($isFormValid)) {
            $authenticationToken = bin2hex(random_bytes(32));
            Cookie::setLoggedIN($user->getID(), $authenticationToken);
            $user->updateToken($authenticationToken);
            echo LOGIN_SUCCESSFUL_MESSAGE;
        } else {
            echo LOGIN_ERROR_MESSAGE;
        }
    }