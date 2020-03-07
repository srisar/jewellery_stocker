<?php

use Jman\Core\App;
use Jman\Core\AppSession; ?>

<?php include_once BASE_PATH . "/views/_header.inc.php"; ?>

<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-12 col-lg-4">

            <div class="card">
                <div class="card-header">
                    <h4 class="m-0">Login to <?= APP_NAME ?></h4>
                </div>

                <div class="card-body">

                    <form action="<?= App::createURL('/login-verify') ?>" method="post">

                        <input type="hidden" value="<?= AppSession::getCSRFToken(); ?>" name="token">

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input class="form-control" id="username" name="username" type="text">
                        </div>

                        <div class="form-group">
                            <label for="password_string">Password</label>
                            <input class="form-control" id="password_string" name="password_string" type="password">
                        </div>

                        <div class="text-right">
                            <button class="btn btn-success" type="submit">Login</button>
                            <a href="<?= App::createURL('/') ?>" class="btn btn-warning">Cancel</a>
                        </div>

                    </form>

                </div>

            </div>

        </div>


    </div>


</div>

<?php include BASE_PATH . "/views/_footer.inc.php"; ?>

