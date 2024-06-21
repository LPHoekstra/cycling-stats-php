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

    for ($i = 0; $i <= 30; $i++) {
        $dateString = $date->format("Y-m-d");

        // extract de date form the activity start date
        $dateExplode = explode("T", $activities[$i]["start_date_local"])[0];

        // check if the formatted date matches with the activity
        if ($dateString === $dateExplode) {
            $distance[] = $activities[$i]["distance"];
        } else {
            $distance[] = 0;
        }

        $startDate[] = $dateString;

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

// foreach ($activities as $act) {
//     $dateOnly = explode("T", $act["start_date_local"])[0];
//     $startDate[] = $dateOnly;

//     $distance[] = $act["distance"];
// }
