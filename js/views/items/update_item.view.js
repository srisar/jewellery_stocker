function updateItem() {

    let fieldId = $("#field_item_id");
    let fieldItemName = $("#field_item_name");
    let fieldDescription = $("#field_item_description");
    let fieldCategoryId = $("#field_item_category");
    let fieldGoldQuality = $("#field_gold_quality");
    let fieldWeight = $("#field_weight");
    let fieldStockPrice = $("#field_stock_price");
    let fieldQuantity = $("#field_quantity");

    let btnUpdate = $("#btn_update_item");

    btnUpdate.on("click", function () {

        let validated = true;
        cleanToastContainer();
        resetInputFields($("#container_add_item"));

        let txtId = fieldId.val();
        let txtItemName = fieldItemName.val().trim();
        let txtDescription = fieldDescription.val().trim();
        let txtCategoryId = fieldCategoryId.val();
        let txtStockPrice = parseFloat(fieldStockPrice.val().toString());
        let txtQuantity = parseInt(fieldQuantity.val().toString());
        let txtGoldQuality = parseInt(fieldGoldQuality.val().toString());
        let txtWeight = parseFloat(fieldWeight.val().toString());


        if (txtItemName === "") {
            validated = false;
            makeInputFieldInvalid(fieldItemName);
            showAlertToast("Invalid item name");
        }
        if (txtStockPrice <= 0 || isNaN(txtStockPrice)) {
            validated = false;
            makeInputFieldInvalid(fieldStockPrice);
            showAlertToast("Invalid stock price");
        }

        if (txtQuantity <= 0 || isNaN(txtQuantity)) {
            validated = false;
            makeInputFieldInvalid(fieldQuantity);
            showAlertToast("Invalid quantity.");
        }

        if (txtGoldQuality < 1 || txtGoldQuality >= 24) {
            validated = false;
            makeInputFieldInvalid(fieldGoldQuality);
            showAlertToast("Invalid gold quality.")
        }

        if (isNaN(txtWeight)) {
            validated = false;
            makeInputFieldInvalid(fieldWeight);
            showAlertToast("Invalid weight.")
        }


        if (validated) {

            $.post(`${getSiteUrl()}/items/edit-action`, {
                id: txtId,
                item_name: txtItemName,
                description: txtDescription,
                stock_price: txtStockPrice,
                category_id: txtCategoryId,
                quantity: txtQuantity,
                gold_quality: txtGoldQuality,
                weight: txtWeight
            }).done(function (response) {

                showSuccessToast("Item updated successfully.");
                resetInputFields($("#container_update_item"));

            }).fail(function (response) {
                showWarningToast(response.responseJSON.data);
            });

        }

    });

}

$(function () {
    updateItem();
});