<?php

/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 18/01/2017
 * Time: 20:49
 */
class hash
{
    private $_salt = '^È7xdHì—|"ò¤RÊË"»Ù%òÃQ2ÁÞ‡Üh';

    // make hash password from string and salt value
    public static function make($string, $salt = ''){
        return hash('sha256', $string . $salt);
    }

    public static function sha256($string){
        return hash('sha256', $string);
    }

    //generate random salt
    public static function salt($length){
        return mcrypt_create_iv($length);
    }

    public static function unique(){
        return self::make(uniqid());
    }

    public function getSalt(){
        return $this->_salt;
    }
}