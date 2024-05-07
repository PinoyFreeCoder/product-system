<?php

function logout()
{
    session_start();
    $_SESSION = [];
    session_destroy();
    header("Location: login.php");
    exit;
}

logout();
