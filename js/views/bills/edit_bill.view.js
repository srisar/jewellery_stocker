/**
 * Delete the current bill
 */
function deleteBill() {

    let btnShowDeleteModal = $("#btn_delete_item");

    btnShowDeleteModal.on("click", function () {
        let modalConfirm = $("#modal_delete_bill_confirm");
        modalConfirm.modal("show");
    });

    let btnDelete = $("#btn_delete_confirm");

    btnDelete.on("click", function () {

        let billId = $("#bill_id");

        let valid = true;

        let txtBillId = parseInt(billId.val().toString());

        if (isNaN(txtBillId) || txtBillId === 0) {
            valid = false;
            showWarningToast("Error deleting the bill.");
        }

        if (valid) {
            $.post(`${getSiteUrl()}/bills/delete`, {
                id: txtBillId
            }).done(function (response) {

                console.log(response);
                //window.location.replace(`${getSiteUrl()}/bills`);

            }).fail(function (response) {
                showWarningToast(response.responseJSON.data);
            });
        }

    });

}

$(function () {
    deleteBill();
});