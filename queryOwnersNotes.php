<?php
    session_start();
    $oid = $_GET["ownerId"];

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

    // open db connection
    // connect to database
    $db = new mysqli("localhost", "root", "mysql", "paws_test");
    // Make sure connection went through
    if ($db->connect_errno) { 
        echo json_response("[ERROR] Couldn't connect to database. Refresh and try again.", 500); 
    }
    else {
        $q = "SELECT CONCAT(DATE_FORMAT(date, '%d %b %Y'), ' | ', vetName) as title, note FROM ownerNotes WHERE ownersFk=$oid";
        $rs = $db->query($q);
        $html = "";
        while ($row = $rs->fetch_assoc()) {
            $html .= "<p>" . $row["title"] . "</p><p>" . $row["note"] . "</p>";
        }
        echo json_response($html);
    }
?>