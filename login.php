<?php
session_start();

// function getBearerCode()
// {
try {
    $usAuthorizationCode = htmlspecialchars($_GET["code"]);
    $clientSecret = "cdf3d3735500de9882f258ad4f08cd0cc1dc89dc";
    $clientId = "127497";
    $grantType = "authorization_code";
    $url = "https://www.strava.com/oauth/token";

    $data = [
        "client_id" => $clientId,
        "client_secret" => $clientSecret,
        "code" => $usAuthorizationCode,
        "grant_type" => $grantType
    ];

    // initiate cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/x-www-form-urlencoded"
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        throw new Exception("Curl error: " . curl_error($ch));
    }

    curl_close($ch);

    $responseData = json_decode($response, true);

    if (!isset($responseData["access_token"])) {
        throw new Exception("Access Token missing in the answer (login.php)");
    }

    $accessToken = $responseData["access_token"];
    $firstname = $responseData["athlete"]["firstname"];
    $profile = $responseData["athlete"]["profile"];
    $athleteID = $responseData["athlete"]["id"];

    $_SESSION["loggedUser"]["access_token"] = "Bearer {$accessToken}";
    $_SESSION["loggedUser"]["firstname"] = $firstname;
    $_SESSION["loggedUser"]["profile"] = $profile;
    $_SESSION["loggedUser"]["athlete_id"] = $athleteID;

    require_once(__DIR__ . "/sql/userInformation.php");

    header("Location: ./");
    exit();
} catch (Exception $error) {
    echo "Error " . $error->getMessage();
}
// }

// if (isset($_GET["code"])) {
//     getBearerCode();
// }
