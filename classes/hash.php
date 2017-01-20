<?php

/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 18/01/2017
 * Time: 20:49
 */
class hash
{

    // make hash password from string and salt value
    public static function make($string, $salt = ''){
        return hash('sha256', $string . $salt);
    }

    //generate random salt
    public static function salt($length){
        return mcrypt_create_iv($length);
    }

    public static function unique(){
        return self::make(uniqid());
    }
}