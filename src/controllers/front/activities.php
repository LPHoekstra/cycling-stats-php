<?php

class ActivitiesController
{
    public function __construct()
    {
        $type = "Ride";
        $powerMeter = "Yes";

        require_once(__DIR__ . "/../../templates/activities/activities.php");
    }
}
