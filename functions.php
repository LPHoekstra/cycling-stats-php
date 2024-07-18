<?php

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

function redirectUrl(string $url): never
{
    header("Location: {$url}");
    exit();
}
