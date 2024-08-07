<?php

declare(strict_types=1);

class ActivitiesController
{
    public string $type = "Ride";

    public function __construct()
    {
        if (isset($_SESSION["loggedUser"])) {
            $activities = $this->fetchModels();
        }

        $type = "Ride";
        require_once(__DIR__ . "/../../../templates/activities/activities.php");
    }

    private function fetchModels(): AllActivities
    {
        require_once(__DIR__ . "/../../../models/front/activities/mainArray.php");
        return $activities = new AllActivities;
    }
}
