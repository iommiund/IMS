<?php
/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 18/01/2017
 * Time: 20:53
 */
session_start(); // start session

$GLOBALS['config'] = array(
   'mysql' => array(
       'host' => '127.0.0.1',
       'username' => 'root',
       'password' => '',
       'db' => 'ims'
   ),
   'remember' => array(
       'cookie_name' => 'hash',
       'cookie_expiry' => 604800
   ),
   'session' => array(
       'session_name' => 'user',
       'token_name' => 'token'
   )
);

// auto initiate classes
spl_autoload_register(function ($class){
    require_once 'classes/' . $class . '.php';
});

require_once 'functions/sanitize.php';