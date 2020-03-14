<?php

use Jman\Core\App;
use Jman\Core\AppSession;
use Jman\Core\View;
use Jman\Models\User;

/** @var User $user */
$user = View::getData('user');

if (View::hasError())
    $errors = View::getError();

?>

<?php include_once BASE_PATH . "/views/_header_with_top_nav.inc.php"; ?>

<div class="container-fluid">


    <div class="row justify-content-center">


        <!--FORM-->
        <div class="col-12 col-lg-6">
            <form action="<?= App::createURL('/users/edit-action') ?>" method="post" enctype="multipart/form-data">
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
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" name="username" id="username" value="<?= $user->getUsername() ?>" required>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select name="role" id="role" class="form-control">
                                        <?php foreach (User::USER_ROLES as $key => $value): ?>

                                            <?php $selected = $user->getRole() == $key ? "selected" : ""; ?>
                                            <option <?= $selected ?> value="<?= $key ?>"><?= $value ?></option>
                                        <?php endforeach; ?>
                                    </select>
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
                                <a href="<?= App::createURL('/users') ?>" class="btn btn-warning">Cancel</a>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div><!--.col-->


    </div><!--.row-->


</div><!--.container-->

<script src="<?= App::getSiteURL() ?>/assets/js/views/users/edit_user.view-min.js" defer></script>

<?php include BASE_PATH . "/views/_footer.inc.php"; ?>
