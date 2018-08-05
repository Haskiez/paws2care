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
    <section>
        <!-- Navbar -->
        <?php require 'templates/navbar.php'; ?>
        <!-- End Navbar -->

        <div class="jumbotron text-center">
            <h1 class="display-4">Welcome to Paws to Care!</h1>
            <p>We provide amazing services and friendly staff to take care of Man's Best Friend!
                <br>The greatest services are available for dogs, cats, and most exotic animals!</p>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-5">
                    <div class="card float-right" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Meet the Vets!</h5>
                            <p class="card-text">We have an amazing group of staff that is entirely dedicated to serving your pet's needs the best they can. Your pet might just walk away with a brand new toy!</p>
                            <a href="/about.php" class="btn btn-primary">About Page</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2"></div>
                <div class="col-sm-5">
                    <div class="card float-left" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Keep in Touch!</h5>
                            <p class="card-text">Do you have a quick question about what we do or just want to chat? Feel free to send us a note! We only answer messages and phone calls during business hours.</p>
                            <a href="/contact.php" class="btn btn-primary">Contact Page</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lodash, bootstrap, jquery, and any other scripts we need -->
    <?php require 'templates/scripts.php'; ?>
    <!-- End scripts -->
</body>
</html>