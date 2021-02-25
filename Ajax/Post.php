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
       if ((isset($_POST['action'])) && (strcasecmp($_POST['action'], 'insert') === 0)) {
           header("Content-Type: application/json; charset=UTF-8");
           $postContent = trim($_POST['post__content__submit']);
           $postToBeInserted = new Post(15, $_POST['post__content__submit'], User::getUserByID((new Session)->getSession(SESSION::USER_ID_SESSION)), null, null);
           $postToBeInserted->getUser()->setImage(ROOT_PATH . "/Admin/Images/{$postToBeInserted->getUser()->getImage()}");
           $postToBeInserted->insert();
           echo json_encode($postToBeInserted);
       }