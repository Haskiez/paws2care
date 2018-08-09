<?php
    session_start();
    // get credentials that were given
    $username = $_POST['username'];
    $pass = $_POST['password'];
    // connect to database
    $db = new mysqli("localhost", "root", "mysql", "paws_test");
    // Make sure connection went through
    if ($db->connect_errno) { 
        $_SESSION['login_error'] = "Couldn't connect to database. Refresh and try again.";
        header("LOCATION: /loginView.php");
    }
    else {
        // check database for credentials
        $result = $db->query("SELECT * FROM owners WHERE username='$username'");
        
        // see if we got anything back
        if ($result) {
            if ($result->num_rows !== 0) {
                while($row = $result->fetch_assoc()) {
                    // passed!
                    if ($pass == strrev($row['username'])) {
                        $_SESSION['loggedin'] = true;
                        $_SESSION['isAdmin'] = $row['isAdmin'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['name'] = $row['fname'] . ' ' . $row['lname'];
                        $_SESSION['uid'] = $row['id'];
                        header("LOCATION: /index.php");
                    }
                    // failed on password
                    else {
                        $_SESSION['login_error'] = "Invalid credentials. Password is invalid. Please try again.";
                        header("LOCATION: /loginView.php");
                    }
                }
            }
            else {
                $_SESSION['login_error'] = "Invalid credentials. Username not found. Please try again.";
                header("LOCATION: /loginView.php");
            }
        }
        else {
            $_SESSION['login_error'] = "Invalid credentials. Username not found. Please try again.";
            header("LOCATION: /loginView.php");
        }
    }
