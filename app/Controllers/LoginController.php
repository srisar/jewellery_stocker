<?php


namespace Jman\Controllers;



use Jman\Models\UserModel;
use Jman\Core\App;
use Jman\Core\AppRequest;
use Jman\Core\LoginManager;
use Jman\Core\View;
use Jman\Exceptions\KeyNotFoundException;

class LoginController
{

    public function show_login_page(AppRequest $request)
    {
        if (LoginManager::isLoggedIn())
            App::redirect('/');
        View::render('login/login.view');

    }

    public function verify_login(AppRequest $request)
    {

        try {

            $fields = [
                'username' => $request->getParams()->getString('username'),
                'password_string' => $request->getParams()->getString('password_string'),
                'token' => $request->getParams()->getString('token'),
            ];

            $user = UserModel::findByUsername($fields['username']);


            $result = LoginManager::validateLogin($user, $fields['password_string']);

            if ($result) {
                App::redirect('/');
            } else {
                die('Error!');
            }

        } catch (KeyNotFoundException $ex) {
            die($ex->getMessage());
        }


    }

    public function logout()
    {
        if (LoginManager::isLoggedIn()) {
            LoginManager::logout();
            App::redirect('/');
        }
    }

}