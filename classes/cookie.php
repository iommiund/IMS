<?php

/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 18/01/2017
 * Time: 20:47
 */
class cookie
{
    public static function exists($name) {
        return (isset($_COOKIE[$name])) ? true : false;
    }

    public static function get($name){
        return $_COOKIE[$name];
    }

    public static function put($name, $value, $expiry){
        if (setcookie($name, $value, time() + $expiry, '/')) {
            return true;
        }
        return false;
    }

    public static function delete($name){
        self::put($name, '', time() - 1);
    }
}