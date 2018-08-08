<?php
    session_start();
    $_SESSION['loggedin'] = false;
    unset($_SESSION['isAdmin']);
    unset($_SESSION['username']);
    header("LOCATION: " . $_SERVER['HTTP_REFERER']);