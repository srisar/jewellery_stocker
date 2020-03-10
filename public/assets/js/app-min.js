function errorMessage(t){return`<span class="text-danger">${t}</span>`}function successMessage(t){return`<span class="text-success">${t}</span>`}function infoMessage(t){return`<span class="text-dark">${t}</span>`}function reloadPage(){window.location.reload()}function getSiteUrl(){return`${window.location.protocol}//${window.location.hostname}`}function makeInputFieldValid(t){t.addClass("is-valid"),t.removeClass("is-invalid")}function makeInputFieldInvalid(t){t.addClass("is-invalid"),t.removeClass("is-valid")}function resetInputFields(t){let a=$(t).find("input.form-control");$.each(a,function(t,a){$(a).removeClass("is-invalid")})}function validateForms(){"use strict";window.addEventListener("load",function(){var t=document.getElementsByClassName("needs-validation");Array.prototype.filter.call(t,function(t){t.addEventListener("submit",function(a){!1===t.checkValidity()&&(a.preventDefault(),a.stopPropagation()),t.classList.add("was-validated")},!1)})},!1)}function _toast(t,a,n){$("#toast_container").append(`\n            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">\n                <div class="toast-header bg-dark text-white">\n                    <div class="mr-auto">${a}</div>\n                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">\n                        <span aria-hidden="true">&times;</span>\n                    </button>\n                </div>\n                <div class="toast-body ${n} text-black">\n                    ${t}\n                </div>\n            </div>`);let s=$(".toast");s.toast({delay:8e3}),s.toast("show")}function showInfoToast(t){_toast(t,"Information","bg-info")}function showSuccessToast(t){_toast(t,"Success","bg-success")}function showAlertToast(t){_toast(t,"Alert","bg-danger")}function showWarningToast(t){_toast(t,"Warning","bg-warning")}function cleanToastContainer(){$("#toast_container").html("")}$(function(){$(".data_table").DataTable({pageLength:50}),$(".date_field").daterangepicker({singleDatePicker:!0,showDropdowns:!0,locale:{format:"YYYY-MM-DD"}}),validateForms()});