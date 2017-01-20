<?php

/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 18/01/2017
 * Time: 20:50
 */
class session
{
    //if the session exists return true, otherwise return false
    public static function exists($name){
        return (isset($_SESSION[$name])) ? true : false;
    }

    //insert a session value
    public static function put($name, $value){
        return $_SESSION[$name] = $value;
    }

    public static function get($name){
        return $_SESSION[$name];
    }

    //delete session if exists
    public static function delete($name){
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    //flash message if user refreshes page, example success message after add user
    public static function flash($name, $string = ''){
        if (self::exists($name)){
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name, $string);
        }
    }
}