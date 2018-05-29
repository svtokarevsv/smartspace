<?php

namespace App\lib;
class Database
{
    private static $db;

    public static function getDb()
    {
        if (isset(self::$db)) {
            return self::$db;
        }
        $dsn = "mysql:host=" . Config::get('db.host') . ";dbname=" . Config::get('db.db_name');
        self::$db = new \PDO($dsn, Config::get('db.user'), Config::get('db.password'));
        self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        self::$db->query('SET NAMES UTF8');

        return self::$db;
    }
}
