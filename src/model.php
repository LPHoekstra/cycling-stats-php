<?php

require_once(__DIR__ . "/../functions.php");
require_once(__DIR__ . "/../DBConnection.php");

// get last activities and use it
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

    require_once(__DIR__ . "/../distance-last-month.php");
    require_once(__DIR__ . "/../recent-activities.php");
}
