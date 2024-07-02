<?php

require_once(__DIR__ . "/model.php");

// initiate arrays
$recentName = [];
$recentDate = [];
$recentDist = [];
$recentTime = [];
$recentElev = [];
$recentABPM = [];

for ($i = 0; $i <= 9; $i++) {
    $recentName[] = $activities[$i]["name"];
    $recentDate[] = $activities[$i]["start_date_local"];
    $recentDist[] = $activities[$i]["distance"];
    $recentTime[] = $activities[$i]["moving_time"];
    $recentElev[] = $activities[$i]["total_elevation_gain"];

    if (isset($activities[$i]["average_heartrate"])) {
        $recentABPM[] = $activities[$i]["average_heartrate"];
    } else {
        $recentABPM[] = "None";
    }
}

$_SESSION["loggedUser"]["recentName"] = $recentName;
$_SESSION["loggedUser"]["recentDate"] = $recentDate;
$_SESSION["loggedUser"]["recentDist"] = $recentDist;
$_SESSION["loggedUser"]["recentTime"] = $recentTime;
$_SESSION["loggedUser"]["recentElev"] = $recentElev;
$_SESSION["loggedUser"]["recentABPM"] = $recentABPM;
