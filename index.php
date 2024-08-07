<?php
// temporary controller 
declare(strict_types=1);

session_start();

require_once(__DIR__ . "/functions.php");
require_once(__DIR__ . "/DBConnection.php");

new Router;
class Router
{
    public function __construct()
    {
        try {
            $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

            if (isset($path) && $path === "/cycling-stats/login") {
                require_once(__DIR__ . "/src/controllers/auth/login.php");
                loginController();
            } else if ($path === "/cycling-stats/update") {
                require_once(__DIR__ . "/src/controllers/updateActivities.php");
                updateActivitiesController();
            } else if ($path === "/cycling-stats/logout") {
                require_once(__DIR__ . "/src/controllers/auth/logout.php");
                logout();
            } else if ($path === "/cycling-stats/activities") {
                require_once(__DIR__ . "/src/controllers/front/activities/activities.php");
                new ActivitiesController;
            } else {
                require_once(__DIR__ . "/src/controllers/front/homepage/homepage.php");
                homepageController();
            }
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();

            require_once(__DIR__ . "/src/templates/error.php");
        } catch (PDOException $e) {
            $errorMsg = $e->getMessage();

            require_once(__DIR__ . "/src/templates/error.php");
        }
    }
}
