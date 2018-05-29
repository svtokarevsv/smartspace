<?php
namespace App\lib;
class Config
{
    protected static $settings = array();

    public static function get($key)
    {
        return isset(self::$settings) ? self::$settings[$key] : null;
    }

    public static function set($key, $value)
    {
        self::$settings[$key] = $value;
    }
}