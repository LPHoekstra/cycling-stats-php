<?php

require_once(__DIR__ . "/model.php");

function distanceLastMonth()
{
    // get the 30 last activities
    $activities = getAthleteInfo("/activities");

    // initiate aray
    $startDate = [];
    $distance = [];

    // getting actual date
    $date = new DateTime();

    // Looking for activities last 31 days
    for ($i = 0; $i < 31; $i++) {
        $dateString = $date->format("Y-m-d");

        // Compare each activities with the same date
        foreach ($activities as $act) {

            // extract de date from the activity start date
            $dateExplode = explode("T", $act["start_date_local"])[0];

            // If an activity have the same date as the compared one then he's added in the array
            if ($dateExplode === $dateString) {

                // If the last added have the same date so we add the distance
                if ($dateString === end($startDate)) {
                    $lastDistance = array_pop($distance);
                    $addedDistance = $lastDistance + $act["distance"];
                    $distance[] = $addedDistance;
                }
                // Otherwise we add up the array   
                else {
                    $distance[] = $act["distance"];
                    $startDate[] = $dateString;
                }
            }
        }

        // If no activities as been added for the date there is nothing
        if ($dateString !== end($startDate)) {
            $distance[] = 0;
            $startDate[] = $dateString;
        }

        $date->modify("-1 day");
    }

    $_SESSION["loggedUser"]["startDateLast30Act"] = $startDate;
    $_SESSION["loggedUser"]["distanceLast30Act"] = $distance;

    $dateExplode = explode("T", $activities[0]["start_date_local"])[0];

    echo '<pre>';
    print_r($_SESSION["loggedUser"]);
    echo "<br>";
    print_r($dateString);
    echo '<br>';
    print_r($dateExplode);
    echo '</pre>';
}

distanceLastMonth();
