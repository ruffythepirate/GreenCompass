<?php

function ensureSSL()
{
    if( !isset($_SERVER["HTTPS"]))
    {
        header("Location: index.php");
        exit();
    }
    if( $_SERVER["HTTPS"] != "on")
    {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
}