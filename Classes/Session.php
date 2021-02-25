<?php

    final class Session
    {
        public const USER_ID_SESSION = "USER_ID";
        # public const _SESSION = "token";
        public function __construct()
        {
            session_start();
        }
        public function destroyAllSessions() : void
        {
            session_destroy();
        }
        public function setSession(string $sessionKey, string $sessionValue) : void
        {
            $_SESSION[$sessionKey] = $sessionValue;
        }
        public function getSession(string $sessionKey) : mixed
        {
            return $_SESSION[$sessionKey];
        }
    }