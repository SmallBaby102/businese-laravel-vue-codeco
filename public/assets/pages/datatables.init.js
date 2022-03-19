/*
 Template Name: Zoter - Bootstrap 4 Admin Dashboard
 Author: Mannatthemes
 Website: www.mannatthemes.com
 File: Datatable js
 */

$(document).ready(function() {
    $('#datatable').DataTable();

    //Buttons examples
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        scrollX:false,
        autoWith:false,
        buttons: ['copy', 'excel', 'pdf']
    });

    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
} );
$(document).ready(function() {
    $('#datatable_1').DataTable();

    //Buttons examples
    var table = $('#datatable-buttons_1').DataTable({
        lengthChange: false,
        scrollX:false,
        bPaginate:false,
        autoWith:false,
    });

    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
} );
$(document).ready(function() {
    $('#datatable_2').DataTable();

    //Buttons examples
    var table = $('#datatable-buttons_2').DataTable({
        lengthChange: false,
        scrollX:false,
        autoWith:false,
    });

    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
} );
$(document).ready(function() {
    $('#datatable_3').DataTable();

    //Buttons examples
    var table = $('#datatable-buttons_3').DataTable({
        lengthChange: false,
        scrollX:false,
        autoWith:false,
        buttons: ['copy', 'excel', 'pdf']
    });

    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
} );