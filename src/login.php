<?php

function getBearerCode()
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
            throw new Exception("Access Token missing in the answer");
        }

        if (isset($_FILES["profile"]) &&  $_FILES["profile"]["error"] === 0) {
            // fichier trop volumieux ?
            if ($_FILES["profile"]["size"] > 1000000) {
                echo "<h3>Fichier trop volumineux</h3>";
                return;
            }
            // l'extension du fichier est-elle bonne ?
            $filesExtension = pathinfo($_FILES["profile"]["name"]); // pathinfo renvoie un tableau contenant en plus l'extension du fichier
            $extension = $filesExtension["extension"];
            $allowedExtension = ["jpg", "jpeg", "png"];
            if (!in_array($extension, $allowedExtension)) {
                echo "<h3>Extension du fichier invalide</h3>";
                return;
            }
            // fichier d'upload manquant ?
            $path = __DIR__ . "/../uploads";
            if (!is_dir($path)) {
                echo "<h3>Dossier d'upload manquant</h3>";
                return;
            }

            move_uploaded_file($_FILES["profile"]["tmp_name"], $path . basename($_FILES["profile"]["name"]));
        }

        $accessToken = $responseData["access_token"];
        $firstname = $responseData["athlete"]["firstname"];
        $profile = $responseData["athlete"]["profile"];

        $_SESSION["loggedUser"]["access_token"] = "Bearer {$accessToken}";
        $_SESSION["loggedUser"]["firstname"] = $firstname;
        $_SESSION["loggedUser"]["profile"] = $profile;

        redirectUrl("./");
        exit();
    } catch (Exception $error) {
        echo "Error " . $error->getMessage();
    }
}

if (isset($_GET["code"])) {
    getBearerCode();
}
