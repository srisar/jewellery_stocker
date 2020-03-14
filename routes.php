<?php


use Jman\Controllers\BillsController;
use Jman\Controllers\CategoriesController;
use Jman\Controllers\ItemsController;
use Jman\Controllers\LoginController;
use Jman\Controllers\PageController;
use Jman\Controllers\TestController;
use Jman\Controllers\UserController;
use Jman\Core\Router;
use Jman\Models\User;

Router::add('/', PageController::class, 'index');

Router::add('/users', UserController::class, 'viewUsers', true, User::ROLE_ADMIN);
Router::add('/users/add', UserController::class, 'viewAddUser');
Router::add('/users/add-action', UserController::class, 'actionAddUser');
Router::add('/users/edit', UserController::class, 'viewEditUser');
Router::add('/users/edit-action', UserController::class, 'actionEditUser');

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
Router::add('/bills/edit', BillsController::class, 'viewEditBill');
Router::add('/bills/delete', BillsController::class, 'actionDeleteBill');