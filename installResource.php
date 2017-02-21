<?php
require_once 'core/init.php';
include_once ("header.php");

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('orderInstallResource') || $user->hasPermission('allAccess')){

        if(input::exists()){

            $customerId = escape(input::get('customerId'));
            $resourceType = escape(input::get('Type'));

            $customer = new customer();

            $customerId->createInstallOrder($customerId,$resourceType);

        }

    } else {
        redirect::to('main.php');
    }

} else {
    $hash = new hash();
    redirect::to('index.php?' . hash::sha256('nologin' . $hash->getSalt()));
}