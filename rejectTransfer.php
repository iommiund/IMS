<?php
require_once 'core/init.php';
include_once ("header.php");

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('rejectTransfer') || $user->hasPermission('allAccess')){

        if(isset($_GET['id'])){

            $user = new user();

            //set variables
            $transferId = escape($_GET['id']);
            $uid = escape($user->data()->uid);

            //call method to accept transfer
            $inventory = new inventory();

            try {

                //validate resource transfer
                $inventory->rejectTransfer($uid,$transferId);

            } catch (Exception $e) {
                $hash = new hash();
                redirect::to('main.php?' . hash::sha256('couldNotRejectTransfer' . $hash->getSalt()));
            }

        } else {
            redirect::to('index.php');
        }

    } else {
        redirect::to('main.php');
    }

} else {
    $hash = new hash();
    redirect::to('index.php?' . hash::sha256('nologin' . $hash->getSalt()));
}