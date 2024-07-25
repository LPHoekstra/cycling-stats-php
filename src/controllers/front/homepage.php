<?php

function homepageController()
{
    require_once(__DIR__ . "/../../models/front/activity.php");

    if (isset($_SESSION["loggedUser"])) {
        list($distance, $startDate) = distanceLastMonth();
        recentActivities();
    }

    require_once(__DIR__ . "/../../templates/homepage/homepage.php");
}
