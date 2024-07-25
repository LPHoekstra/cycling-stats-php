<?php
session_start();

require_once(__DIR__ . "/functions.php");

try {
    $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    if (isset($path) && $path === "/cycling-stats/login") {
        require_once(__DIR__ . "/src/controllers/auth/login.php");
        loginController();
    } else if ($path === "/cycling-stats/update") {
        require_once(__DIR__ . "/src/controllers/updateActivities.php");
    } else if ($path === "/cycling-stats/logout") {
        require_once(__DIR__ . "/src/controllers/auth/logout.php");
        logout();
    } else {
        require_once(__DIR__ . "/src/controllers/front/homepage.php");
        homepageController();
    }
} catch (Exception $e) {
    $errorMsg = $e->getMessage();

    require_once(__DIR__ . "/src/templates/error.php");
} catch (PDOException $e) {
    $errorMsg = $e->getMessage();

    require_once(__DIR__ . "/src/templates/error.php");
}
