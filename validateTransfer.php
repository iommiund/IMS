<?php
require_once 'core/init.php';
include_once ("header.php");

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('transferResourceLocation') || $user->hasPermission('allAccess')){
        ?>
        <div class="content">
            <div class="container">
        <?php

        //Validate user input
        if(input::exists()){

            //validate user input
            $validate = new validate();
            $validation = $validate->check($_POST,array(
                'from' => array('required' => true),
                'to' => array('required' => true),
                'location' => array('required' => true)
            ));

            //if user input validation passed
            if ($validation->passed()) {

                //declare variables
                $from = escape(input::get('from'));
                $to = escape(input::get('to'));
                $currentLocationId = escape(input::get('currentLocationId'));
                $location = escape(input::get('location'));

                $inventory = new inventory();

                try {

                    //validate resource transfer
                    $inventory->validateTransfer($from, $to, $currentLocationId, $location);


                } catch (Exception $e) {
                    //create message to display on user creation
                    ?>
                    <div id="dialogOk" title="Error">
                        <p>&#x26a0; ERROR</p>
                    </div>
                    <?php
                }

            } else {
                //redirect to inventory.php with error
                $hash = new hash();
                redirect::to('inventory.php?' . hash::sha256('allFieldsRequired' . $hash->getSalt()));
            }


        } else {
            redirect::to('main.php');
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