$(function () {

    $(".data_table").DataTable({
        "pageLength": 50,
        "columnDefs": [
            {className: "text-right align-middle", "targets": "_all"}
        ],
        "ordering": true,
        "order": []
    });

    $(".date_field").daterangepicker({
        "singleDatePicker": true,
        "showDropdowns": true,
        "locale": {
            "format": "YYYY-MM-DD"
        }
    });

    validateForms();
});

