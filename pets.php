<?php
    session_start();
    if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
        header("LOCATION: index.php");
    }
    // set global variables
    $errorObj = array("error" => false, "msg" => "");
    $uid = $_SESSION['uid'];
    // get this persons pets
    // connect to database
    $db = new mysqli("localhost", "root", "mysql", "paws_test");
    // Make sure connection went through
    if ($db->connect_errno) { 
        $errorObj["error"] = true;
        $errorObj["msg"] = "[ERROR] Couldn't connect to database. Refresh and try again."; 
    }
    else {
        // format query
        $qc = "SELECT * FROM catsOwners INNER JOIN cats ON cats.id=catsOwners.catsFk WHERE catsOwners.ownersFk=$uid";
        $tc = "";
        $qd = "SELECT * FROM dogsOwners INNER JOIN dogs ON dogs.id=dogsOwners.dogsFk WHERE dogsOwners.ownersFk=$uid";
        $td = "";
        $qe = "SELECT * FROM exoticsOwners INNER JOIN exotics ON exotics.id=exoticsOwners.exoticsFk WHERE exoticsOwners.ownersFk=$uid";
        $te = "";
        // query results
        $rs = $db->query($qc);
        while ($row = $rs->fetch_assoc()) {
            $bday = new DateTime($row["birthdate"]);
            $now = new DateTime("today");
            $ageYears = $bday->diff($now)->y;
            if ($ageYears < 1) { $ageYears = "< 1"; }
            $shots = $row["shots"] == "1" ? "Shots: <span style=\"color:green;\">&#10004;</span>" : "Shots: <span style=\"color:black;\"><b>&times;</b></span>";
            $declawed = $row["declawed"] == "1" ? "Declawed: <span style=\"color:green;\">&#10004;</span>" : "Declawed: <span style=\"color:black;\"><b>&times;</b></span>";
            $neutered = $row["neutered"] == "1" ? "Neutered: <span style=\"color:green;\">&#10004;</span>" : "Neutered: <span style=\"color:black;\"><b>&times;</b></span>";
            $tc .= "<tr data-aid=\"" . $row["id"] . "\"><td>" . $row["name"] . "</td><td>Cat</td><td>" . $row["breed"] . "</td><td>" . strtoupper($row["sex"]) . "</td><td>" . $ageYears . "</td><td>" . $shots . "<br>" . $declawed . "<br>" . $neutered . "</td></tr>";
        }
        $rs->close();

        $rs = $db->query($qd);
        while ($row = $rs->fetch_assoc()) {
            $bday = new DateTime($row["birthdate"]);
            $now = new DateTime("today");
            $ageYears = $bday->diff($now)->y;
            if ($ageYears < 1) { $ageYears = "< 1"; }
            $shots = $row["shots"] == "1" ? "Shots: <span style=\"color:green;\">&#10004;</span>" : "Shots: <span style=\"color:black;\"><b>&times;</b></span>";
            $licensed = $row["licensed"] == "1" ? "Licensed: <span style=\"color:green;\">&#10004;</span>" : "Licensed: <span style=\"color:black;\"><b>&times;</b></span>";
            $neutered = $row["neutered"] == "1" ? "Neutered: <span style=\"color:green;\">&#10004;</span>" : "Neutered: <span style=\"color:black;\"><b>&times;</b></span>";
            $td .= "<tr data-aid=\"" . $row["id"] . "\"><td>" . $row["name"] . "</td><td>Dog</td><td>" . $row["breed"] . "</td><td>" . strtoupper($row["sex"]) . "</td><td>" . $ageYears . "</td><td>Weight: " . $row["weight"] . "<br>" . $shots . "<br>" . $licensed . "<br>" . $neutered . "</td></tr>";
        }
        $rs->close();

        $rs = $db->query($qe);
        while ($row = $rs->fetch_assoc()) {
            $bday = new DateTime($row["birthdate"]);
            $now = new DateTime("today");
            $ageYears = $bday->diff($now)->y;
            if ($ageYears < 1) { $ageYears = "< 1"; }
            $neutered = $row["neutered"] == "1" ? "Neutered: <span style=\"color:green;\">&#10004;</span>" : "Neutered: <span style=\"color:black;\"><b>&times;</b></span>";
            $te .= "<tr data-aid=\"" . $row["id"] . "\"><td>" . $row["name"] . "</td><td>Exotic</td><td>" . $row["species"] . "</td><td>" . strtoupper($row["sex"]) . "</td><td>" . $ageYears . "</td><td>" . $neutered . "</td></tr>";
        }
        $rs->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require("templates/header.php"); ?>
</head>
<body>
    <?php require("templates/navbar.php"); ?>
    <div class="jumbotron text-center">
        <h1 class="display-4">Pets</h1>
    </div>
    <div class="container-fluid">
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th>Name</th>
                    <th>Vet Class</th>
                    <th>Breed/Species</th>
                    <th>Sex</th>
                    <th>Age</th>
                    <th>Additional Information</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $tc; ?>
                <?php echo $td; ?>
                <?php echo $te; ?>
            </tbody>
        </table>
    </div>
    <?php require("templates/scripts.php"); ?>
</body>
</html>