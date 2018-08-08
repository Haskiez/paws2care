<?php
    session_start();
    $_SESSION['loggedin'] = false;
    unset($_SESSION['isAdmin']);
    unset($_SESSION['username']);
    unset($_SESSION['name']);
    unset($_SESSION['uid']);
    header("LOCATION: index.php");