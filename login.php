<?php
    session_start();
    $_SESSION['loggedin'] = true;
    header("LOCATION: /index.php");