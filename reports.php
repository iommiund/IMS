<?php
require_once 'core/init.php';
include_once ("header.php");

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('reports') || $user->hasPermission('allAccess')){
        ?>
        <div class="content">
            <div class="container">
            <?php
            $inventory = new inventory();

            //show stock levels at location
            $inventory->salesInYearChart();
            $inventory->replaceInYearChart();
            $inventory->collectInYearChart();
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