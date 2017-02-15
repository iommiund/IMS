<?php
require_once 'core/init.php';
include_once("header.php");

if ($user->isLoggedIn()) {

    //check if user has permission
    if ($user->hasPermission('transferResourceLocation') || $user->hasPermission('allAccess')) {

        if (input::exists()) {

            //declare variables
            $from = escape(input::get('from'));
            $to = escape(input::get('to'));
            $currentLocationId = escape(input::get('currentLocationId'));
            $location = escape(input::get('locationId'));

            $inventory = new inventory();

            try {

                //validate resource transfer
                $inventory->createTransferRequest($from, $to, $currentLocationId, $location);


            } catch (Exception $e) {
                $hash = new hash();
                redirect::to('inventory.php?' . hash::sha256('couldNotCreateTransfer' . $hash->getSalt()));
            }
        }
    } else {
        redirect::to('main.php');
    }

} else {
    $hash = new hash();
    redirect::to('index.php?' . hash::sha256('nologin' . $hash->getSalt()));
}