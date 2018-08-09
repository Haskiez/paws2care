<?php
    session_start();
    if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
        header("LOCATION: index.php");
    }
    // var to hold errors if any
    $error = ["error" => false, "msg" => ''];
    // Get query params if they exist
    $colSort = isset($_GET['colSort']) ? $_GET['colSort'] : "";
    $sortDir = isset($_GET['sortDir']) ? $_GET['sortDir'] : "ASC";
    $colFilt = isset($_GET['colFilt']) ? $_GET['colFilt'] : "";
    $filterQuery = isset($_GET['filterQuery']) ? $_GET['filterQuery'] : "";
    $pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;

    // connect to database
    $db = new mysqli('localhost', 'root', 'mysql', 'paws_test');

    // make sure connection went through, otherwise, display an error
    if ($db->connect_errno) {
        $error["error"] = true;
        $error["msg"] = "Couldn't connect to database. Refresh and try again.";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- The css, links, and other 'head' related stuff -->
<?php require("templates/header.php"); ?>
<!-- End head -->
<style>
    .sortable {
        cursor: pointer;
    }
</style>
</head>
<body>
    <section>
        <!-- Navbar -->
        <?php require("templates/navbar.php") ?>
        <!-- End Navbar -->

        <div class="jumbotron text-center">
            <h1 class="display-4">Owners</h1>
        </div>
        <?php if (!$error["error"]) { ?>
            <div class="container-fluid">
                <table class="table" id="animalTable">
                    <thead class="thead-light">
                        <tr>
                            <th data-column="fname"><input type="text" class="searchBox form-control" placeholder="Seach by first name..." value="<?php if ($colFilt == "fname") { echo $filterQuery; } ?>"></th>
                            <th data-column="lname"><input type="text" class="searchBox form-control" placeholder="Search by last name..." value="<?php if ($colFilt == "lname") { echo $filterQuery; } ?>"></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><a href="owners.php" class="btn btn-primary">Reset</a></th>
                        </tr>
                        <tr>
                            <th class="sortable" data-col-name="fname" data-sort-dir="none">First Name <span class="float-right sort-icon"><?php echo $colSort == 'fname' ? ($sortDir == 'ASC' ? '&uuarr;' : '&ddarr;') : '&udarr;' ?></span></th>
                            <th class="sortable" data-col-name="lname" data-sort-dir="none">Last Name <span class="float-right sort-icon"><?php echo $colSort == 'lname' ? ($sortDir == 'ASC' ? '&uuarr;' : '&ddarr;') : '&udarr;' ?></span></th>
                            <th data-col-name="street">Address</th>
                            <th class="sortable" data-col-name="city" data-sort-dir="none">City <span class="float-right sort-icon"><?php echo $colSort == 'city' ? ($sortDir == 'ASC' ? '&uuarr;' : '&ddarr;') : '&udarr;' ?></span></th>
                            <th class="sortable" data-col-name="st" data-sort-dir="none">State <span class="float-right sort-icon"><?php echo $colSort == 'st' ? ($sortDir == 'ASC' ? '&uuarr;' : '&ddarr;') : '&udarr;' ?></span></th>
                            <th class="sortable" data-col-name="zip" data-sort-dir="none">Postal Code <span class="float-right sort-icon"><?php echo $colSort == 'zip' ? ($sortDir == 'ASC' ? '&uuarr;' : '&ddarr;') : '&udarr;' ?></span></th>
                            <th class="sortable" data-col-name="username" data-sort-dir="none">Username <span class="float-right sort-icon"><?php echo $colSort == 'username' ? ($sortDir == 'ASC' ? '&uuarr;' : '&ddarr;') : '&udarr;' ?></span></th>
                            <th>Pets</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Query for data -->
                        <?php
                            $q = "";
                            $recordCount = 0;
                            // filtering and sorting here
                            if ($colFilt != "" && $colSort != "") {
                                $q = "SELECT id,fname,lname,CONCAT(add1,' ',add2) AS address,city,st,zip,username FROM owners WHERE isAdmin=0 AND " . $colFilt . " REGEXP '^(" . $filterQuery . ")' ORDER BY " . $colSort . " " . $sortDir . " LIMIT " . ($pageNum * 10 - 10) . ",10";
                            }
                            // just filtering here
                            else if ($colFilt != "") {
                                $q = "SELECT id,fname,lname,CONCAT(add1,' ',add2) AS address,city,st,zip,username FROM owners WHERE isAdmin=0 AND " . $colFilt . " REGEXP '^(" . $filterQuery . ")' ORDER BY id LIMIT " . ($pageNum * 10 - 10) . ",10";
                            }
                            // just sorting here
                            else if ($colSort != "") {
                                $q = "SELECT id,fname,lname,CONCAT(add1,' ',add2) AS address,city,st,zip,username FROM owners WHERE isAdmin=0 ORDER BY " . $colSort . " " . $sortDir . " LIMIT " . ($pageNum * 10 - 10) . ",10";
                            }
                            else {
                                $q = "SELECT id,fname,lname,CONCAT(add1,' ',add2) AS address,city,st,zip,username FROM owners WHERE isAdmin=0 ORDER BY id LIMIT " . ($pageNum * 10 - 10) . ",10";
                            }
                            $results = $db->query($q);
                            while($row = $results->fetch_assoc()) {
                                $recordCount++;
                                echo '<tr data-owner-id="' . $row['id'] . '"><td>' . $row["fname"] . '</td><td>' . $row["lname"] . '</td><td>' . $row["address"] . '</td><td>' . $row["city"] . '</td><td>' . $row["st"] . '</td><td>' . $row["zip"] . '</td><td>' . $row["username"] . '</td><td><a href="#" class="pets-link">Pets</a></td><td><a href="#" class="notes-link">Notes</a></td></tr>';
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="100">
                                <nav class="float-right">
                                    <ul class="pagination">
                                        <li class="page-item new-page <?php if ($pageNum < 2) { echo "disabled"; }?>" data-page="prev">
                                            <a class="page-link" href="#">Previous</a>
                                        </li>
                                        <li class="page-item active">
                                            <a class="page-link" href="#">
                                                <span class="page-number"><?php echo $pageNum ?></span>
                                            </a>
                                        </li>
                                        <li class="page-item new-page <?php if ($recordCount < 10) { echo "disabled"; }?>" data-page="next">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php } else { ?>
            <div class="container-fluid" style="width: 500px; margin: 50px auto; text-align: center;">
                <h3 style="color: darkred;"><?php echo $error["msg"]; ?></h3>
            </div>
        <?php } ?>
    </section>

    <!-- Pets modal -->
    <div class="modal fade" id="petsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pets</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body petsBody">
                    <p id="noPetsMsg" style="display:none;">No pets.</p>
                    <table class="table" id="dogsTable">
                        <thead>
                            <tr>
                                <th>Dogs</th>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <th>Breed</th>
                                <th>Sex</th>
                                <th>Age</th>
                                <th>Medical</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DOG DATA HERE -->
                        </tbody>
                    </table>
                    <table class="table" id="catsTable">
                        <thead>
                            <tr>
                                <th>Cats</th>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <th>Breed</th>
                                <th>Sex</th>
                                <th>Age</th>
                                <th>Medical</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- CAT DATA HERE -->
                        </tbody>
                    </table>
                    <table class="table" id="exoticsTable">
                        <thead>
                            <tr>
                                <th>Exotics</th>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <th>Species</th>
                                <th>Sex</th>
                                <th>Age</th>
                                <th>Medical</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- EXOTIC DATA HERE -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Notes modal -->
    <div class="modal fade" id="notesModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pets</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body petsBody">
                    <p id="noNotesMsg" style="display:none;">No Notes.</p>
                    <div id="notesDiv">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <?php require("templates/scripts.php") ?>
    <!-- End scripts -->
    <script>
        $(document).ready(function() {
            let fq = '<?php echo $filterQuery; ?>';
            let cs = '<?php echo $colSort; ?>';
            let sd = '<?php echo $sortDir; ?>';
            let cf = '<?php echo $colFilt; ?>';
            let pn = <?php echo $pageNum; ?>;
            // when we click the sort classes, append the colSort=column and sort direction to url and go there
            $('.sortable').click(function() {
                let colName = $(this).attr('data-col-name');
                pn = 1;
                if (colName == cs) {
                    // switch sort direction
                    if (sd == 'ASC') { sd = 'DESC'; }
                    else { sd = 'ASC'; }
                } else { cs = colName; sd = 'ASC'; }
                window.location.href = "owners.php?colFilt=" + cf + "&filterQuery=" + fq + "&pageNum=" + pn + "&colSort=" + cs + "&sortDir=" + sd;
            });
            // when we hit enter in searchBox class, see which column we are filtering and append that to url
            // clear colSort and set sortDir to ASC
            $('.searchBox').keyup(function(e) {
                if (e.keyCode == 13) {
                    let q = $(this).val();
                    let col = $(this).closest('th').attr('data-column');
                    window.location.href = "owners.php?colFilt=" + col + "&filterQuery=" + q + "&pageNum=" + 1;
                }
            });

            // paging options
            $('.new-page').click(function() {
                let btn = $(this);
                // console.log(pn);
                // return;
                if (!btn.hasClass('disabled')) {
                    if (btn.attr('data-page') == 'prev') {
                        // increment page number
                        pn--;
                    } else if (btn.attr('data-page') == 'next') {
                        // decrement page number
                        pn++;
                    }

                    // send query with new params
                    window.location.href = "owners.php?colFilt=" + cf + "&filterQuery=" + fq + "&pageNum=" + pn + "&colSort=" + cs + "&sortDir=" + sd;
                }
            });

            // ajax for each owners pets... cause its much easier this way and not stupid
            $('.pets-link').click(function() {
                $('#noPetsMsg').hide();
                let url = 'queryOwnersPets.php?ownerId=' + $(this).closest('tr').attr('data-owner-id');
                $.get(url, function(r) {
                    let d = JSON.parse(r.message);
                    let c = 0;
                    $('#petsModal').modal('show');
                    if (d.cats != '') {
                        $('#catsTable').find('tbody').html(d.cats);
                        $('#catsTable').show();
                    } 
                    else { $('#catsTable').hide(); c++; }
                    if (d.dogs != '') {
                        $('#dogsTable').find('tbody').html(d.dogs);
                        $('#dogsTable').show();
                    } 
                    else { $('#dogsTable').hide(); c++; }
                    if (d.exotics != '') {
                        $('#exoticsTable').find('tbody').html(d.exotics);
                        $('#exoticsTable').show();
                    } 
                    else { $('#exoticsTable').hide(); c++; }
                    if (c == 3) { $('#noPetsMsg').show(); }
                }).fail(function(r) {
                    console.log('Error:');
                    console.log(r);
                });
            });
            $('.notes-link').click(function() {
                $('#noNotesMsg').hide();
                let url = 'queryOwnersNotes.php?ownerId=' + $(this).closest('tr').attr('data-owner-id');
                $.get(url, function(r) {
                    $('#notesModal').modal('show');
                    if (r.message != '') {
                        $('#notesDiv').html(r.message);
                    } else { $('#noNotesMsg').show(); }
                }).fail((r) => { console.log('Error:', r); });
            })
        });
    </script>
</body>
</html>