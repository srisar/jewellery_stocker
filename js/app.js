$(function () {

    $(".data_table").DataTable({
        "pageLength": 50
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

