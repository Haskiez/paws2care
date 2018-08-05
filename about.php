<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- The css, links, and other 'head' related stuff -->
    <?php require 'templates/header.php'; ?>
    <!-- End head -->
</head>
<body>
    <!-- Navbar -->
    <?php require 'templates/navbar.php'; ?>
    <!-- End Navbar -->
    
    <div class="jumbotron text-center">
        <h1 class="display-4">About Us</h1>
        <p>Our about page will tell you everything you need to know about how we run this place!</p>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 text-center">
                <img src="assets/vets.jpg" alt="Our Wonderful Vets!">
            </div>
            <div class="col-sm-6">
                <h3>Our Doctors</h3>
                <p>My name is Cynthia! I am the one on the left. I've been invested into Paws to Care for over 10 years. I received my Veterinary Degree from CSU Boulder. I've lived here in Texas for 8 years now and have loved every second! My husband next to me has also been a part of this Clinic for the same amount of time. We met while pursuing our degrees at CSU.</p>
                <p>We are the two people you will interact with when you bring your amazing pet over! We want them to be as comfortable just as much as we want you to feel comfortable. We have a great waiting area for you while we take care of your pet! We can't wait to see you!</p>
            </div>
        </div>
    </div>

    <!-- Lodash, bootstrap, jquery, and any other scripts we need -->
    <?php require 'templates/scripts.php'; ?>
    <!-- End scripts -->
</body>
</html>