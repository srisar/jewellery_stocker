function addNewCategory() {

    let btnAddCategory = $("#btn_add_category");
    let fieldCategoryName = $("#field_category_name");

    btnAddCategory.on("click", function () {

        let validated = true;

        let txtCategoryName = fieldCategoryName.val().trim();

        if (txtCategoryName === "") {
            validated = false;
            makeInputFieldInvalid(fieldCategoryName);
            showAlertToast("Category name cannot be empty");
        }

        if (validated) {
            $.post(`${getSiteUrl()}/categories/add-action`, {
                'category_name': txtCategoryName.value
            }).done(function (response) {
                reloadPage();

            }).fail(function (response) {
                showAlertToast(response.responseJSON.data);
            });
        }


    });

}

$(function () {
    addNewCategory();
});
