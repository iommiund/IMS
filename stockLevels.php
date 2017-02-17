<?php
require_once 'core/init.php';
include_once ("header.php");

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('allStockLevels') || $user->hasPermission('allAccess')){
        ?>
        <div class="content">
            <div class="container">
        <?php
        if ($user->hasPermission('allStockLevels') || $user->hasPermission('allAccess')) {

            $inventory = new inventory();

            //show pending transfers
            $inventory->allStockLevels();

        }
        ?>
            </div>
        </div>
        <?php
    } else {
        redirect::to('main.php');
    }

} else {
    $hash = new hash();
    redirect::to('index.php?' . hash::sha256('nologin' . $hash->getSalt()));
}