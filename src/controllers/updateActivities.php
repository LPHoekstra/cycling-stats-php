<?php
require_once(__DIR__ . "/../models/updateActivities.php");

function updateActivitiesController()
{
    $fetchActivities = (new StravaService)->getAthleteInfoStrava("/activities");
    new UpdateActivities($fetchActivities);
}
