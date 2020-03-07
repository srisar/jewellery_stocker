<?php


namespace Jman\Controllers;


use Jman\Core\AppRequest;
use Jman\Core\LoginManager;
use Jman\Core\View;

class PageController
{

    public function index(AppRequest $request)
    {

        LoginManager::isLoggedInOrRedirect();

        View::render('pages/index.view');
    }

}