<?php

function loginController()
{
    require_once(__DIR__ . "/../../models/auth/login.php");

    new Login;
}
