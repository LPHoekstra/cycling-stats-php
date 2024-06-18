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
        <div>
            <span><?= $_SESSION["loggedUser"]["profile"] ?></span>
            <span class="header__login"><?= $_SESSION["loggedUser"]["firstname"] ?></span>
            <a href="src/logout.php">
                <button>Déconnexion</button>
            </a>
        </div>
    <?php endif ?>
</header>