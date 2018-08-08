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

    // get vars
    $animal = $_GET['table'];
    $id = $_GET['aid'];
    $modal = $_GET['modal'];

    // connect to database
    $db = new mysqli("localhost", "root", "mysql", "paws_test");
    // Make sure connection went through
    if ($db->connect_errno) { 
        echo json_response("[ERROR] Couldn't connect to database. Refresh and try again.", 500); 
    }
    // good to go
    else {
        $str = "";
        // query db
        if ($modal == 'owners') {
            $q = "SELECT CONCAT(fname,' ',lname) as uName FROM " .  $animal. "Owners INNER JOIN " . $animal . " ON " . $animal . "Owners." . $animal . "Fk=" . $animal . ".id INNER JOIN owners ON " . $animal . "Owners.ownersFk=owners.id WHERE " . $animal . "Owners." . $animal . "Fk=" . $id;
            $results = $db->query($q);
            while($row = $results->fetch_assoc()) {
                $str .= ("<p>" . $row['uName'] . "</p>");
            }
        }
        else {
            $singAn = substr($animal,0,-1);
            $q = "SELECT CONCAT(DATE_FORMAT(date, '%d %b %Y'),' | ',vetName) as title, note FROM " .  $singAn. "Notes INNER JOIN " . $animal . " ON " . $singAn . "Notes." . $animal . "Fk=" . $animal . ".id WHERE " . $singAn . "Notes." . $animal . "Fk=" . $id;
            $results = $db->query($q);
            // $str = $q;
            while($row = $results->fetch_assoc()) {
                $str .= ("<p>" . $row['title'] . "</p><p>" . $row['note'] . "</p>");
            }
        }


        if ($str == "") {
            $str = "<p>No owner listed</p>";
        }
        echo json_encode(["data" => $str, "modal" => $modal]);
    }
?>