<?php

require_once(__DIR__ . "/../functions.php");

/** GET path to retrieve data for user 
 * client ask for html to server => server retrieve data in the DB => server send html with data to the client
 */

function getAthleteInfo()
{
    $bearerToken = $_SESSION["loggedUser"]["bearer"];
    $url = "https://www.strava.com/api/v3/athlete";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPGET, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/x-www-form-urlencoded",
        "Authorization: {$bearerToken}"
    ));

    $response = curl_exec($ch);

    if ($response === false) {
        die("Curl error: " . curl_error($ch));
    }

    curl_close($ch);
    // redirectUrl("../");
}
