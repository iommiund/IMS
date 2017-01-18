<?php

/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 18/01/2017
 * Time: 20:46
 */
class config
{
    /** get mysql parameters from init.php and loop through array */
    public static function get($path = null){
        if ($path){
            $config = $GLOBALS['config'];
            $path = explode('/', $path);

            foreach ($path as $bit){
                if (isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }

            return $config;
        }

        /** In case of empty parameters return false */
        return false;

    }
}