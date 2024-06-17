<!DOCTYPE html>
<html lang="fr">

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
        <a class="header__login" href="http://www.strava.com/oauth/authorize?client_id=127497&response_type=code&redirect_uri=https://localhost/cycling-stats&approval_prompt=force&scope=read">
            Login
        </a>
    </header>
    <!-- Main -->
    <h1>Bienvenue sur Cycling Stats</h1>
    <?php
    if (isset($_SESSION["loggedUser"]["bearer"])) :
        $bearer = $_SESSION["loggedUser"]["bearer"]; ?>
        <h4><?= $bearer ?></h4>
    <?php endif ?>
    <form action="cycling-stats/../src/model.php" method="POST">
        <input type="hidden" name="action" value="callFunction">
        <button type="submit">Call Strava</button>
    </form>
</body>

</html>