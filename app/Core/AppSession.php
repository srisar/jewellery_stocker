<?php

namespace Jman\Core;

use Exception;
use Jman\Exceptions\CoreException;

class AppSession
{


    const CSRF_TOKEN = 'csrf_token';

    public static function init()
    {
        session_start();
    }

    public static function terminate()
    {
        $_SESSION = null;
        session_destroy();
    }

    public static function getData($key)
    {
        if (isset($_SESSION[$key]))
            return $_SESSION[$key];

        return null;
    }

    public static function setData($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Generate a cryptographically strong CSRF token,
     * and store it in the session.
     */
    public static function generateCSRFToken()
    {

        try {
            $bytes = random_bytes(32);

            $_SESSION[self::CSRF_TOKEN] = bin2hex($bytes);

        } catch (Exception $e) {
            die($e->getMessage());
        }

    }

    public static function destroyCSRFToken()
    {
        unset($_SESSION[self::CSRF_TOKEN]);
    }

    /**
     * Returns the generated  CSRF token, if not generated already, new one will be generated.
     * @return string
     */
    public static function getCSRFToken()
    {
        if (isset($_SESSION[self::CSRF_TOKEN]) && !empty($_SESSION[self::CSRF_TOKEN])) {
            return $_SESSION[self::CSRF_TOKEN];
        } else {
            self::generateCSRFToken();
            return self::getCSRFToken();
        }
    }

    /**
     * Add a hidden input filed into a form with csrf key.
     */
    public static function injectCSRFToken()
    {
        ?><input type="hidden" name="csrf_token" value="<?= self::getCSRFToken() ?>"><?php
    }


    /**
     * This checks if the token submitted from user is same as the original one.
     * @param $token
     * @return bool
     * @throws CoreException
     */
    public static function validateCSRFToken($token): bool
    {
        if (isset($_SESSION[self::CSRF_TOKEN]) && !empty($_SESSION[self::CSRF_TOKEN])) {
            return hash_equals($_SESSION[self::CSRF_TOKEN], $token);
        }
        throw new CoreException("CSRF token failed.");

    }


}
