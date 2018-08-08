<?php
    session_start();
    // JSON RESPONSE FUNCTION FOR EASE OF USE============================================================
    function json_response($message = null, $code = 200)
    {
        // clear the old headers
        header_remove();
        // set the actual code
        http_response_code($code);
        // set the header to make sure cache is forced
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        // treat this as json
        header('Content-Type: application/json');
        $status = array(
            200 => '200 OK',
            400 => '400 Bad Request',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
            );
        // ok, validation error, or failure
        header('Status: '.$status[$code]);
        // return the encoded json
        return json_encode(array(
            'status' => $code < 300, // success or not?
            'message' => $message
            ));
    }
    //===================================================================================================
    // connect to database
    $db = new mysqli("localhost", "root", "mysql", "paws_test");
    // Make sure connection went through
    if ($db->connect_errno) { 
        echo json_response("[ERROR] Couldn't connect to database. Refresh and try again.", 500); 
    } 
    else {
        $id = isset($_GET["ownerId"]) ? $_GET["ownerId"] : "";

        if ($id == "") {
            echo json_response('No owner id provided.', 500);
        } 
        else {
            // format query
            $qc = "SELECT * FROM catsOwners INNER JOIN cats ON cats.id=catsOwners.catsFk WHERE catsOwners.ownersFk=$id";
            $tc = "";
            $qd = "SELECT * FROM dogsOwners INNER JOIN dogs ON dogs.id=dogsOwners.dogsFk WHERE dogsOwners.ownersFk=$id";
            $td = "";
            $qe = "SELECT * FROM exoticsOwners INNER JOIN exotics ON exotics.id=exoticsOwners.exoticsFk WHERE exoticsOwners.ownersFk=$id";
            $te = "";
            
            // query results
            $rs = $db->query($qc);
            while ($row = $rs->fetch_assoc()) {
                $shots = $row["shots"] == "1" ? "Shots: True" : "Shots: False";
                $declawed = $row["declawed"] == "1" ? "Declawed: True" : "Declawed: False";
                $neutered = $row["neutered"] == "1" ? "Neutered: True" : "Neutered: False";
                $tc .= "<tr><td>" . $row["name"] . "</td><td>" . $row["breed"] . "</td><td>" . $row["sex"] . "</td><td>" . $shots . "<br>" . $declawed . "<br>" . $neutered . "</td><td>" . $row["birthdate"] . "</td></tr>";
            }
            $rs->close();

            $rs = $db->query($qd);
            while ($row = $rs->fetch_assoc()) {
                $shots = $row["shots"] == "1" ? "Shots: True" : "Shots: False";
                $licensed = $row["licensed"] == "1" ? "Declawed: True" : "Declawed: False";
                $neutered = $row["neutered"] == "1" ? "Neutered: True" : "Neutered: False";
                $td .= "<tr><td>" . $row["name"] . "</td><td>" . $row["breed"] . "</td><td>" . $row["sex"] . "</td><td>" . $shots . "<br>" . $licensed . "<br>" . $neutered . "</td><td>" . $row["birthdate"] . "</td><td>" . $row["weight"] . "</td></tr>";
            }
            $rs->close();

            $rs = $db->query($qd);
            while ($row = $rs->fetch_assoc()) {
                $neutered = $row["neutered"] == "1" ? "Neutered: True" : "Neutered: False";
                $te .= "<tr><td>" . $row["name"] . "</td><td>" . $row["species"] . "</td><td>" . $row["sex"] . "</td><td>" . $row["neutered"] . "</td><td>" . $row["birthdate"] . "</td></tr>";
            }
            $rs->close();

            echo json_response(json_encode(["cats" => $tc, "dogs" => $td, "exotics" => $te]));
        }
    }
?>