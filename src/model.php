<?php
require_once(__DIR__ . "/../functions.php");

// get activities from the DB
function getActivities()
{
    // get last activities and use it
    if (isset($_SESSION["loggedUser"])) {
        try {
            require_once(__DIR__ . "/../DBConnection.php");

            // get the activities from the DB
            $sqlSelect = "SELECT * FROM activities WHERE athlete_id = :athlete_id ORDER BY `activities`.`start_date_local` DESC";
            $activitiesStatement = $mysqlClient->prepare($sqlSelect);
            $activitiesStatement->execute(["athlete_id" => $_SESSION["loggedUser"]["athlete_id"]]);

            return $activities = $activitiesStatement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $error) {
            echo "Error: " . $error->getMessage();
        }
    }
}

function getAthleteInfoStrava($path)
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

// creating the array for the chart on Vue
function distanceLastMonth()
{
    $activities = getActivities();

    // initiate arrays
    $startDate = []; // date with format of "d/m/Y"
    $distance = []; // distance by meters

    // getting actual date
    $date = new DateTime();

    // Looking for activities over the last 31 days
    for ($i = 0; $i < 31; $i++) {
        $dateString = $date->format("Y-m-d");
        $activityFound = false;

        // Compare each activity with the current date
        foreach ($activities as $act) {
            // extract the date from the activity start date
            $activityDate = explode("T", $act["start_date_local"])[0];

            // If an activity have the same date as the compared one, it's added to the array
            if ($activityDate === $dateString) {
                $activityFound = true;
                $dateTotalExplode = explode("-", $activityDate);
                $displayedDate = $dateTotalExplode[2] . '/' . $dateTotalExplode[1] . '/' . $dateTotalExplode[0];

                // If the last added date is the same, we add the distance to the existing distance
                if (!empty($startDate) && $displayedDate === end($startDate)) {
                    $lastIndex = array_key_last($distance);
                    $distance[$lastIndex] += $act["distance"];
                } else {
                    $distance[] = $act["distance"];
                    $startDate[] = $displayedDate;
                }
            }
        }

        // If no activities have been added for the date, set distance to 0
        if (!$activityFound) {
            $dateTotalExplode = explode("-", $dateString);
            $displayedDate = $dateTotalExplode[2] . '/' . $dateTotalExplode[1] . '/' . $dateTotalExplode[0];
            $distance[] = 0;
            $startDate[] = $displayedDate;
        }

        $date->modify("-1 day");
    }

    // adding the arrays to the SESSION
    $_SESSION["loggedUser"]["startDateLast30Act"] = $startDate;
    $_SESSION["loggedUser"]["distanceLast30Act"] = $distance;
}

// data for the recent activities array in the Vue
function recentActivities()
{
    $activities = getActivities();

    // initiate arrays
    $recentName = [];
    $recentDate = []; // date with format of "d/m/Y"
    $recentDist = []; // distance by meters
    $recentTime = []; // time in second
    $recentElev = [];
    $recentABPM = [];

    for ($i = 0; $i <= 9; $i++) {
        $recentName[] = $activities[$i]["name"];
        $dateExplode = explode("T", $activities[$i]["start_date_local"])[0];
        $date = explode("-", $dateExplode);
        $recentDate[] = $date[2] . '/' . $date[1] . '/' . $date[0];

        $recentDist[] = $activities[$i]["distance"];
        $recentTime[] = $activities[$i]["moving_time"];
        $recentElev[] = $activities[$i]["total_elevation_gain"];

        if (isset($activities[$i]["average_heartrate"])) {
            $recentABPM[] = $activities[$i]["average_heartrate"];
        } else {
            $recentABPM[] = "None";
        }
    }

    $_SESSION["loggedUser"]["recentName"] = $recentName;
    $_SESSION["loggedUser"]["recentDate"] = $recentDate;
    $_SESSION["loggedUser"]["recentDist"] = $recentDist;
    $_SESSION["loggedUser"]["recentTime"] = $recentTime;
    $_SESSION["loggedUser"]["recentElev"] = $recentElev;
    $_SESSION["loggedUser"]["recentABPM"] = $recentABPM;
}

// check if a user exist in the DB if not he's added
function uploadUser($responseData)
{
    try {
        require_once(__DIR__ . "/../DBConnection.php");

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
