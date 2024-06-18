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
    <header class="header">
        <nav>
            <a href="./" class="navBar__title">
                <h2>Cycling Stats</h2>
            </a>
        </nav>

        <?php // Connection information
        if (!isset($_SESSION["loggedUser"])) : ?>
            <a class="header__login" href="http://www.strava.com/oauth/authorize?client_id=127497&response_type=code&redirect_uri=https://localhost/cycling-stats&approval_prompt=force&scope=read,activity:read_all,profile:read_all">
                Login
            </a>
        <?php else : ?>
            <span class="header__login"><?= $_SESSION["loggedUser"]["name"] ?></span>
        <?php endif ?>

    </header>
    <!-- Main -->
    <h1>Bienvenue sur Cycling Stats</h1>
    <?php
    if (isset($_SESSION["loggedUser"]["bearer"])) :
        $bearer = $_SESSION["loggedUser"]["bearer"]; ?>
        <h4><?= $bearer ?></h4>
    <?php endif ?>
    <button id="athleteInfo">Call athlete</button>
    <script>
        let bearerToken = "<?= $_SESSION["loggedUser"]["bearer"] ?>"
        document.getElementById("athleteInfo").addEventListener("click", () => {
            console.log(bearerToken)
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