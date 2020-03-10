function toggleDateRangeForSearch() {
    let checkToggleDateRange = $("#check_enable_date_range");

    checkToggleDateRange.on("click", function () {

        let fieldStartDate = $("#field_date_start");
        let fieldDateEnd = $("#field_date_end");

        if ($(this).is(":checked")) {
            fieldDateEnd.prop("disabled", false);
            fieldStartDate.prop("disabled", false);
        } else {
            fieldDateEnd.prop("disabled", true);
            fieldStartDate.prop("disabled", true);
        }

    });


}

$(function () {
    toggleDateRangeForSearch();

    let fieldStartDate = $("#field_date_start");
    let fieldDateEnd = $("#field_date_end");
    fieldDateEnd.prop("disabled", true);
    fieldStartDate.prop("disabled", true);
});

