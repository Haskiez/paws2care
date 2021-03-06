<?php
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
        header("LOCATION: /index.php");
    }
    $animal = $_GET["animal"];
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
            <h1 class="display-4"><?php echo ucfirst($animal); ?></h1>
        </div>
        <div class="container-fluid">
            <table class="table" id="animalTable">
                <thead class="thead-light">
                    <?php if ($animal == "dogs") { ?>
                        <tr>
                            <th data-column="name"><input type="text" class="searchBox form-control" placeholder="Seach by name..."></th>
                            <th data-column="breed"><input type="text" class="searchBox form-control" placeholder="Search by breed..."></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><a href="animals.php?animal=<?php echo $animal; ?>" class="btn btn-primary">Reset</a></th>
                        </tr>
                        <tr>
                            <th id="dogName" class="sortable" data-col-name="name" data-sort-dir="none">Name <span class="float-right sort-icons">&udarr;</span></th>
                            <th id="dogBreed" class="sortable" data-col-name="breed" data-sort-dir="none">Breed <span class="float-right sort-icons">&udarr;</span></th>
                            <th id="dogGender" class="sortable" data-col-name="sex" data-sort-dir="none">Sex <span class="float-right sort-icons">&udarr;</span></th>
                            <th id="dogShots" class="sortable" data-col-name="shots" data-sort-dir="none">Shots <span class="float-right sort-icons">&udarr;</span></th>
                            <th id="dogAge" class="sortable" data-col-name="birthDate" data-sort-dir="none">Age <span class="float-right sort-icons">&udarr;</span></th>
                            <th id="dogSize" class="sortable" data-col-name="weight" data-sort-dir="none">Size <span class="float-right sort-icons">&udarr;</span></th>
                            <th id="dogLicensed" class="sortable" data-col-name="licensed" data-sort-dir="none">Licensed <span class="float-right sort-icons">&udarr;</span></th>
                            <th id="dogNeutered" class="sortable" data-col-name="neutered" data-sort-dir="none">Neutered  <span class="float-right sort-icons">&udarr;</span></th>
                            <th>Owners</th>
                            <th>Notes</th>
                        </tr>
                    <?php } else if ($animal == "cats") { ?>
                        <tr>
                            <th data-column="name"><input type="text" class="searchBox form-control" placeholder="Search by name..."></th>
                            <th data-column="breed"><input type="text" class="searchBox form-control" placeholder="Search by breed..."></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><a href="animals.php?animal=<?php echo $animal; ?>" class="btn btn-primary">Reset</a></th>
                        </tr>
                        <tr>
                            <th class="sortable" data-col-name="name" data-sort-dir="none">Name <span class="float-right sort-icons">&udarr;</span></th>
                            <th class="sortable" data-col-name="breed" data-sort-dir="none">Breed <span class="float-right sort-icons">&udarr;</span></th>
                            <th class="sortable" data-col-name="sex" data-sort-dir="none">Sex <span class="float-right sort-icons">&udarr;</span></th>
                            <th class="sortable" data-col-name="shots" data-sort-dir="none">Shots <span class="float-right sort-icons">&udarr;</span></th>
                            <th class="sortable" data-col-name="birthDate" data-sort-dir="none">Age <span class="float-right sort-icons">&udarr;</span></th>
                            <th class="sortable" data-col-name="declawed" data-sort-dir="none">Declawed <span class="float-right sort-icons">&udarr;</span></th>
                            <th class="sortable" data-col-name="neutered" data-sort-dir="none">Neutered <span class="float-right sort-icons">&udarr;</span></th>
                            <th>Owners</th>
                            <th>Notes</th>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <th data-column="name"><input type="text" class="searchBox form-control" placeholder="Search by name..."></th>
                            <th data-column="species"><input type="text" class="searchBox form-control" placeholder="Search by species..."></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><a href="animals.php?animal=<?php echo $animal; ?>" class="btn btn-primary">Reset</a></th>
                        </tr>
                        <tr>
                            <th class="sortable" data-col-name="name" data-sort-dir="none">Name <span class="float-right sort-icons">&udarr;</span></th>
                            <th class="sortable" data-col-name="species" data-sort-dir="none">Species <span class="float-right sort-icons">&udarr;</span></th>
                            <th class="sortable" data-col-name="sex" data-sort-dir="none">Sex <span class="float-right sort-icons">&udarr;</span></th>
                            <th class="sortable" data-col-name="neutered" data-sort-dir="none">Neutered <span class="float-right sort-icons">&udarr;</span></th>
                            <th class="sortable" data-col-name="birthDate" data-sort-dir="none">Age <span class="float-right sort-icons">&udarr;</span></th>
                            <th>Owners</th>
                            <th>Notes</th>
                        </tr>
                    <?php } ?>
                </thead>
                <tbody>
                    <!-- DATA HERE -->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="100">
                            <nav class="float-right">
                                <ul class="pagination">
                                    <li class="page-item new-page disabled" data-page="prev">
                                        <a class="page-link" href="#">Previous</a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">
                                            <span class="page-number">1</span>
                                        </a>
                                    </li>
                                    <li class="page-item new-page" data-page="next">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <!-- Owners modal -->
    <div class="modal fade" id="ownersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Owners</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ownersBody">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary float-right">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Notes modal -->
    <div class="modal fade" id="notesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Notes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body notesBody">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary float-right">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>



    <!-- Scripts -->
    <?php require("templates/scripts.php") ?>
    <!-- End scripts -->
    <!-- Local script for this page -->
    <script>
        let animal = '<?php echo $animal ?>';
        let sfq = {
            table: animal,
            sortDir: '',
            colSort: '',
            colFilt: '',
            filtQ: '',
            pageNum: 1
        };
        let onq = {
            table: animal,
            aid: '',
            modal: ''
        };
        $(document).ready(function() {
            // FILL TABLE==================================================================================================================
            $.get('queryAnimals.php', sfq, fillTable)
            .fail(function(r) {
                console.log(r);
            });
            // END FILL TABLE==============================================================================================================
            // PAGING======================================================================================================================
            $('.new-page').click(function() {
                let b = $(this);
                if (!b.hasClass('disabled')) {
                    if (b.attr('data-page') == 'prev') {
                        // decrement page number
                        sfq.pageNum--;
                        // ajax query
                        $.get('queryAnimals.php', sfq, fillTable)
                        .fail(function(r) {
                            console.log(r);
                        });
                        // page that the new page number in pagination
                        $('.page-number').html(sfq.pageNum);
                        // if page number is 1 then disable prev button
                        b.addClass('disabled');
                        $('.new-page[data-page="next"]').removeClass('disabled');
                    } 
                    else {
                        // increment page number
                        sfq.pageNum++;
                        // ajax query
                        $.get('queryAnimals.php', sfq, fillTable)
                        .fail(function(r) {
                            console.log(r);
                        });
                        // page that the new page number in pagination
                        $('.page-number').html(sfq.pageNum);
                        // take disabled class from the prev button
                        $('.new-page[data-page="prev"]').removeClass('disabled');
                    }
                }



                // // if we clicked previous
                // if ($(this).attr('data-page') == 'prev' && !$(this).hasClass('disabled')) {
                //     // make the next button allowed to be clicked
                //     $($('.new-page')[1]).removeClass('disabled');
                //     // if we aren't at page 1
                //     if (sfq.pageNum != 1) {
                //         // decrease page
                //         sfq.pageNum--;
                //         // ajax query
                //         $.get('queryAnimals.php', sfq, fillTable)
                //         .fail(function(r) {
                //             console.log(r);
                //         });
                //         // page that the new page number in pagination
                //         $('.page-number').html(sfq.pageNum);
                //         // disable the prev button if we are at page 1 now
                //         if (sfq.pageNum == 1) { $(this).addClass('disabled'); }                      
                //     }
                // }
                // else if ($(this).attr('data-page') == 'next' && !$(this).hasClass('disabled')) {
                //     // make the next button allowed to be clicked
                //     $($('.new-page')[0]).removeClass('disabled');
                //     // see if we are at the last page (100 pages max)
                //     if (sfq.pageNum != 100) {
                //         // increase page
                //         sfq.pageNum++;
                //         // ajax query
                //         $.get('queryAnimals.php', sfq, fillTable)
                //         .fail(function(r) {
                //             console.log(r);
                //         });
                //         // update page to new page number
                //         $('.page-number').html(sfq.pageNum);
                //         // disable next button if we are at page 100
                //         if (sfq.pageNum == 100) { $(this).addClass('disabled'); }
                //     }
                // }
            })
            // END PAGING==================================================================================================================
            // SORTING=====================================================================================================================
            $('.sortable').click(function() {
                // if the column to sort equals the column we have saved in sfq.colSort, then we need to switch directions
                if (sfq.colSort == $(this).attr('data-col-name')) {
                    // switch sortDir
                    if (sfq.sortDir == 'asc') { sfq.sortDir = 'desc'; }
                    else { sfq.sortDir = 'asc'; }
                }
                else {
                    // this is a new column, sortDir needs to be asc
                    sfq.sortDir = 'asc';
                    // change the colSort attribute
                    sfq.colSort = $(this).attr('data-col-name');
                }
                // set page number back to 1 for the new query
                sfq.pageNum = 1;
                // take off disabled class from paging buttons
                $('.new-page').each(function() { $(this).removeClass('disabled'); });
                // reset pagination
                $('.page-number').html(sfq.pageNum);
                $($('.new-page')[0]).addClass('disabled');
                // ajax for the data
                $.get('queryAnimals.php', sfq, fillTable)
                .fail(function(r) {
                    console.log(r);
                });
            });
            // ===========================================================================================================================
            // FILTERING==================================================================================================================
            $('.searchBox').keyup(function(e) {
                if (e.keyCode == 13) {
                    // set filtQ
                    sfq.filtQ = $(this).val();
                    sfq.colFilt = $(this).closest('th').attr('data-column');
                    // reset colSort and pageNum
                    sfq.pageNum = 1;
                    $($('.new-page')[0]).addClass('disabled');
                    $($('.new-page')[1]).removeClass('disabled');
                    $('.page-number').html(sfq.pageNum);
                    sfq.colSort = '';
                    sfq.sortDir = '';
                    $.get('queryAnimals.php', sfq, fillTable)
                    .fail(function(r) {
                        console.log(r);
                    });
                }
            });
            // END FILTERING==============================================================================================================
            // QUERY NOTES AND OWNERS=====================================================================================================
            $(document).on('click', '.ownersLink', function() {
                onq.aid = $(this).closest('tr').attr('data-animal-id');
                onq.modal = "owners";
                $.get('queryOwnersAnimals.php', onq, fillModal)
                .fail(function(r) {
                    alert("[ERROR]: Couldn't access owners for this animal.");
                });
            });
            $(document).on('click', '.notesLink', function() {
                onq.aid = $(this).closest('tr').attr('data-animal-id');
                onq.modal = "notes";
                $.get('queryOwnersAnimals.php', onq, fillModal)
                .fail(function(r) {
                    alert("[ERROR]: Couldn't access owners for this animal.");
                });
            });
            // END QUERY NOTES AND OWNERS=================================================================================================
        });


        // FUNCTIONS======================================================================================================================
        function fillTable(r) {
            let insertHtml = '';
            let data = r.message;
            if (data.length < 10) {
                $('.new-page[data-page="next"').addClass('disabled');
            }
            for (let i = 0; i < data.length; i++) {
                // INSERT DOGS==========================================================================================
                if (sfq.table == 'dogs') {
                    let bday = new Date(data[i][7]);
                    let diff = Date.now() - bday.getTime();
                    let ageDate = new Date(diff);
                    let ageYears = Math.abs(ageDate.getUTCFullYear() - 1970);
                    insertHtml += `
                    <tr data-animal-id="` + data[i][0] + `">
                        <td>` + data[i][1] + `</td>
                        <td>` + data[i][2] + `</td>
                        <td>` + (data[i][3]).toUpperCase() + `</td>
                        <td>` + (data[i][4] == '1' ? '<span style="color:green;">&#10004;</span>' : '<span><b>&times;</b></span>') + `</td>
                        <td>` + (ageYears == 0 ? '< 1' : ageYears) + `</td>
                        <td>` + data[i][8] + `</td>
                        <td>` + (data[i][5] == '1' ? '<span style="color:green;">&#10004;</span>' : '<span><b>&times;</b></span>') + `</td>
                        <td>` + (data[i][6] == '1' ? '<span style="color:green;">&#10004;</span>' : '<span><b>&times;</b></span>') + `</td>
                        <td><a href="#" class="ownersLink" data-toggle="modal" data-target="#ownersModal">Owners</a></td>
                        <td><a href="#" class="notesLink" data-toggle="modal" data-target="#notesModal">Notes</a></td>
                    </tr>
                    `;
                }
                // END INSERT DOGS======================================================================================= 
                // INSERT CATS===========================================================================================
                else if (sfq.table == 'cats') {
                    let bday = new Date(data[i][7]);
                    let diff = Date.now() - bday.getTime();
                    let ageDate = new Date(diff);
                    let ageYears = Math.abs(ageDate.getUTCFullYear() - 1970);
                    insertHtml += `
                    <tr data-animal-id="` + data[i][0] + `">
                        <td>` + data[i][1] + `</td>
                        <td>` + data[i][2] + `</td>
                        <td>` + (data[i][3]).toUpperCase() + `</td>
                        <td>` + (data[i][4] == '1' ? '<span style="color:green;">&#10004;</span>' : '<span><b>&times;</b></span>') + `</td>
                        <td>` + (ageYears == 0 ? '< 1' : ageYears) + `</td>
                        <td>` + (data[i][5] == '1' ? '<span style="color:green;">&#10004;</span>' : '<span><b>&times;</b></span>') + `</td>
                        <td>` + (data[i][6] == '1' ? '<span style="color:green;">&#10004;</span>' : '<span><b>&times;</b></span>') + `</td>
                        <td><a href="#" class="ownersLink" data-toggle="modal" data-target="#ownersModal">Owners</a></td>
                        <td><a href="#" class="notesLink" data-toggle="modal" data-target="#notesModal">Notes</a></td>
                    </tr>
                    `;
                }
                // END INSERT CATS==========================================================================================
                // INSERT EXOTICS===========================================================================================
                else {
                    let bday = new Date(data[i][5]);
                    let diff = Date.now() - bday.getTime();
                    let ageDate = new Date(diff);
                    let ageYears = Math.abs(ageDate.getUTCFullYear() - 1970);
                    insertHtml += `
                    <tr data-animal-id="` + data[i][0] + `">
                        <td>` + data[i][1] + `</td>
                        <td>` + data[i][2] + `</td>
                        <td>` + (data[i][3]).toUpperCase() + `</td>
                        <td>` + (data[i][4] == '1' ? '<span style="color:green;">&#10004;</span>' : '<span><b>&times;</b></span>') + `</td>
                        <td>` + (ageYears == 0 ? '< 1' : ageYears) + `</td>
                        <td><a href="#" class="ownersLink" data-toggle="modal" data-target="#ownersModal">Owners</a></td>
                        <td><a href="#" class="notesLink" data-toggle="modal" data-target="#notesModal">Notes</a></td>
                    </tr>
                    `;
                }
                // END INSERT EXOTICS=======================================================================================
            }
            // change sort arrow for appropriate column
            $('.sort-icons').each(function() {
                $(this).html('&udarr;');
            });
            if (sfq.colSort != '') {
                let arrow = '';
                if (sfq.sortDir == 'desc') { arrow = '&ddarr;'; }
                else { arrow = '&uuarr;'; }
                $('.sortable[data-col-name="' + sfq.colSort + '"]').find('span').html(arrow);
            }
            $('tbody').html(insertHtml);
        }
        function fillModal(r) {
            let data = JSON.parse(r);
            let om = $('.ownersBody');
            let nm = $('.notesBody');
            data.modal == 'owners' ? om.html(data.data) : nm.html(data.data);
        }
        // END FUNCTIONS==================================================================================================================
    </script>
    <!-- End local script -->
</body>
</html>