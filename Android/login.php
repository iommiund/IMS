<?php
require_once '../core/init.php';

$username = escape($_POST['username']);
$password = escape($_POST['password']);

$user = new user();

$login = $user->androidLogin($username,$password);

if($login){
    echo 'Login Success';
} else {
    echo 'Login Unsuccessful';
}
