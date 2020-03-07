<?php

use Jman\Core\App;
use Jman\core\LoginManager;

?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?= App::createURL('/') ?>"><?= APP_NAME ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <a class="btn btn-secondary" href="<?= App::createURL('/test') ?>" tabindex="-1" aria-disabled="true">TEST</a>

        <ul class="navbar-nav mr-auto">

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Manage Jewellery
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?= App::createURL('/items') ?>">View all items</a>
                    <a class="dropdown-item" href="<?= App::createURL('/items/add') ?>">Add a new item</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= App::createURL('/categories') ?>">Manage categories</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Manage Bills
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?= App::createURL('/bills/add') ?>">New bill</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= App::createURL('/bills') ?>">Manage old bills</a>
                </div>
            </li>

        </ul>

        <div class="my-2 my-lg-0">
            <?php if (LoginManager::isLoggedIn()): ?>
                Welcome, <a href="<?= App::createURL('/user/manage', ['id' => LoginManager::getUserId()]) ?>"><?= LoginManager::getUsername() ?></a>
                <a class="btn btn-warning ml-2" href="<?= App::createURL('/logout') ?>">logout</a>
            <?php else: ?>
                <a class="btn btn-success ml-2" href="<?= App::createURL('/login') ?>">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>


