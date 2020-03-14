let textPasswordString = document.getElementById('password_string');
let textConfirmPasswordString = document.getElementById('confirm_password_string');
let checkChangePassword = document.getElementById("check_change_password");
let passwordErrorDiv = document.getElementById("password_error");
let buttonSubmit = document.getElementById("btn_submit");

/**
 * Reset the password and confirm password fields and error message.
 */
function resetPasswordFields() {
    textPasswordString.value = "";
    textConfirmPasswordString.value = "";
    passwordErrorDiv.innerText = "";

    textPasswordString.classList.remove("is-invalid", "is-valid");
    textConfirmPasswordString.classList.remove("is-invalid", "is-valid");
}

function disablePasswordFields(state = true) {
    textConfirmPasswordString.disabled = state;
    textPasswordString.disabled = state;
}

function verifyPasswordMatch(password, confirmPassword) {
    return password === confirmPassword;
}

function validatePasswords() {
    let password = textPasswordString.value;
    let confirmPassword = textConfirmPasswordString.value;


    if (!verifyPasswordMatch(password, confirmPassword) || password.length === 0) {
        passwordErrorDiv.innerText = "Password mismatch or empty.";

        textPasswordString.classList.add('is-invalid');
        textPasswordString.classList.remove('is-valid');
        textConfirmPasswordString.classList.add('is-invalid');
        textConfirmPasswordString.classList.remove('is-valid');
        buttonSubmit.disabled = true;


    } else {
        passwordErrorDiv.innerText = "All good!";
        textConfirmPasswordString.classList.add('is-valid');
        textConfirmPasswordString.classList.remove('is-invalid');
        textPasswordString.classList.add('is-valid');
        textPasswordString.classList.remove('is-invalid');

        buttonSubmit.disabled = false;
    }
}



/** =========================================================
 * EVENT LISTENERS
 ** =======================================================*/

checkChangePassword.addEventListener("click", function () {
    if (checkChangePassword.checked === true) {
        disablePasswordFields(false);
        resetPasswordFields();
        validatePasswords();
    } else {
        disablePasswordFields(true);
        resetPasswordFields();
        if (buttonSubmit.disabled === true) {
            buttonSubmit.disabled = false;
        }
    }
});
textConfirmPasswordString.addEventListener("keyup", function () {
    validatePasswords();
});
textPasswordString.addEventListener("keyup", function () {
    validatePasswords();
});


/** =========================================================
 * STARTUP CALLS
 ** =======================================================*/

disablePasswordFields(true);