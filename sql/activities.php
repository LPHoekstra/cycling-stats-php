<?php
require_once(__DIR__ . "/../src/model.php");
require_once(__DIR__ . "/../DBConnection.php");

$responseData = getAthleteInfo("/activities");

$sqlQuery = "INSERT INTO activities (
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
    total_elev_gain,
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
    :total_elev_gain,
    :type,
    :upload_id,
    :weighted_average_watts)";
$activitiesStatement = $mysqlClient->prepare($sqlQuery);

foreach ($responseData as $activities) {
    $sqlQuery = "SELECT id FROM activities WHERE id = :id";
    $idStatement = $mysqlClient->prepare($sqlQuery);
    $idStatement->execute(["id" => $activities["id"]]);

    $idUser = $idStatement->fetch(PDO::FETCH_ASSOC);

    if (!$idUser) {

        $activitiesStatement->execute([
            "id" => $activities["id"],
            "athlete_id" => $activities["athlete"]["id"],
            "average_cadence" => $activities["average_cadence"],
            "average_heartrate" => $activities["average_heartrate"],
            "average_speed" => $activities["average_speed"],
            "average_temp" => $activities["average_temp"],
            "average_watts" => $activities["average_watts"],
            "device_watts" => $activities["device_watts"],
            "distance" => $activities["distance"],
            "elapsed_time" => $activities["elapsed_time"],
            "elev_high" => $activities["elev_high"],
            "elev_low" => $activities["elev_low"],
            "has_heartrate" => $activities["has_heartrate"],
            "kilojoules" => $activities["kilojoules"],
            "mapId" => $activities["map"]["id"],
            "mapResource_state" => $activities["map"]["resource_state"],
            "mapSummary_polyline" => $activities["map"]["summary_polyline"],
            "max_heartrate" => $activities["max_heartrate"],
            "max_speed" => $activities["max_speed"],
            "max_watts" => $activities["max_watts"],
            "moving_time" => $activities["moving_time"],
            "name" => $activities["name"],
            "sport_type" => $activities["sport_type"],
            "start_date" => $activities["start_date"],
            "start_date_local" => $activities["start_date_local"],
            "total_elev_gain" => $activities["total_elev_gain"],
            "type" => $activities["type"],
            "upload_id" => $activities["upload_id"],
            "weighted_average_watts" => $activities["weighted_average_watts"],
        ]);
    }
}
