<?php
require_once(__DIR__ . "/model.php");

if (isset($_SESSION["loggedUser"])) {

    // initiate arrays
    $startDate = [];
    $distance = [];

    // getting actual date
    $date = new DateTime();

    // Looking for activities over the last 31 days
    for ($i = 0; $i < 31; $i++) {
        $dateString = $date->format("Y-m-d");

        // Compare each activity with the current date
        foreach ($activities as $act) {
            // extract de date from the activity start date
            $dateExplode = explode("T", $act["start_date_local"])[0];

            // If an activity have the same date as the compared one, it's added to the array
            if ($dateExplode === $dateString) {
                // If the last added date is the same, we add the distance to the existing distance
                if (!empty($startDate) && $dateString === end($startDate)) {
                    $lastIndex = array_key_last($distance);
                    $distance[$lastIndex] += $act["distance"];
                } else {
                    $distance[] = $act["distance"];
                    $startDate[] = $dateString;
                }
            }
        }

        // If no activities have been added for the date, set distance to 0
        if (empty($startDate) || $dateString !== end($startDate)) {
            $distance[] = 0;
            $startDate[] = $dateString;
        }

        $date->modify("-1 day");
    }

    // adding the arrays to the SESSION
    $_SESSION["loggedUser"]["startDateLast30Act"] = $startDate;
    $_SESSION["loggedUser"]["distanceLast30Act"] = $distance;
}
