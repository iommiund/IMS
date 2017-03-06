<?php
require_once '../core/init.php';

$orderId = escape($_POST['orderId']);
$resource = escape($_POST['resource']);

$order = new order();

if ($orderId == null || $resource == null){
    echo 'All fields are required';
} else {

    $install = $order->androidInstall($orderId,$resource);
    if($install){
        echo 'Install Successful';
    } else {
        echo 'Install Unsuccessful';
    }
    
}
