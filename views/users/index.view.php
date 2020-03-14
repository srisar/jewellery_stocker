<?php


use Jman\Core\App;
use Jman\Core\View;
use Jman\Models\User;

try {

    /** @var User[] $users */
    $users = View::getData('users');

} catch (Exception $ex) {
    die($ex->getMessage());
}

?>

<?php include_once BASE_PATH . "/views/_header_with_top_nav.inc.php"; ?>

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-12 col-lg-6">

            <div class="card">
                <div class="card-header">
                    <div class="float-left">Manage users</div>

                </div>
                <div class="card-body">
                    <div class="float-right mb-3"><a href="<?= App::createURL('/users/add') ?>" class="btn btn-primary">Add a user</a></div>

                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Type</th>
                            <th>Created on</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php foreach ($users as $user): ?>

                            <tr>
                                <td><a href="<?= App::createURL('/users/edit', ['id' => $user->getId()]) ?>"><?= $user->getFullName() ?></a></td>
                                <td><?= $user->getUsername() ?></td>
                                <td><?= $user->getRole() ?></td>
                                <td><?= App::toDate($user->getCreatedOn()) ?></td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                </div><!--.card-body-->
            </div><!--.card-->


        </div>


    </div>


</div>

<?php include BASE_PATH . "/views/_footer.inc.php"; ?>
