<?php

namespace Jman\Core;

use Jman\Models\User;

class Router
{
    private static $routes = [];

    public static function add(string $url, string $classname, string $method, bool $login_required = true)
    {
        self::$routes[] = [
            'url' => $url,
            'classname' => $classname,
            'method' => $method,
            'login_required' => $login_required
        ];
    }


    public static function route($url)
    {

        foreach (self::$routes as $route) {

            if ($route['url'] == $url) {
                if ($route['login_required'] == true) {
                    LoginManager::isLoggedInOrRedirect();
                    return call_user_func([new $route['classname'](), $route['method']], new AppRequest());
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