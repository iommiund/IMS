<?php
require_once 'core/init.php';
include_once ("header.php");

if ($user->isLoggedIn()){

    $customerId = escape($_GET['customerId']);

    //check if user has permission
    if ($user->hasPermission('orderReplaceResource') || $user->hasPermission('allAccess')){

        if(isset($_GET['resource'])){

            $customerId = escape($_GET['customerId']);
            $resource = escape($_GET['resource']);
            $resourceTypeId = escape($_GET['resourceTypeId']);
            $uid = escape($user->data()->uid);

            $order = new order();
            $order->createReplaceOrder($customerId,$resource,$resourceTypeId,$uid);

        }

    } else {
        redirect::to('viewCustomerDetails.php?id=' . $customerId . '&accessDenied');
    }

} else {
    $hash = new hash();
    redirect::to('index.php?' . hash::sha256('nologin' . $hash->getSalt()));
}