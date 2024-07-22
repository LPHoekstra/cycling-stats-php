<?php
require_once(__DIR__ . "/../DBConnection.php");
require_once(__DIR__ . "/../login.php");

try {
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
