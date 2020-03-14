<?php

use Jman\Core\App;
use Jman\Core\AppSession;
use Jman\Core\View;
use Jman\Models\User;


?>

<?php include_once BASE_PATH . "/views/_header_with_top_nav.inc.php"; ?>

<div class="container-fluid">


    <div class="row justify-content-center">


        <!--FORM-->
        <div class="col-12 col-lg-6">

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Add new user</h5>
                </div>
                <div class="card-body" id="container_add_user">


                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="field_first_name">First name</label>
                                <input type="text" class="form-control" name="first_name" id="field_first_name" value="" required>

                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="field_last_name">Last name</label>
                                <input type="text" class="form-control" name="last_name" id="field_last_name" value="" required>
                            </div>
                        </div>
                    </div><!--.row-->

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="field_username">Username</label>
                                <input type="text" class="form-control" name="username" id="field_username" value="" required>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="field_role">Role</label>
                                <select name="field_role" id="field_role" class="form-control">
                                    <?php foreach (User::USER_ROLES as $key => $value): ?>
                                        <?php $selected = $key == User::ROLE_USER ? "selected" : ""; ?>
                                        <option <?= $selected ?> value="<?= $key ?>"><?= $value ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="field_password_string">Password</label>
                                <input type="password" class="form-control" name="password_string" id="field_password_string" value="">
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="field_confirm_password_string">Confirm password</label>
                                <input type="password" class="form-control" name="confirm_password_string" id="field_confirm_password_string" value="">
                            </div>
                        </div>

                    </div><!--.row-->


                    <div class="row">
                        <div class="col text-right">
                            <button class="btn btn-success" type="button" id="btn_add_user">Save</button>
                            <a href="<?= App::createURL('/users') ?>" class="btn btn-warning">Cancel</a>
                        </div>
                    </div>

                </div>
            </div>

        </div><!--.col-->


    </div><!--.row-->


</div><!--.container-->

<script src="<?= App::getSiteURL() ?>/assets/js/views/users/add_user.view-min.js" defer></script>

<?php include BASE_PATH . "/views/_footer.inc.php"; ?>
