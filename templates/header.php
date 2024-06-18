<header class="header">
    <a href="./" class="header__title">
        <h2>Cycling Stats</h2>
    </a>
    <nav>
        <ul class="navBar">
            <li class="navBar__liste">
                <a class="navBar__link" href="">Summary</a>
            </li>
            <li class="navBar__liste">
                <a class="navBar__link" href="">Activities</a>
            </li>
            <li class="navBar__liste">
                <a class="navBar__link" href="">update</a>
            </li>
        </ul>
    </nav>

    <?php // Connection information
    if (!isset($_SESSION["loggedUser"])) : ?>
        <a class="header__login" href="http://www.strava.com/oauth/authorize?client_id=127497&response_type=code&redirect_uri=https://localhost/cycling-stats&approval_prompt=force&scope=read,activity:read_all,profile:read_all">
            Login
        </a>
    <?php else : ?>
        <div class="user-contenair">
            <img class="user-contenair__picture" src=<?= $_SESSION["loggedUser"]["profile"] ?> alt="profile picture">
            <span class="user-contenair__login"><?= $_SESSION["loggedUser"]["firstname"] ?></span>
            <a href="src/logout.php">
                <button>Déconnexion</button>
            </a>
        </div>
    <?php endif ?>
</header>