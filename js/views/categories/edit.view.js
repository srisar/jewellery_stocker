function updateCategory() {


    let fieldCategoryId = $("#field_category_id");
    let fieldCategoryName = $("#field_category_name");

    let btnEdit = $("#btn_edit_category");


    btnEdit.on("click", function () {

        let validated = true;

        cleanToastContainer();
        resetInputFields($("#container_edit_category"));

        let txtCategoryId = fieldCategoryId.val();
        let txtCategoryName = fieldCategoryName.val().trim();

        /**
         * Validation rules for input fields
         */

        if (txtCategoryName === "") {
            validated = false;
            makeInputFieldInvalid(fieldCategoryName);
            showAlertToast("Invalid category name.");
        }

        if (validated) {
            $.post(`${getSiteUrl()}/categories/edit-action`, {
                id: txtCategoryId,
                category_name: txtCategoryName
            }).done(function (response) {

                reloadPage();

            }).fail(function (data) {
                makeInputFieldInvalid(fieldCategoryName);
                showAlertToast(data.responseJSON.data);
            });
        }

    });

}

$(function () {
    updateCategory();
});