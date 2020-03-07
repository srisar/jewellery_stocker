<?php

namespace Jman\Core;


use Jman\Core\Exceptions\CoreException;

class View
{

    private static $data = [];
    private static $errors = [];


    /**
     * @param $key
     * @param $value
     */
    public static function setData($key, $value)
    {
        self::$data[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function getData($key)
    {
        if (array_key_exists($key, self::$data)) {
            return self::$data[$key];
        }

        return null;
    }

    public static function setError($value, $key = 'error')
    {
        self::$errors[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function getError($key = 'error')
    {
        if (array_key_exists($key, self::$errors)) {
            return self::$errors[$key];
        }
        return null;
    }

    public static function hasError($key = 'error')
    {
        return isset(self::$errors[$key]);
    }

    /**
     * Render view from 'views' folder.
     * Skip 'views' and '.php' in the param.
     * @param $view
     */
    public static function render($view)
    {
        $folder = '../views';
        include_once $folder . "/" . $view . '.php';

    }

}