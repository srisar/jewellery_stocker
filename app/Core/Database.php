<?php


namespace Jman\Core;

use PDO, PDOException;

class Database
{
    private static $config = [
        "host" => null,
        "dbname" => null,
        "user" => null,
        "pass" => null,
        "options" => []
    ];

    /** @var PDO $pdo */
    private static $pdo;


    public static function init($config)
    {
        self::$config = $config;

        try {

            $dsn = sprintf("mysql:host=%s;dbname=%s", self::$config['host'], self::$config['dbname']);

            /** @var PDO $pdo */
            self::$pdo = new PDO($dsn, self::$config['user'], self::$config['pass'], self::$config['options']);

        } catch (PDOException $exception) {
            die($exception->getMessage());
        }


    }


    /**
     * @return PDO
     */
    public static function get_instance()
    {
        if (empty(self::$pdo)) {
            self::init(self::$config);
            return self::$pdo;
        }
        return self::$pdo;
    }


    /**
     * Closes the PDO connection
     */
    public static function close()
    {
        self::$pdo = null;
    }

}