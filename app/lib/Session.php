<?php
namespace App\lib;

abstract class Session
{
    public static $flash_message;

    public static function setFlash($message)
    {
        $_SESSION['flash_message'] = " <div class='alert alert-info margin-top15' role='alert'>$message</div>";
    }
    public static function setErrorFlash($message)
    {
        $_SESSION['flash_message'] = " <div class='alert alert-warning margin-top15' role='alert'>$message</div>";
    }

    public static function hasFlash()
    {
        return null!=$_SESSION['flash_message'];
    }

    public static function flash()
    {
        echo $_SESSION['flash_message'];
        $_SESSION['flash_message'] = null;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
        return null;
    }

    public static function delete($key)
    {
        if(isset($_SESSION[$key])){
            unset ($_SESSION[$key]);
        }
    }
    public static function destroy()
    {
        session_destroy();
    }
}
