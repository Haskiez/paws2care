<?php
    // start admin status to false as default
    $loggedin = false;
    $un = "";
    // check if the session has a logged in status
    if (isset($_SESSION['loggedin'])) {
        // if it does, it will be either set to true or false and 
        // we need to set that to the loggedin variable that we are using in this navbar
        $loggedin = $_SESSION['loggedin'];
    }
    if (isset($_SESSION['username'])) {
        $un = $_SESSION['username'];
    }
    $admin = false;
    if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
        $admin = true;
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
            <?php if ($loggedin && $admin) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Animals
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/animals.php?animal=dogs">Dogs</a>
                        <a class="dropdown-item" href="/animals.php?animal=cats">Cats</a>
                        <a class="dropdown-item" href="/animals.php?animal=exotics">Exotics</a>
                    </div>
                </li>
            <?php } ?>
            <?php if ($loggedin && !$admin) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="pets.php">Pets</a>
                </li>
            <?php } ?>
            <?php if ($admin) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="/owners.php">Owners</a>
                </li>
            <?php } ?>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <?php if ($loggedin) { ?>
                    <a href="#" class="nav-link dropdown-toggle" id="userDropdown" role="button" data-toggle="dropdown"><?php echo $un ?></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a href="/logout.php" class="dropdown-item">Logout</a>
                    </div>
                <?php } else { ?>
                    <a href="/loginView.php" class="nav-link">Login</a>
                <?php } ?>
            </li>
        </ul>
    </div>
</nav>