<?php

/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 18/01/2017
 * Time: 20:49
 */
class input
{
    public static function exists($type = 'post'){
        switch ($type) {
            case 'post';
                return (!empty($_POST)) ? true : false; //If POST is not set return true, otherwise return false
                break;
            case 'get';
                return (!empty($_GET)) ? true : false; //If GET is not set return true, otherwise return false
                break;
            default:
                return false;
                break;
        }
    }

    public static function get($item){
        if(isset($_POST[$item])){
            return $_POST[$item];
        } else if (isset($_GET[$item])){
            return $_GET[$item];
        }
        return '';
    }
}