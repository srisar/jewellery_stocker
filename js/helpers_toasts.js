function _toast(message, title, bodyClass, textColor) {

    $("#toast_container").append(`
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-dark text-white">
                    <div class="mr-auto">${title}</div>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body ${bodyClass} text-${textColor}">
                    ${message}
                </div>
            </div>`);

    let aToast = $('.toast');
    aToast.toast({'delay': 8000});
    aToast.toast('show');
}

function showInfoToast(message) {
    _toast(message, "Information", "bg-info", 'black');
}

function showSuccessToast(message) {
    _toast(message, "Success", "bg-success", 'white');
}

function showAlertToast(message) {
    _toast(message, "Alert", "bg-danger", 'white');
}

function showWarningToast(message) {
    _toast(message, "Warning", "bg-warning", 'white')
}

function cleanToastContainer() {
    $("#toast_container").html("");
}
