<?php
session_start();


$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
if (isset($path) && $path === "/cycling-stats/login") {
    require_once(__DIR__ . "/controllers/login.php");
    loginController();
} else if ($path === "/cycling-stats/update") {
    require_once(__DIR__ . "/controllers/updateActivities.php");
} else {
    require_once(__DIR__ . "/controllers/homepage.php");
    homepageController();
}
