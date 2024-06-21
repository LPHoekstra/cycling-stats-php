<?php

function redirectUrl(string $url): never
{
    header("Location: {$url}");
    exit();
}
