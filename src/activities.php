<?php
session_start();
require_once(__DIR__ . "/../src/model.php");
require_once(__DIR__ . "/../functions.php");

$responseData = getAthleteInfo("/activities");

$sqlInsert = "INSERT INTO activities (
    id,
    athlete_id,
    average_cadence,
    average_heartrate,
    average_speed,
    average_temp,
    average_watts,
    device_watts,
    distance,
    elapsed_time,
    elev_high,
    elev_low,
    has_heartrate,
    kilojoules,
    mapId,
    mapResource_state,
    mapSummary_polyline,
    max_heartrate,
    max_speed,
    max_watts,
    moving_time,
    name,
    sport_type,
    start_date,
    start_date_local,
    total_elevation_gain,
    type,
    upload_id,
    weighted_average_watts)

    VALUES (
    :id,
    :athlete_id,
    :average_cadence,
    :average_heartrate,
    :average_speed,
    :average_temp,
    :average_watts,
    :device_watts,
    :distance,
    :elapsed_time,
    :elev_high,
    :elev_low,
    :has_heartrate,
    :kilojoules,
    :mapId,
    :mapResource_state,
    :mapSummary_polyline,
    :max_heartrate,
    :max_speed,
    :max_watts,
    :moving_time,
    :name,
    :sport_type,
    :start_date,
    :start_date_local,
    :total_elevation_gain,
    :type,
    :upload_id,
    :weighted_average_watts)";
$activitiesStatement = $mysqlClient->prepare($sqlInsert);

foreach ($responseData as $activity) {
    // GET activities with the same id in the DB as we get from the API
    $sqlQuery = "SELECT id FROM activities WHERE id = :id";
    $idStatement = $mysqlClient->prepare($sqlQuery);
    $idStatement->execute(["id" => $activity["id"]]);

    $existingActivity = $idStatement->fetch();

    // IF an activity from the API is not in the DB, we add it
    if ($existingActivity === false && $activity["type"] === "Ride") {

        try {
            $activitiesStatement->execute([
                "id" => $activity["id"],
                "athlete_id" => $activity["athlete"]["id"],
                "average_cadence" => $activity["average_cadence"],
                "average_heartrate" => $activity["average_heartrate"],
                "average_speed" => $activity["average_speed"],
                "average_temp" => $activity["average_temp"],
                "average_watts" => $activity["average_watts"],
                "device_watts" => $activity["device_watts"],
                "distance" => $activity["distance"],
                "elapsed_time" => $activity["elapsed_time"],
                "elev_high" => $activity["elev_high"],
                "elev_low" => $activity["elev_low"],
                "has_heartrate" => $activity["has_heartrate"],
                "kilojoules" => $activity["kilojoules"],
                "mapId" => $activity["map"]["id"],
                "mapResource_state" => $activity["map"]["resource_state"],
                "mapSummary_polyline" => $activity["map"]["summary_polyline"],
                "max_heartrate" => $activity["max_heartrate"],
                "max_speed" => $activity["max_speed"],
                "max_watts" => $activity["max_watts"],
                "moving_time" => $activity["moving_time"],
                "name" => $activity["name"],
                "sport_type" => $activity["sport_type"],
                "start_date" => $activity["start_date"],
                "start_date_local" => $activity["start_date_local"],
                "total_elevation_gain" => $activity["total_elevation_gain"],
                "type" => $activity["type"],
                "upload_id" => $activity["upload_id"],
                "weighted_average_watts" => $activity["weighted_average_watts"],
            ]);
        } catch (PDOException $error) {
            echo "Error: " . $error->getMessage();
        }
    }
}

header("Location: ./../");
