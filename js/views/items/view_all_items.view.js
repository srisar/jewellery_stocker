function showSearchResults(dataTable) {

    let btnSearch = $("#btn_search");

    btnSearch.on("click", function () {

        let isValid = true;

        let fieldKeyword = $("#field_query");
        let checkShowEmpty = $("#check_show_empty");

        let txtKeyword = fieldKeyword.val().trim();

        if (txtKeyword === "") {
            cleanToastContainer();
            showAlertToast("Err... Type in something to search for...");
            isValid = false;
        }

        if (isValid) {

            let showEmpty = false;
            if (checkShowEmpty.is(":checked")) {
                showEmpty = true;
            }

            $.get(`${getSiteUrl()}/items/search`, {
                'keyword': txtKeyword,
                'show_empty': showEmpty
            }).done(function (response) {

                buildSearchResultTable(dataTable, response.data);

                $("#txt_title").html(`Showing results for — ${txtKeyword} —`);

                cleanToastContainer();
                showSuccessToast(`Showing results for — ${txtKeyword} —`);

            }).fail(function (response) {
                showWarningToast(response.responseJSON.data);
            });
        }

    });

}

function buildSearchResultTable(dataTable, items) {

    dataTable.rows().remove();

    items.forEach(item => {

        dataTable.row.add([
            `<a href="${getSiteUrl()}/items/edit?id=${item.id}">${item.item_name}</a>`,
            item.description,
            item.category_name,
            item.gold_quality,
            item.weight,
            item.stock_price_string,
            item.quantity,
            item.total_value_string
        ]);

    });

    dataTable.draw();

}


$(function () {

    let itemsTable = $("#dt_items").DataTable({
        "columnDefs": [
            {className: "text-right align-middle", "targets": "_all"}
        ]
    });

    showSearchResults(itemsTable);

});