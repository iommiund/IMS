<?php
require_once 'core/init.php';
include_once ("header.php");

//$user = new user();

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('search') || $user->hasPermission('allAccess')){
        ?>
        <div class="content">
            <div class="container">
        <?php

        //Validate user input
        if (input::exists()) {

            $field = escape(input::get('search'));

            $inventory = new inventory();
            $customer = new customer();

            try {

                //search resource
                $inventory->searchResource($field);

                //search customer
                $customer->searchCustomer($field);

            } catch (Exception $e) {
                //create message to display on user creation
                ?>
                <div id="dialogOk" title="Error">
                    <p>&#x26a0; ERROR</p>
                </div>
                <?php
            }
        }
        ?>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('table tr:nth-child(odd)').addClass('alt');
                    });
                </script>
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