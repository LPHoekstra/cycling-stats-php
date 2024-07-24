<?php
require_once(__DIR__ . "/config/mysql.php");

function DBConnection()
{
    $mysqlClient = new PDO(
        sprintf("mysql:host=%s;dbname=%s;charset=utf8", MYSQL_HOST, MYSQL_NAME),
        MYSQL_USER,
        MYSQL_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    return $mysqlClient;
}
