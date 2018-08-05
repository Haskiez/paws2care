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
        <h1 class="display-4">Contact Us</h1>
        <p>This is the place we keep all of our contact information for your viewing pleasure.</p>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 alert alert-secondary">
                <div class="form-group">
                    <label for="fromEmail">Email:</label>
                    <input type="email" name="fromEmail" id="fromEmail" class="form-control" placeholder="Your email goes here...">
                </div>
                <div class="form-group">
                    <label for="subject">Subject:</label>
                    <input type="text" name="subject" id="subject" class="form-control" placeholder="What is the subject of this message?">
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="Your message goes here..."></textarea>
                </div>
                <button type="button" class="btn btn-primary float-right">Send</button>
            </div>
            <div class="col-lg-4 alert alert-secondary">
                <h3>Phone and Fax</h3>
                <p>Office: 903.404.1221 <br>
                    Fax: 1.903.404.9898</p>
                <h3>Location and Hours</h3>
                <p>118 Shelley Dr. <br>
                    Tyler, TX 75701</p>
                <p>M W F: 8am - 4pm <br>
                    T TH: 10am - 5pm</p>
                <hr>
                <div class="text-center">
                    <img src="../assets/locationmap.PNG" alt="Location Map" width="320" height="250">
                </div>
            </div>
        </div>
    </div>

    <!-- Lodash, bootstrap, jquery, and any other scripts we need -->
    <?php require 'templates/scripts.php'; ?>
    <!-- End scripts -->
</body>
</html>