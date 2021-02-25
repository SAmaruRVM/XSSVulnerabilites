<?php
    final class User extends Database implements JsonSerializable
    {
        private string $_username;
        private string $_image;
        private int $_ID;
        private array $_posts;
        protected static string $storedProcedureGetAll = "sp_getAllUsers";
        protected static string $storedProcedureGetByID = "sp_getUserByID";
        public function __construct(int $userID, string $username)
        {
            #$user = parent::getByID($userID);
            $this->_ID = $userID;
            $this->_username = $username;
            $this->_image = "userPlaceholder.png";
        }
        public function getUsername() : string
        {
            return $this->_username;
        }
        public function getPosts() : array
        {
            return $this->_posts;
        }
        public function getImage() : string
        {
            return $this->_image;
        }
        public function getID() : int
        {
            return $this->_ID;
        }
        public function setImage(string $image) : void
        {
            $this->_image = $image;
        }
        public function updateToken(string $token) : void
        {
            $preparedStmt = parent::getConnection()->prepare("UPDATE users SET user_authenticationToken = ? WHERE user_id = ?");
            $preparedStmt->execute([
                $token,
                $this->_ID
            ]);
        }
        public function insert() : void
        {
        }
        public function delete() : void
        {
        }
        public static function getUserByID(int $ID) : ?self
        {
            $user = parent::getByID($ID);
            if ($user === null) {
                return null;
            }
            return new self($user->user_id, $user->user_username);
        }
        public static function getByToken(string $token) : ?self
        {
            $preparedStmt = parent::getConnection()->prepare("SELECT * FROM users WHERE user_authenticationToken = ?");
            $preparedStmt->execute([
                $token
            ]);
            $user = $preparedStmt->fetch(PDO::FETCH_OBJ);
            return (($preparedStmt->rowCount() > 0)) ? new self($user->user_id, $user->user_username) : null;
        }
        public static function verifyCredentials(string $username, string $password) : ?self
        {
            $preparedStmt = parent::getConnection()->prepare("SELECT * FROM users WHERE user_username = ?");
            $preparedStmt->execute([
                $username
            ]);
            $user = $preparedStmt->fetch(PDO::FETCH_OBJ);
            return ((password_verify($password, $user->user_password))) ? new self($user->user_id, $user->user_username) : null;
        }
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
    }