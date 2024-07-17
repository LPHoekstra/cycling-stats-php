<?php
// session_start();
require_once(__DIR__ . "/../functions.php");
require_once(__DIR__ . "/../DBConnection.php");

if (isset($_SESSION["loggedUser"])) {

    try {
        // get the activities from the DB
        $sqlSelect = "SELECT * FROM activities WHERE athlete_id = :athlete_id ORDER BY `activities`.`start_date_local` DESC";
        $activitiesStatement = $mysqlClient->prepare($sqlSelect);
        $activitiesStatement->execute(["athlete_id" => $_SESSION["loggedUser"]["athlete_id"]]);

        $activities = $activitiesStatement->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $error) {
        echo "Error: " . $error->getMessage();
    }
}


function getAthleteInfo($path)
{
    try {

        $bearerToken = $_SESSION["loggedUser"]["access_token"];
        $url = "https://www.strava.com/api/v3/athlete{$path}";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: {$bearerToken}"
        ));

        $response = curl_exec($ch);

        if ($response === false) {
            throw new Exception("Curl error: " . curl_error($ch));
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        return $responseData;
        exit();
    } catch (Exception $error) {
        echo "Error " . $error->getMessage();
    }
}
