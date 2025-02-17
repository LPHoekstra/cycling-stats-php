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
                <a class="navBar__link" href="https://localhost/cycling-stats/update">update</a>
            </li>
        </ul>
    </nav>

    <div class="user-contenair">
        <?php // Connection information
        if (!isset($_SESSION["loggedUser"])) : ?>
            <a class="user-contenair__login" href="http://www.strava.com/oauth/authorize?client_id=127497&response_type=code&redirect_uri=https://localhost/cycling-stats/login&approval_prompt=force&scope=read,activity:read_all,profile:read_all">
                Login
            </a>
        <?php else : ?>
            <img class="user-contenair__picture" src=<?= htmlspecialchars($_SESSION["loggedUser"]["profile"], ENT_QUOTES, 'UTF-8') ?> alt="profile picture">
            <span class="user-contenair__login"><?= htmlspecialchars($_SESSION["loggedUser"]["firstname"], ENT_QUOTES, 'UTF-8') ?></span>
            <a href="logout">
                <button>Déconnexion</button>
            </a>
        <?php endif ?>
    </div>
</header>