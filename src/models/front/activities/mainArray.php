<?php

declare(strict_types=1);

class AllActivities
{
    public array $when = [];
    public array $sportType = [];
    public array $name = [];
    public array $distance = [];
    public array $elev = [];
    public array $elapsedTime = [];
    public array $movingTime = [];
    public array $startTime = [];
    public array $speed = [];
    public array $maxSpeed = [];
    public array $power = [];
    public array $weightedPower = [];
    public array $maxPower = [];
    public array $wattsHeart = [];
    public array $cadence = [];
    public array $heart = [];

    public bool $hasHeartrate = false;
    public bool $hasPower = false;


    public function __construct()
    {
        $responseDB = $this->fetchAll();
        $this->orderResponse($responseDB);
    }

    private function fetchAll(): array
    {
        $mysqlClient = DataBase::getInstance()->getConnection();

        // get the activities from the DB
        $sqlSelect = "SELECT * FROM activities WHERE athlete_id = :athlete_id ORDER BY start_date_local DESC";
        $activitiesStatement = $mysqlClient->prepare($sqlSelect);
        $activitiesStatement->execute(["athlete_id" => $_SESSION["loggedUser"]["athlete_id"]]);

        $responseDB = $activitiesStatement->fetchAll(PDO::FETCH_ASSOC);
        if (!$responseDB) {
            throw new Exception("Activities missing in the response");
        }

        return $responseDB;
    }

    private function orderResponse($responseDB): void
    {
        foreach ($responseDB as $array) {
            if ($array["device_watts"]) {
                $this->hasPower = true;
            }
            if ($array["has_heartrate"]) {
                $this->hasHeartrate = true;
            }

            $dateToExplode = explode("T", $array["start_date_local"])[0];
            $dateExplode = explode("-", $dateToExplode);
            $startDate = $dateExplode[2] . '/' . $dateExplode[1] . '/' . $dateExplode[0];
            $this->when[] = $startDate;

            $this->sportType[] = $array["sport_type"];
            $this->name[] = $array["name"];
            $this->distance[] = $array["distance"];
            $this->elev[] = $array["total_elevation_gain"];
            $this->elapsedTime[] = $array["elapsed_time"];
            $this->movingTime[] = $array["moving_time"];
            $this->startTime[] = explode("T", $array["start_date_local"])[1];
            $this->speed[] = $array["average_speed"];
            $this->maxSpeed[] = $array["max_speed"];
            $this->power[] = $array["average_watts"];
            $this->weightedPower[] = $array["weighted_average_watts"];
            $this->maxPower[] = $array["max_watts"];

            if ($array["has_heartrate"]) {
                $divide =  $array["average_watts"] / $array["average_heartrate"];
                $this->wattsHeart[] = round($divide, 2);
            } else {
                $this->wattsHeart[] = "";
            }

            $this->cadence[] = $array["average_cadence"];
            $this->heart[] = $array["average_heartrate"];
        }
    }
}
