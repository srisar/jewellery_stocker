<?php

namespace Jman\Core;

use Jman\Models\User;

class Router
{
    private static $routes = [];

    public static function add(string $url, string $classname, string $method, bool $login_required = true, $role = User::ROLE_USER)
    {
        self::$routes[] = [
            'url' => $url,
            'classname' => $classname,
            'method' => $method,
            'login_required' => $login_required,
            'role' => $role
        ];
    }


    public static function route($url)
    {

        foreach (self::$routes as $route) {

            if ($route['url'] == $url) {

                if ($route['login_required'] == true) {

                    LoginManager::isLoggedInOrRedirect();

                    if ($route['role'] == LoginManager::getUserRole()) {
                        return call_user_func([new $route['classname'](), $route['method']], new AppRequest());
                    }

                    App::redirect('/');

                } else {
                    return call_user_func([new $route['classname'](), $route['method']], new AppRequest());
                }
            }
        }

        echo "<pre style='text-align: center; font-size: 30px'>No routes found!</pre>";
        return false;

    }


    public static function get_routes()
    {
        return self::$routes;
    }

}