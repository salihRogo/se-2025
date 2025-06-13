<?php

class Database
{
    private static $host;
    private static $dbName;
    private static $username;
    private static $password;

    private static function loadConfig()
    {
        if (!isset(self::$host)) {
            require_once __DIR__ . '/../../config.php';
            self::$host = Config::DB_HOST();
            self::$dbName = Config::DB_NAME();
            self::$username = Config::DB_USER();
            self::$password = Config::DB_PASSWORD();
        }
    }
    private static $connection = null;

    public static function connect()
    {
        if (self::$connection === null) {
            Database::loadConfig();
            try {
                self::$connection = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$dbName,
                    self::$username,
                    self::$password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
