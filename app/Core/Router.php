<?php

namespace Jman\Core;

use Jman\Models\User;

class Router
{
    private static $routes = [];

    public static function add(string $url, string $classname, string $method, bool $login_required = true, $role = User::ROLE_USER)
    {
        self::$routes[] = [
            'url'            => $url,
            'classname'      => $classname,
            'method'         => $method,
            'login_required' => $login_required,
            'role'           => $role
        ];
    }


    public static function route($url)
    {


        foreach (self::$routes as $route) {

            if ($route['url'] == $url) {

                error_log(print_r($route, true));

                if ($route['login_required'] == true) {

                    error_log('logged in');
                    error_log(LoginManager::getUserRole());

                    LoginManager::isLoggedInOrRedirect();

                    $allowed = false;

                    if (LoginManager::getUserRole() == User::ROLE_ADMIN) {
                        $allowed = true;
                    } elseif ($route['role'] == LoginManager::getUserRole()) {
                        $allowed = true;
                    }

                    if ($allowed) {
                        return call_user_func([new $route['classname'](), $route['method']], new AppRequest());
                    }

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