<?php

    final class Cookie
    {
        public const TOKEN_COOKIE = "token";
        public function IsLoggedIN() : ?User
        {
            if (!(isset($_COOKIE[self::TOKEN_COOKIE]))) {
                return null;
            }
            $user = User::getByToken($_COOKIE[self::TOKEN_COOKIE]);
            return $user ?? null;
        }
        public static function setLoggedIN(int $userID, string $authenticationToken) : ?stdClass
        {
            setcookie(self::TOKEN_COOKIE, $authenticationToken, (new DateTime("+1 day"))->getTimestamp(), '/', httponly: true);
            return User::getByID($userID);
        }
        public function logoutUser(Cookie &$cookie) : void
        {
            unset($_COOKIE[self::TOKEN_COOKIE]);
            setcookie(self::TOKEN_COOKIE, '', time() - 5000, '/', httponly: true);
            setcookie(self::TOKEN_COOKIE, '', time() - 5000);
            unset($cookie);
        }
    }