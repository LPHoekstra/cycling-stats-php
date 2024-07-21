<?php

// initiate arrays
$startDate = []; // date with format of "d/m/Y"
$distance = []; // distance by meters

// getting actual date
$date = new DateTime();

// Looking for activities over the last 31 days
for ($i = 0; $i < 31; $i++) {
    $dateString = $date->format("Y-m-d");
    $activityFound = false;

    // Compare each activity with the current date
    foreach ($activities as $act) {
        // extract the date from the activity start date
        $activityDate = explode("T", $act["start_date_local"])[0];

        // If an activity have the same date as the compared one, it's added to the array
        if ($activityDate === $dateString) {
            $activityFound = true;
            $dateTotalExplode = explode("-", $activityDate);
            $displayedDate = $dateTotalExplode[2] . '/' . $dateTotalExplode[1] . '/' . $dateTotalExplode[0];

            // If the last added date is the same, we add the distance to the existing distance
            if (!empty($startDate) && $displayedDate === end($startDate)) {
                $lastIndex = array_key_last($distance);
                $distance[$lastIndex] += $act["distance"];
            } else {
                $distance[] = $act["distance"];
                $startDate[] = $displayedDate;
            }
        }
    }

    // If no activities have been added for the date, set distance to 0
    if (!$activityFound) {
        $dateTotalExplode = explode("-", $dateString);
        $displayedDate = $dateTotalExplode[2] . '/' . $dateTotalExplode[1] . '/' . $dateTotalExplode[0];
        $distance[] = 0;
        $startDate[] = $displayedDate;
    }

    $date->modify("-1 day");
}

// adding the arrays to the SESSION
$_SESSION["loggedUser"]["startDateLast30Act"] = $startDate;
$_SESSION["loggedUser"]["distanceLast30Act"] = $distance;
