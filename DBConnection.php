<?php
require_once(__DIR__ . "/config/mysql.php");

function DBConnection()
{
    try {
        $mysqlClient = new PDO(
            sprintf("mysql:host=%s;dbname=%s;charset=utf8", MYSQL_HOST, MYSQL_NAME),
            MYSQL_USER,
            MYSQL_PASSWORD,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        return $mysqlClient;
    } catch (Exception $error) {
        die("Erreur : " . $error->getMessage());
    }
}
