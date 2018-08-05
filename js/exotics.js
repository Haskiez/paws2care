$(document).ready(function() {
    // load exotics table with exotics
    let exotics = {};
    $.getJSON('js/animals.json', function(data) {
        exotics = data.exotics;
        fillTable(exotics);
    });

    // SORTING EXOTICS============================================================================================
    $('.sortable').click(function() {
        // get which column we are sorting on
        let colName = $(this).attr('data-col-name');

        // get the current sort direction and switch it
        let currSortDir = $(this).attr('data-sort-dir');
        if (currSortDir === 'none') { currSortDir = 'asc'; }
        else if(currSortDir === 'asc') { currSortDir = 'desc'; }
        else { currSortDir = 'asc'; }


        let tempExotics = exotics;
        if (colName === 'birthDate') {
            tempExotics.sort(compareAges(currSortDir));
        }
        else {
            tempExotics = _.orderBy(exotics, [colName],[currSortDir]);
        }
        fillTable(tempExotics);

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
    //============================================================================================================
    
    // SEARCHING==================================================================================================
    $('.searchBox').keyup(function() {
        let q = $(this).val();
        let colName = $(this).closest('th').attr('data-column');
        let tempExotics = exotics.filter(exotic => (exotic[colName].toLowerCase()).startsWith(q.toLowerCase()));
        fillTable(tempExotics);
    })
    //============================================================================================================
});




// CALLABLE FUNCTIONS=============================================================================================
function fillTable(exotics) {
    // declare a variable for the html we are going to put in the table
    let tableHtml = '';
    // create html using each of these
    exotics.forEach(function(exotic) {
        // get age in years
        let currDate = new Date();
        let birthDate = new Date(exotic.birthDate);
        let age = Math.floor((currDate.getTime() - birthDate.getTime()) / (1000 * 3600 * 24 * 365));
        tableHtml += `
        <tr>
            <td>` + exotic.name + `</td>
            <td>` + exotic.species + `</td>
            <td>` + (exotic.sex === 'm' ? 'Male' : 'Female') + `</td>
            <td>` + (age === 0 ? '< 1' : age) + `</td>
            <td><a href="#" data-toggle="modal" data-target="#ownersModal">Owners</a></td>
            <td><a href="#" data-toggle="modal" data-target="#notesModal">Notes</a></td>
        </tr>
        `;
    });

    // put data in table
    $('.table > tbody').html(tableHtml);
}

// Compare Ages function
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
//================================================================================================================