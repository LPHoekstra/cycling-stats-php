<?php
require_once(__DIR__ . "/../../DBConnection.php");

function getAthleteInfoStrava($path)
{
    $bearerToken = $_SESSION["loggedUser"]["access_token"];

    if (!$bearerToken) {
        throw new Exception("Bearer token missing getAthleteInfo (model.php)");
    }

    $url = "https://www.strava.com/api/v3/athlete{$path}";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPGET, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/x-www-form-urlencoded",
        "Authorization: {$bearerToken}"
    ));

    $response = curl_exec($ch);

    if (!$response) {
        throw new Exception("Curl error: " . curl_error($ch));
    }

    curl_close($ch);

    $responseData = json_decode($response, true);

    return $responseData;
    exit();
}
