<?php

    final class Post extends Database implements JsonSerializable
    {
        private User $_user;
        private string $_content;
        private ?string $_createdDate;
        private int $_ID;
        private ?int $_numberOfLikes;
        protected static string $storedProcedureGetAll = "sp_getAllPosts";
        protected static string $storedProcedureGetByID = "sp_getPostByID";
        protected static string $storedProcedureInsert = "sp_insertPost";
        public function __construct(int $id, string $content, User $user, ?int $numberOfLikes, ?string $createdDate)
        {
            $this->_ID = $id;
            $this->_content = $content;
            $this->_user = $user;
            $this->_numberOfLikes = $numberOfLikes ?? 0;
            $this->_createdDate = $createdDate;
        }
        public function getUser() : User
        {
            return $this->_user;
        }
        public function getContent() : string
        {
            return $this->_content;
        }
        public function getID() : int
        {
            return $this->_ID;
        }
        public function getNumberOfLikes() : int
        {
            return $this->_numberOfLikes;
        }
        public function insert() : void
        {
            $preparedStmt = parent::getConnection()->prepare(sprintf("CALL %s(?,?)", self::$storedProcedureInsert));
            $preparedStmt->execute([
                $this->_content,
                $this->_user->getID()
            ]);
        }
        public static function getPostByID(int $ID) : ?self
        {
            $post = parent::getByID($ID);
            if ($post === null) {
                return null;
            }
            return new self($post->post_id, $post->post_content, $post->post_userID, $post->post_numberOfLikes, $post->post_createdDate);
        }
        public function delete() : void
        {
        }
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
    }