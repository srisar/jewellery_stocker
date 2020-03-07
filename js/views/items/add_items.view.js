function addNewItem() {

    let fieldItemName = $("#field_item_name");
    let fieldDescription = $("#field_item_description");
    let fieldCategoryId = $("#field_item_category");
    let fieldGoldQuality = $("#field_gold_quality");
    let fieldWeight = $("#field_weight");
    let fieldStockPrice = $("#field_stock_price");
    let fieldQuantity = $("#field_quantity");

    let btnSave = $("#btn_save_item");


    btnSave.on("click", function () {

        let validated = true;
        cleanToastContainer();
        resetInputFields($("#container_add_item"));

        let txtItemName = fieldItemName.val().trim();
        let txtDescription = fieldDescription.val().trim();
        let txtCategoryId = fieldCategoryId.val();
        let txtStockPrice = parseFloat(fieldStockPrice.val().toString());
        let txtQuantity = parseInt(fieldQuantity.val().toString());
        let txtGoldQuality = parseInt(fieldGoldQuality.val().toString());
        let txtWeight = parseFloat(fieldWeight.val().toString());


        /**
         * Validation rules for input fields
         */

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
            showAlertToast("Invalid gold quality")
        }

        if (txtWeight <= 0 || isNaN(txtWeight)) {
            validated = false;
            makeInputFieldInvalid(fieldWeight);
            showAlertToast("Invalid weight")
        }

        if (validated) {

            $.post(`${getSiteUrl()}/items/add-action`, {
                item_name: txtItemName,
                description: txtDescription,
                stock_price: txtStockPrice,
                category_id: txtCategoryId,
                quantity: txtQuantity,
                gold_quality: txtGoldQuality,
                weight: txtWeight
            }).done(function (response) {

                showSuccessToast("Item updated successfully");
                showInfoToast("You can add a new item again");

                fieldItemName.val("");
                fieldDescription.val("");
                fieldQuantity.val(1);
                fieldStockPrice.val(0);
                fieldWeight.val(0);
                fieldGoldQuality.val(22);

            }).fail(function (response) {
                showAlertToast(response.responseJSON.data);
            });

        }

    });


}


$(function () {
    addNewItem();
});