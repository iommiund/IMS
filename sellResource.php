<?php
require_once 'core/init.php';
include_once ("header.php");

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('sellResource') || $user->hasPermission('allAccess')){

        $inventory = new inventory();
        $userLocationId = $user->data()->resource_location_id;

        //check input, else redirect
        if(isset($_GET['id'])){

            $resourceId = escape($_GET['id']);

        } else {
            redirect::to('main.php');
        }

        //check that resource can be sold else redirect
        if (isset($resourceId)){

            //confirm that resource can be sold
            $inventory->sellResource($resourceId,$userLocationId);

        } else {

        }
    } else {
        redirect::to('main.php');
    }

} else {
    $hash = new hash();
    redirect::to('index.php?' . hash::sha256('nologin' . $hash->getSalt()));
}