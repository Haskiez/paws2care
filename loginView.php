<?php
    session_start();
    $error = false;
    $errorMsg = "";
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        // just send them back to home page
        header("LOCATION: /index.php");
    }
    else if (isset($_SESSION['login_error'])) {
        $error = true;
        $errorMsg = $_SESSION['login_error'];
        unset($_SESSION['login_error']);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("templates/header.php"); ?>
</head>
<body>
    <?php require("templates/navbar.php"); ?>

    <div class="container-fluid" style="width: 500px; margin: 50px auto;">
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="username">Email address</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <?php
                    if ($error) {
                        echo '<small class="form-text text-danger">' . $errorMsg . '</small>';
                    }
                ?>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <?php require("templates/scripts.php"); ?>
</body>
</html>