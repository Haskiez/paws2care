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



    // get all the information
    $table = $_GET['table'];
    $sortDir = $_GET['sortDir'];
    $colSort = $_GET['colSort'];
    $colFilt = $_GET['colFilt'];
    $filtQ = $_GET['filtQ'];
    $pageNum = $_GET['pageNum'];

    // Set up db connection
    $db = new mysqli("localhost", "root", "mysql", "paws_test");
    // Make sure connection went through
    if ($db->connect_errno) { 
        echo json_response($db->connect_error, 500); 
    }
    else {
        // nothing so just query everything from the appropriate table
        if ($colSort == '' && $colFilt == '') {
            // query variable
            $query = "";

            // if there is a column to sort then that what we need to d0
            $query = "SELECT * FROM $table LIMIT " . ($pageNum * 10 - 10) . ", 10";
            $results = $db->query($query);
            echo json_response($results->fetch_all());
        }
        // sorting and filtering here
        else {
            // query variable
            $query = "";
            
            // filtering here
            if ($colFilt != '' && $colSort == '') {
                $query = "SELECT * FROM $table WHERE $colFilt REGEXP '^($filtQ)' ORDER BY $colFilt LIMIT " . ($pageNum * 10 - 10) . ", 10";
                $results = $db->query($query);
                echo json_response($results->fetch_all());
            }

            // sorting here
            else {
                if ($colFilt != '') {
                    $query = "SELECT * FROM $table WHERE $colFilt REGEXP '^($filtQ)' ORDER BY $colSort " . strtoupper($sortDir) . " LIMIT " . ($pageNum * 10 - 10) . ", 10";
                }
                else {
                    $query = "SELECT * FROM $table ORDER BY $colSort " . strtoupper($sortDir) . " LIMIT " . ($pageNum * 10 - 10) . ", 10";
                }
                $results = $db->query($query);
                echo json_response($results->fetch_all());
            }
        }
    }
?>