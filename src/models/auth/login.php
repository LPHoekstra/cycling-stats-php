<?php

declare(strict_types=1);

require_once(__DIR__ . "/../../../config/stravaApi.php");

class Login
{
    private string $url = "https://www.strava.com/oauth/token";
    private array $data;
    private ?PDO $mysqlClient;

    public function __construct()
    {
        $this->data = [
            "client_id" => STRAVA_API_CLIENTID,
            "client_secret" => STRAVA_API_CLIENTSECRET,
            "code" => htmlspecialchars($_GET["code"]),
            "grant_type" => "authorization_code",
        ];
        $this->mysqlClient = DataBase::getInstance()->getConnection();
        $this->login();
    }

    // Get Access Token
    private function login(): void
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/x-www-form-urlencoded"
        ]);

        $response = curl_exec($ch);

        if (!$response) {
            throw new Exception("Curl error: " . curl_error($ch));
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        if (!isset($responseData["athlete"], $responseData["access_token"])) {
            throw new Exception("Invalid response data from Strava API");
        }

        $this->setSessionData($responseData);
        $this->ensureUserExists($responseData);

        session_regenerate_id(true);
        header("Location: ./");
    }

    // Ensure the user exist in the DB
    private function ensureUserExists(array $responseData)
    {
        $sqlQuery = "SELECT id FROM users WHERE id = :id";
        $idStatement = $this->mysqlClient->prepare($sqlQuery);
        $idStatement->execute(["id" => $responseData["athlete"]["id"]]);

        $idUser = $idStatement->fetch(PDO::FETCH_ASSOC);

        if (!$idUser) {
            $this->uploadUser($responseData);
        }
    }

    // Upload a new user
    private function uploadUser(array $responseData): void
    {
        // prepare SQL query for inserting a new user
        $sqlQuery = "INSERT INTO users 
                (id, username, firstname, lastname, city, country, profile_medium, profile, state) 
                VALUES 
                (:id, :username, :firstname, :lastname, :city, :country, :profile_medium, :profile, :state)";
        $userStatement = $this->mysqlClient->prepare($sqlQuery);

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

    private function setSessionData(array $responseData): void
    {
        $_SESSION["loggedUser"]["access_token"] = "Bearer {$responseData["access_token"]}";
        $_SESSION["loggedUser"]["firstname"] = $responseData["athlete"]["firstname"];
        $_SESSION["loggedUser"]["profile"] = $responseData["athlete"]["profile"];
        $_SESSION["loggedUser"]["athlete_id"] = $responseData["athlete"]["id"];
    }
}
