<?php

class C_Database_Handler
{
    const DB_HOST = 'localhost';
    const DB_NAME = 'sroleplay';
    const DB_USER = 'root';
    const DB_PASS = '';

    protected static $_dbo;

    public static function instantiate($dbHost = '', $dbName = '', $dbUser = '', $dbPass = '')
    {
        try {
            if (null != self::$_dbo) {
                return self::$_dbo;
            }

            if (empty($dbHost)) $dbHost = self::DB_HOST;
            if (empty($dbName)) $dbName = self::DB_NAME;
            if (empty($dbUser)) $dbUser = self::DB_USER;
            if (empty($dbPass)) $dbPass = self::DB_PASS;

            return new PDO(
                sprintf('mysql:host=%s;dbname=%s', $dbHost, $dbName),
                $dbUser,
                $dbPass
            );
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public static function getDBO()
    {
        if (null === self::$_dbo) {
            self::$_dbo = self::instantiate();
        }
        return self::$_dbo;
    }
}