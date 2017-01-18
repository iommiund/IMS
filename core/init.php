<?php
/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 18/01/2017
 * Time: 20:53
 */
session_start();

$GLOBALS['config'] = array(
   'mysql' => array(
       'host' => '127.0.0.1',
       'username' => 'root',
       'password' => '',
       'db' => 'ims_iommiunderwood'
   ),
   'remember' => array(
       'cookie_name' => 'hash',
       'cookie_expiry' => 86400
   ),
   'session' => array(
       'session_name' => 'user'
   )
);

spl_autoload_register(function ($class){
    require_once 'classes/' . $class . '.php';
});

require_once 'functions/sanitize.php';