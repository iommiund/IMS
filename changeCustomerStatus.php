<?php
require_once 'core/init.php';
include_once ("header.php");

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('changeCustomerStatus') || $user->hasPermission('allAccess')){
        if(isset($_GET['id'])){

            $customerId = escape($_GET['id']);
            $statusId = escape($_GET['statusId']);

            $customer = new customer();

            $customer->changeCustomerStatus($customerId,$statusId);

        } else {
            redirect::to('main.php');
        }
    } else {
        redirect::to('main.php');
    }

} else {
    $hash = new hash();
    redirect::to('index.php?' . hash::sha256('nologin' . $hash->getSalt()));
}