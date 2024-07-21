<?php

// initiate arrays
$recentName = [];
$recentDate = []; // date with format of "d/m/Y"
$recentDist = []; // distance by meters
$recentTime = []; // time in second
$recentElev = [];
$recentABPM = [];

for ($i = 0; $i <= 9; $i++) {
    $recentName[] = $activities[$i]["name"];
    $dateExplode = explode("T", $activities[$i]["start_date_local"])[0];
    $date = explode("-", $dateExplode);
    $recentDate[] = $date[2] . '/' . $date[1] . '/' . $date[0];

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
