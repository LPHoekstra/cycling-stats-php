<?php
require_once(__DIR__ . "/config/mysql.php");

class DataBase
{
    private static $instance = null;
    private ?PDO $connection;

    private function __construct()
    {
        try {
            $this->connection = new PDO(
                sprintf("mysql:host=%s;dbname=%s;charset=utf8", MYSQL_HOST, MYSQL_NAME),
                MYSQL_USER,
                MYSQL_PASSWORD,
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Database connection error: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new DataBase();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
