<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cycling Stats</title>
    <link rel="stylesheet" href="./styles/header.css">
    <link rel="stylesheet" href="./styles/global.css">
</head>

<body>
    <!-- header -->
    <?php require_once(__DIR__ . "/header.php") ?>
    <!-- Main -->
    <h1>Bienvenue sur Cycling Stats</h1>
    <button id="athleteInfo">Call athlete</button>
    <script>
        let bearerToken = "<?= $_SESSION["loggedUser"]["access_token"] ?>"
        document.getElementById("athleteInfo").addEventListener("click", () => {
            fetch("https://www.strava.com/api/v3/athlete/activities", {
                    method: "GET",
                    headers: {
                        Authorization: bearerToken
                    }
                })
                .then(response => response.json())
                .then(data => console.log(data))
                .catch(error => console.error(error))
        })
    </script>
</body>

</html>