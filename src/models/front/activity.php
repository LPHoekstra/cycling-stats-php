<?php
require_once(__DIR__ . "/../../../DBConnection.php");

// get activities from the DB
function getActivities()
{
    // get last activities and use it
    if (isset($_SESSION["loggedUser"])) {
        $mysqlClient = DBConnection();

        // get the activities from the DB
        $sqlSelect = "SELECT * FROM activities WHERE athlete_id = :athlete_id ORDER BY `activities`.`start_date_local` DESC";
        $activitiesStatement = $mysqlClient->prepare($sqlSelect);
        $activitiesStatement->execute(["athlete_id" => $_SESSION["loggedUser"]["athlete_id"]]);

        $activities = $activitiesStatement->fetchAll(PDO::FETCH_ASSOC);
        if (!$activities) {
            throw new Exception("Activities missing");
        }

        return $activities;
    }
}

class LastMonthActivities
{
    public array $distance = []; // date with format of "d/m/Y"
    public array $startDate = []; // distance by meters
}

// creating the array for the chart on the views
function distanceLastMonth()
{
    $activities = getActivities();

    if (!$activities[0]["distance"] || !$activities[0]["start_date_local"]) {
        throw new Exception("distance and/or start date missing");
    }

    // getting actual date
    $date = new DateTime();
    $LastMonthActivities = new LastMonthActivities();

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
                if (!empty($LastMonthActivities->startDate) && $displayedDate === end($LastMonthActivities->startDate)) {
                    $lastIndex = array_key_last($LastMonthActivities->distance);
                    $LastMonthActivities->distance[$lastIndex] += $act["distance"];
                } else {
                    $LastMonthActivities->distance[] = $act["distance"];
                    $LastMonthActivities->startDate[] = $displayedDate;
                }
            }
        }

        // If no activities have been added for the date, set distance to 0
        if (!$activityFound) {
            $dateTotalExplode = explode("-", $dateString);
            $displayedDate = $dateTotalExplode[2] . '/' . $dateTotalExplode[1] . '/' . $dateTotalExplode[0];
            $LastMonthActivities->distance[] = 0;
            $LastMonthActivities->startDate[] = $displayedDate;
        }

        $date->modify("-1 day");
    }

    return $LastMonthActivities;
}

// data for the recent activities array in the views
function recentActivities()
{
    $activities = getActivities();

    // initiate arrays
    $recentName = [];
    $recentDate = []; // date with format of "d/m/Y"
    $recentDist = []; // distance by meters
    $recentTime = []; // time in second
    $recentElev = []; // elevation in meters
    $recentABPM = [];

    for ($i = 0; $i < 10; $i++) {
        $recentName[] = $activities[$i]["name"];
        $dateExplode = explode("T", $activities[$i]["start_date_local"])[0];
        $date = explode("-", $dateExplode);
        $recentDate[] = $date[2] . '/' . $date[1] . '/' . $date[0];

        $recentDist[] = $activities[$i]["distance"];
        $recentTime[] = $activities[$i]["moving_time"];
        $recentElev[] = $activities[$i]["total_elevation_gain"] . ' m';
        $recentABPM[] = $activities[$i]["average_heartrate"];
    }

    $_SESSION["loggedUser"]["recentName"] = $recentName;
    $_SESSION["loggedUser"]["recentDate"] = $recentDate;
    $_SESSION["loggedUser"]["recentDist"] = $recentDist;
    $_SESSION["loggedUser"]["recentTime"] = $recentTime;
    $_SESSION["loggedUser"]["recentElev"] = $recentElev;
    $_SESSION["loggedUser"]["recentABPM"] = $recentABPM;
}
