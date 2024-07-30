<?php

function homepageController()
{
    require_once(__DIR__ . "/../../models/front/activity.php");

    if (isset($_SESSION["loggedUser"])) {
        $getActivities = new GetActivities;
        $activities = $getActivities->activities;

        $lastMonthActivities = new LastMonthActivities($activities);
        $recentActivities = new RecentActivities($activities);
    }

    require_once(__DIR__ . "/../../templates/homepage/homepage.php");
}
