<?php
require_once(__DIR__ . "/controllers/homepage.php");
require_once(__DIR__ . "/controllers/login.php");

if ($_GET["action"] === "") {
    homepage();
}

if ($_GET["action"] === "login") {
    login();
}
