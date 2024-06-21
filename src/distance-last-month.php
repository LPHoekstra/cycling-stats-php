<?php

require_once(__DIR__ . "/model.php");

function distanceLastMonth()
{
    // get the 30 last activities
    $activities = getAthleteInfo("/activities");

    // initiate aray
    $startDate = [];
    $distance = [];

    foreach ($activities as $act) {
        $dateOnly = explode("T", $act["start_date_local"])[0];
        $startDate[] = $dateOnly;

        $distance[] = $act["distance"];
    }

    $_SESSION["loggedUser"]["startDateLast30Act"] = $startDate;
    $_SESSION["loggedUser"]["distanceLast30Act"] = $distance;
}

distanceLastMonth();
