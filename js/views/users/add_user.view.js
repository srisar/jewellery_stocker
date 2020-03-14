function addUser() {


    let btnAddUser = $("#btn_add_user");

    btnAddUser.on("click", function () {

        cleanToastContainer();
        resetInputFields($("#container_add_user"));

        let fieldFirstName       = $("#field_first_name");
        let fieldLastName        = $("#field_last_name");
        let fieldUsername        = $("#field_username");
        let fieldUserRole        = $("#field_role");
        let fieldPassword        = $("#field_password_string");
        let fieldConfirmPassword = $("#field_confirm_password_string");


        let isValid = true;

        let txtFirstName       = fieldFirstName.val().trim();
        let txtLastName        = fieldLastName.val().trim();
        let txtUsername        = fieldUsername.val().trim();
        let txtUserRole        = fieldUserRole.val();
        let txtPassword        = fieldPassword.val();
        let txtConfirmPassword = fieldConfirmPassword.val();



        if (txtFirstName === "" || txtLastName === "") {
            isValid = false;
            showAlertToast("First name / Last name cannot be empty");
            makeInputFieldInvalid(fieldFirstName);
            makeInputFieldInvalid(fieldLastName);
        }

        if (txtUsername === "") {
            isValid = false;
            showAlertToast("Username cannot be empty");
            makeInputFieldInvalid(fieldUsername);
        }

        if (txtPassword === "" || (txtPassword !== txtConfirmPassword)) {
            isValid = false;
            showAlertToast("Password and confirm password does not match");
            makeInputFieldInvalid(fieldPassword);
            makeInputFieldInvalid(fieldConfirmPassword);
        }

        if (isValid) {

            $.post(`${getSiteUrl()}/users/add-action`, {
                first_name: txtFirstName,
                last_name: txtLastName,
                password: txtPassword,
                role: txtUserRole,
                username: txtUsername
            }).done(function (response) {

                window.location.replace(`${getSiteUrl()}/users`);

            }).fail(function (response) {
                showAlertToast(response.responseJSON.data);
            });

        }

    });

}


$(function () {
    addUser();
});