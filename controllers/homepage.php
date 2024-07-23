<?php
session_start();

require_once(__DIR__ . "/../src/model.php");

function homepage()
{
    distanceLastMonth();
    recentActivities();

    require_once(__DIR__ . "/../templates/homepage.php");
}
