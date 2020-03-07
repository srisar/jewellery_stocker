
function makeInputFieldValid(field) {
    field.addClass('is-valid');
    field.removeClass('is-invalid');
}

function makeInputFieldInvalid(field) {
    field.addClass('is-invalid');
    field.removeClass('is-valid');
}

function resetInputFields(container) {
    let fields = $(container).find('input.form-control');

    $.each(fields, function (i, obj) {
        $(obj).removeClass('is-invalid');
    })
}


function validateForms() {
    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
}
