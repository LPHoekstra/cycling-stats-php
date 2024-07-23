<?php
require_once(__DIR__ . "/../../../DBConnection.php");

function login()
{
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

        // add to the session some information from the user
        $_SESSION["loggedUser"]["access_token"] = "Bearer {$responseData["access_token"]}";
        $_SESSION["loggedUser"]["firstname"] = $responseData["athlete"]["firstname"];
        $_SESSION["loggedUser"]["profile"] = $responseData["athlete"]["profile"];
        $_SESSION["loggedUser"]["athlete_id"] = $responseData["athlete"]["id"];

        // if a user is not in the DB, is added
        uploadUser($responseData);

        session_regenerate_id(true);
        header("Location: ./");
        exit();
    } catch (Exception $error) {
        echo "Error: " . $error->getMessage();
    }
}

// check if a user exist in the DB if not he's added
function uploadUser($responseData)
{
    try {
        $mysqlClient = DBConnection();

        // Ensure $responseData is defined and containes the expected structure
        if (isset($responseData["athlete"])) {
            // prepare and execute the SELECT query to know if the user exist in the DB
            $sqlQuery = "SELECT id FROM users WHERE id = :id";
            $idStatement = $mysqlClient->prepare($sqlQuery);
            $idStatement->execute(["id" => $responseData["athlete"]["id"]]);

            $idUser = $idStatement->fetch(PDO::FETCH_ASSOC);

            if (!$idUser) {
                // prepare SQL query for inserting a new user
                $sqlQuery = "INSERT INTO users 
                (id, username, firstname, lastname, city, country, profile_medium, profile, state) 
                VALUES 
                (:id, :username, :firstname, :lastname, :city, :country, :profile_medium, :profile, :state)";
                $userStatement = $mysqlClient->prepare($sqlQuery);

                $userStatement->execute([
                    "id" => $responseData["athlete"]["id"],
                    "username" => $responseData["athlete"]["username"],
                    "firstname" => $responseData["athlete"]["firstname"],
                    "lastname" => $responseData["athlete"]["lastname"],
                    "city" => $responseData["athlete"]["city"],
                    "country" => $responseData["athlete"]["country"],
                    "profile_medium" => $responseData["athlete"]["profile_medium"],
                    "profile" => $responseData["athlete"]["profile"],
                    "state" => $responseData["athlete"]["state"],
                ]);
            }
        } else {
            throw new Exception("Invalid response data");
        }
    } catch (PDOException $error) {
        echo "Database error: " . $error->getMessage();
    } catch (Exception $error) {
        echo "Error: " . $error->getMessage();
    }
}
