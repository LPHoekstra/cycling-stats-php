<?php
require_once(__DIR__ . "/../DBConnection.php");
require_once(__DIR__ . "/../login.php");

// getting information from the response on the connection
$id = $responseData["athlete"]["id"];
$username = $responseData["athlete"]["username"];
$firstname = $responseData["athlete"]["firstname"];
$lastname = $responseData["athlete"]["lastname"];
$city = $responseData["athlete"]["city"];
$country = $responseData["athlete"]["country"];
$profile_medium = $responseData["athlete"]["profile_medium"];
$profile = $responseData["athlete"]["profile"];
// $measurement_preference = $responseData["athlete"]["measurement_preference"];
$state = $responseData["athlete"]["state"];

// prepare and execute the SELECT query
$sqlQuery = "SELECT id FROM users WHERE id = :id";
$idStatement = $mysqlClient->prepare($sqlQuery);
$idStatement->execute(["id" => $id]);

$idUser = $idStatement->fetch(PDO::FETCH_ASSOC);

if (!$idUser) {
    // prepare sql query
    $sqlQuery = "INSERT INTO users 
    (id, username, firstname, lastname, city, country, profile_medium, profile, state) 
    VALUES 
    (:id, :username, :firstname, :lastname, :city, :country, :profile_medium, :profile, :state)";
    $userStatement = $mysqlClient->prepare($sqlQuery);

    $userStatement->execute([
        "id" => $id,
        "username" => $username,
        "firstname" => $firstname,
        "lastname" => $lastname,
        "city" => $city,
        "country" => $country,
        "profile_medium" => $profile_medium,
        "profile" => $profile,
        // "measurement_preference" => $measurement_preference,
        "state" => $state,
    ]);
}
