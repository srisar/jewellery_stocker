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

            cleanToastContainer();
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


    chosenItems = {};

    // remove all the items from the table
    billTable.rows().remove().draw();

    selectedItems.forEach(item => {

        billTable.row.add([
            item.item_name,
            `<input type="text" class="form-control form-control-sm text-right field_item_quantity" data-id="${item.id}" value="1">`,
            `<input type="text" class="form-control form-control-sm text-right field_item_price" data-id="${item.id}" placeholder="${item.stock_price}" value="${item.stock_price}">`,
            `<input type="text" class="form-control form-control-sm text-right field_subtotal" data-id="${item.id}" value="${item.stock_price}">`,
            `<button class="btn btn-sm btn-warning btn_remove_selected_item" data-id="${item.id}">Remove</button>`
        ]).draw();

        chosenItems[item.id] = {
            "id": item.id,
            "quantity": 1,
            "price": item.stock_price
        }

    });


    /**
     * Logic for removing added items from the bill
     */

    $(".btn_remove_selected_item").on("click", function () {
        let id = $(this).attr('data-id');

        selectedItems = selectedItems.filter(function (value) {
            return value.id !== id;
        });

        cleanToastContainer();
        showSuccessToast("Item removed");

        updateBillTable(billTable);

    });

    /**
     * Logic for calculating subtotal for the added items
     * subtotal = quantity x price
     */

    function calculateSubtotal() {

        let id = $(this).attr("data-id");

        let item = findItemById(selectedItems, id);

        let fieldQuantity = $(`.field_item_quantity[data-id=${id}]`);
        let fieldPrice = $(`.field_item_price[data-id=${id}]`);
        let fieldSubtotal = $(`.field_subtotal[data-id=${id}]`);

        let btnSaveBill = $("#btn_save_bill");

        let valueQuantity = parseInt(fieldQuantity.val().toString());
        let valuePrice = parseFloat(fieldPrice.val().toString());

        if (valueQuantity > item.quantity || isNaN(valueQuantity) || valueQuantity === 0) {

            makeInputFieldInvalid(fieldQuantity);
            btnSaveBill.prop("disabled", true);
            cleanToastContainer();
            showWarningToast("Item quantity exceeded available quantity");


        } else {
            makeInputFieldValid(fieldQuantity);

            btnSaveBill.prop("disabled", false);
            cleanToastContainer();

            let subtotal = valueQuantity * valuePrice;
            fieldSubtotal.val(subtotal);

            chosenItems[id].quantity = valueQuantity;
            chosenItems[id].price = valuePrice;

        }


    }

    $(".field_item_quantity").on("keyup", calculateSubtotal);
    $(".field_item_price").on("keyup", calculateSubtotal);


}


function saveBill() {
    let btnSave = $("#btn_save_bill");


    btnSave.on("click", function () {

        let fieldDate = $("#field_bill_date");
        let fieldCustomerName = $("#field_customer_name");
        let fieldContactNumber = $("#field_contact_number");
        let fieldAddress = $("#field_address");

        let txtCustomerName = fieldCustomerName.val().trim();
        let txtContactNumber = fieldContactNumber.val().trim();
        let txtAddress = fieldAddress.val().trim();


        cleanToastContainer();
        resetInputFields($("#container_add_bill"));


        let isValid = true;

        if (txtCustomerName === "") {
            isValid = false;
            makeInputFieldInvalid(fieldCustomerName);
            showAlertToast("Invalid customer name");
        }

        if (txtContactNumber === "") {
            showInfoToast("Adding a contact number can be useful");
        }

        if (isValid) {

            $.post(`${getSiteUrl()}/bills/add-action`, {
                "bill_date": fieldDate.val(),
                "customer_name": txtCustomerName,
                "contact_number": txtContactNumber,
                "address": txtAddress,
                "items": chosenItems
            }).done(function (response) {

                console.log(response);

            }).fail(function (response) {
                showAlertToast(response.responseJSON.data);
            });

        }

    });

}


let selectedItems = [];
let chosenItems = {};

$(function () {

    let dTSearchItems = $("#dt_search_bill_items").DataTable({
        "columnDefs": [
            {className: "text-right align-middle", "targets": "_all"}
        ],
        "ordering": true,
        "order": []
    });

    let dTBillItems = $("#dt_bill_items").DataTable({
        "columnDefs": [
            {className: "text-right align-middle", "targets": "_all"}
        ],
        "ordering": true,
        "order": []
    });


    showItemSelectModal();
    searchForItems(dTSearchItems, dTBillItems);
    saveBill();
});