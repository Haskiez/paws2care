<?php
    // start admin status to false as default
    $loggedin = false;
    // check if the session has a logged in status
    if (isset($_SESSION['loggedin'])) {
        // if it does, it will be either set to true or false and 
        // we need to set that to the loggedin variable that we are using in this navbar
        $loggedin = $_SESSION['loggedin'];
    }
?>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">
        <img src="/assets/logo_navbar.png" alt="P2C Logo" width="30" height="30">
        P2C
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a href="/about.php" class="nav-link">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/contact.php">Contact</a>
            </li>
            <?php if ($loggedin) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Animals
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/animals.php?animal=dogs">Dogs</a>
                        <a class="dropdown-item" href="/animals.php?animal=cats">Cats</a>
                        <a class="dropdown-item" href="/animals.php?animal=exotics">Exotics</a>
                        <!-- <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">All</a> -->
                    </div>
                </li>
            <?php } ?>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <?php if ($loggedin) { ?>
                    <a href="#" class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown">username</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a href="/logout.php" class="dropdown-item">Logout</a>
                    </div>
                <?php } else { ?>
                    <a href="/login.php" class="nav-link">Login</a>
                <?php } ?>
            </li>
        </ul>
    </div>
</nav>