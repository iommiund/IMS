<?php
require_once 'core/init.php';
include_once ("header.php");

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('orderInstallResource') || $user->hasPermission('allAccess')){

        if(input::exists()){

            $customerId = escape(input::get('customerId'));
            $street = escape(input::get('street'));
            $town = escape(input::get('town'));
            $resourceTypeId = escape(input::get('Type'));
            $uid = escape($user->data()->uid);

            $order = new order();

            $order->createInstallOrder($customerId,$resourceTypeId,$uid);

        }

    } else {
        redirect::to('main.php');
    }

} else {
    $hash = new hash();
    redirect::to('index.php?' . hash::sha256('nologin' . $hash->getSalt()));
}