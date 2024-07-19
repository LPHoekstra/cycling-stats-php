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
    <main>

        <h1>Bienvenue sur Cycling Stats
            <?php if (isset($_SESSION["loggedUser"])) {
                echo htmlspecialchars($_SESSION["loggedUser"]["firstname"], ENT_QUOTES, 'UTF-8');
            } ?>
        </h1>

        <!-- test button -->
        <button id="athleteInfo">Call athlete</button>

        <!-- chart activities -->
        <?php if (isset($_SESSION["loggedUser"])) {
            require_once(__DIR__ . "/distance-bar-chart.php");
            require_once(__DIR__ . "/recent-activities.php");
        }
        ?>
        <!-- test call script -->
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
    </main>
</body>

</html>