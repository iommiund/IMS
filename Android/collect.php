<?php
require_once '../core/init.php';

$orderId = escape($_POST['orderId']);
$resource = escape($_POST['resource']);

$order = new order();

if ($orderId == null || $resource == null){
    echo 'All fields are required';
} else {

    $collect = $order->androidCollect($orderId,$resource);

}