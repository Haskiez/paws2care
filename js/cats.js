$(document).ready(function() {
    // IMMEDIATE ON PAGE LOAD=================================================================================================
    // Declare an empty json object for dogs
    let cats = {};
    // get dogs from animals.json
    $.getJSON('js/animals.json', function(data) {
        cats = data.cats;
        // fill the table with the available dogs
        fillTable(cats);
    });
    //=========================================================================================================================

    // SORTING CATS============================================================================================================
    $(".sortable").click(function() {
        // get which column we are sorting
        let colName = $(this).attr('data-col-name');

        // get the current sort direction and switch it
        let currSortDir = $(this).attr('data-sort-dir');
        if (currSortDir === 'none') { currSortDir = 'asc'; }
        else if(currSortDir === 'asc') { currSortDir = 'desc'; }
        else { currSortDir = 'asc'; }


        let tempCats = cats;
        if (colName === 'birthDate') {
            tempCats.sort(compareAges(currSortDir));
        }
        else {
            tempCats = _.orderBy(cats, [colName],[currSortDir]);
        }
        fillTable(tempCats);

        // reset all icons
        $('thead > tr').find('span').each(function() {
            $(this).html('');
        });
        // save the current sort direction
        $(this).attr('data-sort-dir', currSortDir);
        if (currSortDir === 'asc') {
            $(this).find('span').html('&#9652;')
        } else if (currSortDir === 'desc') {
            $(this).find('span').html('&#9662;');
        }
    });
    //======================================================================================================================

    // LOADING OWNERS INTO MODAL============================================================================================
    $(document).on('click', '.oModal', function(e) {
        e.preventDefault();
        // get the modal body and clear it
        let modalBody = $('#ownersModal').find('.modal-body');
        modalBody.html('');
        // get the id of the dog
        let catId = $(this).closest('tr').attr('data-cat-id');
        // find dog
        cats.forEach(function(cat) {
            if (cat.id === catId) {
                cat.owners.forEach(function(owner) {
                    $('#ownersModal').find('.modal-body').append('<p>' + owner + '</p>');
                });
            }
        });
        // show modal
        $('#ownersModal').modal('show');
    });
    //======================================================================================================================

    // LOADING NOTES INTO MODAL=============================================================================================
    $(document).on('click', '.nModal', function(e) {
        e.preventDefault();
        // get the modal body and clear it
        let modalBody = $('#notesModal').find('.modal-body');
        modalBody.html('');
        // get the id of the dog
        let catId = $(this).closest('tr').attr('data-cat-id');
        // find dog
        cats.forEach(function(cat) {
            if (cat.id === catId) {
                if (cat.notes == '') {
                    modalBody.append('<p>No Notes</p>');
                } else {
                    let n = (cat.notes).replace(/(?:\r\n|\r|\n)/g, '<br>');
                    modalBody.append('<p>' + n + '</p>');
                }
            }
        });
        // show modal
        $('#notesModal').modal('show');
    });
    //=======================================================================================================================

    // SEARCHING=============================================================================================================
    $('.searchBox').keyup(function() {
        let q = $(this).val();
        let colName = $(this).closest('th').attr('data-column');
        let tempCats = cats.filter(cat => (cat[colName].toLowerCase()).startsWith(q.toLowerCase()));
        fillTable(tempCats);
    });
    //=========================================================================================================================
});


// Populate the Table with the dogs data that is passed to it
function fillTable(cats) {
    // declare a variable for the html we are going to put in the table
    let tableHtml = '';
    // create html using each of these
    cats.forEach(function(cat) {
        let currDate = new Date();
        let birthDate = new Date(cat.birthDate);
        let catAge = Math.floor((currDate.getTime() - birthDate.getTime()) / (1000 * 3600 * 24 * 365));
        tableHtml += `
        <tr data-cat-id="` + cat.id + `">
            <td>` + cat.name + `</td>
            <td>` + cat.breed + `</td>
            <td>` + (cat.sex === "m" ? "Male" : "Female") + `</td>
            <td>` + (cat.shots ? "Up to Date" : "Expired") + `</td>
            <td>` + (catAge === 0 ? "< 1" : catAge) + `</td>
            <td>` + (cat.declawed ? "Yes" : "No") + `</td>
            <td>` + (cat.neutered ? "Yes" : "No") + `</td>
            <td><a class="oModal" href="#">Owners</a></td>
            <td><a class="nModal" href="#">Notes</a></td>
        </tr>
        `;
    });
    // put data in table
    $('.table > tbody').html(tableHtml);
}

// SORTING FUNCTIONS=================================================================================================================================
function compareAges(sortDir) {
    if (sortDir === 'asc') {
        return function(a, b) {
            let aDate = new Date(a.birthDate);
            let bDate = new Date(b.birthDate);
            if (aDate.getTime() === bDate.getTime()) {
                return 0;
            } else if (aDate.getTime() > bDate.getTime()) {
                return -1;
            } else {
                return 1;
            }
        }
    }
    else {
        return function(a, b) {
            let aDate = new Date(a.birthDate);
            let bDate = new Date(b.birthDate);
            if (aDate.getTime() === bDate.getTime()) {
                return 0;
            } else if (aDate.getTime() < bDate.getTime()) {
                return -1;
            } else {
                return 1;
            }
        }
    }
}
// function compareSizes(sortDir) {
//     // compare sizes in ascending order
//     if (sortDir === 'asc') {
//         return function(a, b) {
//             if (a.weight === b.weight) {
//                 return 0;
//             } else if (a.weight < b.weight) {
//                 return -1;
//             } else {
//                 return 1;
//             }
//         }
//     }
//     // compare sizes in descending order
//     else if (sortDir === 'desc') {
//         return function (a, b) {
//             if (a.weight === b.weight) {
//                 return 0;
//             } else if (a.weight > b.weight) {
//                 return -1;
//             } else {
//                 return 1;
//             }
//         }
//     }
// }
//END SORTING FUNCTIONS====================================================================================================================