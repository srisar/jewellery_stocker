<?php


namespace Jman\Core;

use Jman\Models\User;

class LoginManager
{

    private const USER_ID = 'user_id';
    private const LOGGED_IN = 'logged_in';
    private const USER_NAME = 'user_name';
    private const USER_ROLE = 'role';

    /**
     * Get the user Id
     * @return int
     */
    public static function getUserId()
    {
        return AppSession::getData(self::USER_ID);
    }

    /**
     * Sets the user Id
     * @param int $id
     */
    public static function setUserId(int $id)
    {
        AppSession::setData(self::USER_ID, $id);
    }

    /**
     * Sets the username
     * @param string $username
     */
    public static function setUsername(string $username)
    {
        AppSession::setData(self::USER_NAME, $username);
    }

    /**
     * Gets the username
     * @return string
     */
    public static function getUsername()
    {
        return AppSession::getData(self::USER_NAME);
    }

    /**
     * Sets the user role. Role must be of ADMIN or USER
     * @param $role
     */
    public static function setUserRole($role)
    {
        AppSession::setData(self::USER_ROLE, $role);
    }

    /**
     * Gets the user role
     * @return string
     */
    public static function getUserRole()
    {
        return AppSession::getData(self::USER_ROLE);
    }

    /**
     *
     * @param bool $state
     */
    public static function setIsLoggedIn(bool $state)
    {
        AppSession::setData(self::LOGGED_IN, $state);
    }

    /**
     * Checks if user is logged in, returns true if so.
     * @return bool
     */
    public static function isLoggedIn()
    {
        return AppSession::getData(self::LOGGED_IN);
    }

    /**
     * Check if user is logged in, or redirect to login page
     */
    public static function isLoggedInOrRedirect()
    {

        if (!self::isLoggedIn()) {
            App::redirect('/login');
        }
    }

    /**
     * @return bool
     */
    public static function isAdmin()
    {
        return AppSession::getData(self::USER_ROLE) == User::ROLE_ADMIN;
    }

    /**
     * @return bool
     */
    public static function isUser()
    {
        return AppSession::getData(self::USER_ROLE) == User::ROLE_USER;
    }

    /**
     * Takes a user object from db and checks against given password string,
     * if matched, then correct user is found and user data is added to
     * the session data.
     *
     * @param User $user
     * @param $password_string
     * @return bool
     */
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

    /**
     * Logs out the user
     */
    public static function logout()
    {
        AppSession::terminate();
    }

    /**
     * Initialize user data into session
     * @param User $user
     */
    private static function initLoggedInUserData(User $user)
    {
        self::setUserId($user->getId());
        self::setUsername($user->getFullName());
        self::setUserRole($user->getRole());
        self::setIsLoggedIn(true);
    }


}