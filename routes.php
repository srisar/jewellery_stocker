<?php


use Jman\Controllers\BillsController;
use Jman\Controllers\CategoriesController;
use Jman\Controllers\ItemsController;
use Jman\Controllers\LoginController;
use Jman\Controllers\PageController;
use Jman\Controllers\TestController;
use Jman\Controllers\UserController;
use Jman\Core\Router;

Router::add('/', PageController::class, 'index');
Router::add('/users', UserController::class, 'index');
Router::add('/user/manage', UserController::class, 'manage_user');
Router::add('/user/updating', UserController::class, 'updating_user');
Router::add('/user/profile-image-update', UserController::class, 'update_profile_image');

Router::add('/test', TestController::class, 'test_a', false);

Router::add('/login', LoginController::class, 'show_login_page', false);
Router::add('/logout', LoginController::class, 'logout');
Router::add('/login-verify', LoginController::class, 'verify_login');

Router::add('/categories', CategoriesController::class, 'viewCategoriesPage');
Router::add('/categories/find', CategoriesController::class, 'actionFindCategory');
Router::add('/categories/add-action', CategoriesController::class, 'actionAddCategory');
Router::add('/categories/edit', CategoriesController::class, 'viewEditCategory');
Router::add('/categories/edit-action', CategoriesController::class, 'actionEditCategory');


Router::add('/items', ItemsController::class, 'viewItems');
Router::add('/items/add', ItemsController::class, 'viewAddItem');
Router::add('/items/add-action', ItemsController::class, 'actionAddItem');
Router::add('/items/edit', ItemsController::class, 'ViewEditItem');
Router::add('/items/edit-action', ItemsController::class, 'actionEditItem');

Router::add('/items/search', ItemsController::class, 'actionSearchItems');
Router::add('/items/get', ItemsController::class, 'actionGetItems');

Router::add('/bills', BillsController::class, 'viewBills');
Router::add('/bills/add', BillsController::class, 'viewAddBill');
Router::add('/bills/add-action', BillsController::class, 'actionAddBill');