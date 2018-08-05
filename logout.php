<?php
    session_start();
    $_SESSION['loggedin'] = false;
    header("LOCATION: /index.php");