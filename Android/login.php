<?php
require_once '../core/init.php';

$username = "iommi";
$password = "iommi";

$user = new user();

$login = $user->androidLogin($username,$password);

if($login){
    echo 'login success';
} else {
    echo 'deep shit';
}
