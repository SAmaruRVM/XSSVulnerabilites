<?php

    abstract class Database
    {
        private const DB_NAME = "xssTest";
        private const DB_HOST = "127.0.0.1";
        private const DB_USER = "root";
        private const DB_PASSWORD = "";
        private static PDO $_connection;
        protected static string $storedProcedureGetAll;
        protected static string $storedProcedureGetByID;
        public static function getAll() : array
        {
            self::getConnection();
            return self::$_connection->query(sprintf("CALL %s()", static::$storedProcedureGetAll))->fetchAll(PDO::FETCH_OBJ);
        }
        public static function getByID(int $ID) : ?stdClass
        {
            self::getConnection();
            $preparedStmt = self::$_connection->prepare((sprintf("CALL %s(?)", static::$storedProcedureGetByID)));
            $preparedStmt->execute([
                $ID
            ]);
            $returnObject = $preparedStmt->fetch(PDO::FETCH_OBJ);
            return ($preparedStmt->rowCount() > 0) ? $returnObject : null;
        }
        public static function getConnection() : PDO
        {
            if (!(isset(self::$_connection))) {
                self::$_connection = new PDO(sprintf("mysql:host=%s;dbname=%s;", self::DB_HOST, self::DB_NAME), SELF::DB_USER, self::DB_PASSWORD);
            }
            return self::$_connection;
        }
        abstract public function insert() : void;
        abstract public function delete() : void;
    }