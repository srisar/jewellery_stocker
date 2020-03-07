function showItemSelectModal() {

    let modalItemSelect = $("#modal_select_bill_item");
    let btnOpenModalItemSelect = $("#btn_open_modal_add_item");

    btnOpenModalItemSelect.on("click", function () {
        modalItemSelect.modal("show");
    });


}


function findItemById(data, id) {
    for (let i = 0; i < data.length; i++) {
        if (data[i].id === id)
            return data[i];
    }
    return null;
}


function searchForItems(searchTable, billTable) {

    let fieldSearch = $("#field_search_items");
    let btnSearch = $("#btn_search_items");

    btnSearch.on("click", function () {

        let txtSearch = fieldSearch.val().trim();

        $.get(`${getSiteUrl()}/items/search`, {
            keyword: txtSearch
        }).done(function (response) {

            buildSearchResultsTableContent(response.data, searchTable, billTable);

        }).fail(function (response) {
            console.log(response.responseJSON.data);
        });


    });

}


function buildSearchResultsTableContent(data, searchTable, billTable) {


    searchTable.rows().remove();

    data.forEach(item => {


        searchTable.row.add([
            `<button class="btn btn-sm btn-primary btn_add_selected_item" data-id="${item.id}">Insert</button>`,
            item.item_name,
            item.description,
            item.category_name,
            item.gold_quality,
            item.weight,
            item.stock_price_string,
            item.quantity,
        ]).draw();

    });

    addItemToTheBill(data, billTable);


}


function addItemToTheBill(data, billTable) {
    $(".btn_add_selected_item").on("click", function () {

        let id = $(this).attr('data-id');

        let selectedItem = findItemById(data, id);

        if (selectedItem != null) {
            selectedItems.push(selectedItem);

            showSuccessToast(`${selectedItem.item_name} added successfully`);

            updateBillTable(billTable);

        }

    });
}

/**
 *  Update the bills table and make modifications as user plays around
 * @param billTable
 */
function updateBillTable(billTable) {

    // remove all the items from the table
    billTable.rows().remove().draw();

    selectedItems.forEach(item => {

        billTable.row.add([
            item.item_name,
            `<input type="text" class="form-control form-control-sm text-right" value="1">`,
            `<input type="text" class="form-control form-control-sm text-right" placeholder="${item.stock_price}" value="${item.stock_price}">`,
            `<input type="text" class="form-control form-control-sm text-right" value="">`,
            `<button class="btn btn-sm btn-warning btn_remove_selected_item" data-id="${item.id}">Remove</button>`
        ]).draw();

    });


    $(".btn_remove_selected_item").on("click", function () {
        let id = $(this).attr('data-id');

        console.log("id: " + id);

        selectedItems = selectedItems.filter(function (value) {
            return value.id !== id;
        });

        console.log(selectedItems);

        updateBillTable(billTable);

    });


}


let selectedItems = [];

$(function () {

    let dTSearchItems = $("#dt_search_bill_items").DataTable({
        "columnDefs": [
            {className: "text-right align-middle", "targets": "_all"}
        ]
    });

    let dTBillItems = $("#dt_bill_items").DataTable({
        "columnDefs": [
            {className: "text-right align-middle", "targets": "_all"}
        ]
    });


    showItemSelectModal();
    searchForItems(dTSearchItems, dTBillItems);
});