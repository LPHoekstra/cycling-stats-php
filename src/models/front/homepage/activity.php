<?php

declare(strict_types=1);

class GetActivities
{
    public array $activities = [];

    public function __construct()
    {
        $this->fetchActivities();
    }

    // get activities from the DB
    private function fetchActivities(): void
    {
        $mysqlClient = DataBase::getInstance()->getConnection();

        // get the activities from the DB
        $sqlSelect = "SELECT * FROM activities WHERE athlete_id = :athlete_id ORDER BY start_date_local DESC LIMIT 30";
        $activitiesStatement = $mysqlClient->prepare($sqlSelect);
        $activitiesStatement->execute(["athlete_id" => $_SESSION["loggedUser"]["athlete_id"]]);

        $this->activities = $activitiesStatement->fetchAll(PDO::FETCH_ASSOC);
        if (!$this->activities) {
            throw new Exception("Activities missing");
        }
    }
}


class LastMonthActivities
{
    public array $distance = []; // distance in meters
    public array $startDate = []; // date in format of "d/m/Y"

    // Creates the arrays for distance and start dates for the last 31 days
    public function __construct(array $activities)
    {
        $this->distanceLastMonth($activities);
    }

    private function distanceLastMonth(array $activities): void
    {
        if (empty($activities) || !isset($activities[0]["distance"], $activities[0]["start_date_local"])) {
            throw new Exception("distance and/or start date missing in the activities data");
        }

        $date = new DateTime();

        for ($i = 0; $i < 31; $i++) {
            $dateString = $date->format("Y-m-d");
            $activityFound = false;

            foreach ($activities as $act) {
                $activityDate = explode("T", $act["start_date_local"])[0];

                // If an activity have the same date as the compared one, it's added to the array
                if ($activityDate === $dateString) {
                    $activityFound = true;
                    $displayedDate = $this->formatDate($activityDate);

                    // If the last added date is the same, we add the distance to the existing distance
                    if (!empty($this->startDate) && $displayedDate === end($this->startDate)) {
                        $lastIndex = array_key_last($this->distance);
                        $this->distance[$lastIndex] += $act["distance"];
                    } else {
                        $this->distance[] = $act["distance"];
                        $this->startDate[] = $displayedDate;
                    }
                }
            }

            // If no activities have been added for the date, set distance to 0
            if (!$activityFound) {
                $displayedDate = $this->formatDate($dateString);
                $this->distance[] = 0;
                $this->startDate[] = $displayedDate;
            }

            $date->modify("-1 day");
        }
    }

    // Formats the date from "Y-m-d" to "d/m/Y"
    private function formatDate(string $dateToExplode): string
    {
        $dateExplode = explode("-", $dateToExplode);
        return $dateExplode[2] . '/' . $dateExplode[1] . '/' . $dateExplode[0];
    }
}

class RecentActivities
{
    public $recentName = [];
    public $recentDate = []; // date with format of "d/m/Y"
    public $recentDist = []; // distance by meters
    public $recentTime = []; // time in second
    public $recentElev = []; // elevation in meters
    public $recentABPM = [];

    public function __construct(array $activities)
    {
        $this->recentActivities($activities);
    }

    // data for the recent activities array in the views
    private function recentActivities(array $activities): void
    {
        for ($i = 0; $i < 10; $i++) {
            $this->recentName[] = $activities[$i]["name"];
            $dateExplode = explode("T", $activities[$i]["start_date_local"])[0];
            $this->recentDate[] = $this->formatDate($dateExplode);
            $this->recentDist[] = $activities[$i]["distance"];
            $this->recentTime[] = $activities[$i]["moving_time"];
            $this->recentElev[] = $activities[$i]["total_elevation_gain"] . ' m';
            $this->recentABPM[] = $activities[$i]["average_heartrate"];
        }
    }

    // Formats the date from "Y-m-d" to "d/m/Y"
    private function formatDate(string $dateToExplode): string
    {
        $dateExplode = explode("-", $dateToExplode);
        return $dateExplode[2] . '/' . $dateExplode[1] . '/' . $dateExplode[0];
    }
}
