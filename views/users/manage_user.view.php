<?php

use Jman\Core\App;
use Jman\Core\AppSession;
use Jman\Core\View;
use Jman\Exceptions\CoreException;
use Jman\Models\User;

try {

    /** @var User $user */
    $user = View::getData('user');

    if (View::hasError())
        $errors = View::getError();

} catch (CoreException $ex) {
    die($ex->getMessage());
}

?>

<?php include_once BASE_PATH . "/views/_header_with_top_nav.inc.php"; ?>

<div class="container-fluid">


    <div class="row">

        <!--PROFILE IMAGE COMES HERE-->
        <div class="col-12 col-lg-2">
            <form action="<?= App::createURL('/user/profile-image-update') ?>" method="post" enctype="multipart/form-data">
                <div class="">
                    <img id="img_profile_pic" class="" src="http://localhost/uploads/profiles/saravana.jpg" alt="Profile image">
                </div>

                <div class="mt-3">
                    <div class="form-group">
                        <input type="hidden" value="<?= $user->getId(); ?>" name="user_id">
                        <input type="file" class="form-control-file" id="profile_pic" name="profile_pic">
                    </div>
                    <div>
                        <button class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>

        <!--FORM-->
        <div class="col-12 col-lg-6">
            <form action="<?= App::createURL('/user/updating') ?>" method="post" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Manage <?= $user->getFullName() ?></h5>
                    </div>
                    <div class="card-body">

                        <input type="hidden" name="id" value="<?= $user->getId() ?>">
                        <?php AppSession::injectCSRFToken() ?>

                        <?php if (isset($errors)): ?>
                            <div class="row">
                                <div class="col">
                                    <div class="alert alert-warning">
                                        <?= $errors ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="first_name">First name</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" value="<?= $user->getFirstName() ?>" required>
                                    <div class="invalid-feedback">
                                        Please choose a username.
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="last_name">Last name</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" value="<?= $user->getLastName() ?>" required>
                                </div>
                            </div>
                        </div><!--.row-->

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="username">username</label>
                                    <input type="text" class="form-control" name="username" id="username" value="<?= $user->getUsername() ?>" required>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col">
                                <hr>
                                <p class="font-weight-bold">To change new password:</p>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="check_change_password">
                                    <label class="custom-control-label" for="check_change_password">Change password</label>
                                </div>
                            </div>
                        </div><!--.row-->

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="password_string">Password</label>
                                    <input type="password" class="form-control" name="password_string" id="password_string" value="">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label for="confirm_password_string">Confirm password</label>
                                    <input type="password" class="form-control" name="confirm_password_string" id="confirm_password_string" value="">
                                </div>
                            </div>

                        </div><!--.row-->

                        <div class="row">
                            <div class="col">
                                <div id="password_error"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col text-right">
                                <button class="btn btn-success" type="submit" id="btn_submit">Save</button>
                                <a href="<?= App::createURL('/') ?>" class="btn btn-warning">Cancel</a>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div><!--.col-->


    </div><!--.row-->


</div><!--.container-->


<?php include BASE_PATH . "/views/_footer.inc.php"; ?>

<script>
    let textPasswordString = document.getElementById('password_string');
    let textConfirmPasswordString = document.getElementById('confirm_password_string');
    let checkChangePassword = document.getElementById("check_change_password");
    let passwordErrorDiv = document.getElementById("password_error");
    let buttonSubmit = document.getElementById("btn_submit");
    let profilePicInput = document.getElementById("profile_pic");
    let imgProfilePic = document.getElementById("img_profile_pic");

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

    function showSelectedImage(inputField) {


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
    profilePicInput.addEventListener("change", () => {

        if (profilePicInput.files && profilePicInput.files[0]) {
            let fileReader = new FileReader();

            fileReader.onload = () => {
                imgProfilePic.src = fileReader.result;

            };

            fileReader.readAsDataURL(profilePicInput.files[0]);
        }

    });


    /** =========================================================
     * STARTUP CALLS
     ** =======================================================*/

    disablePasswordFields(true);
</script>