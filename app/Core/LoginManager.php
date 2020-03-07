<?php


namespace Jman\Core;

use Jman\Models\User;

class LoginManager
{

    private const USER_ID = 'user_id';
    private const LOGGED_IN = 'logged_in';
    private const USER_NAME = 'user_name';

    /**
     *
     * @return int
     */
    public static function getUserId()
    {
        return AppSession::getData(self::USER_ID);
    }

    /**
     * @param int $id
     */
    public static function setUserId(int $id)
    {
        AppSession::setData(self::USER_ID, $id);
    }

    /**
     * @param string $username
     */
    public static function setUsername(string $username)
    {
        AppSession::setData(self::USER_NAME, $username);
    }

    public static function getUsername()
    {
        return AppSession::getData(self::USER_NAME);
    }

    /**
     * @param bool $state
     */
    public static function setIsLoggedIn(bool $state)
    {
        AppSession::setData(self::LOGGED_IN, $state);
    }

    /**
     * @return bool
     */
    public static function isLoggedIn()
    {
        return AppSession::getData(self::LOGGED_IN);
    }

    public static function isLoggedInOrRedirect()
    {

        if (!self::isLoggedIn()) {
            App::redirect('/login');
        }
    }

    public static function validateLogin(User $user, $password_string)
    {
        if (empty($user)) {
            return false;
        } else {
            if (password_verify($password_string, $user->getPasswordString())) {
                self::initLoggedInUserData($user);
                return true;
            }
        }

        return false;
    }

    public static function logout()
    {
        AppSession::terminate();
    }

    /**
     * @param User $user
     */
    private static function initLoggedInUserData(User $user)
    {
        self::setUserId($user->getId());
        self::setUsername($user->getFullName());
        self::setIsLoggedIn(true);
    }


}