<?php
require_once 'core/init.php';
include_once("header.php");

if ($user->isLoggedIn()) {

    //check if user has permission
    if ($user->hasPermission('changeUserStatus') || $user->hasPermission('allAccess')) {
        if (input::exists()) {

            if (token::check(input::get('token'))) {

                $validate = new validate();
                $validation = $validate->check($_POST, array(
                    'location' => array('required' => true),
                    'type' => array('required' => true)
                ));

                if ($validation->passed()) {

                    try {

                        $l = escape(input::get('location'));
                        $t = escape(input::get('type'));

                        $update = db::getInstance()->query("update ims.resource_locations set resource_location_type_id = {$t} where resource_location_id = {$l}");

                        //get data to display dialog
                        $get = db::getInstance()->query("select rl.resource_location_name, lt.resource_location_type from ims.resource_locations rl inner join ims.resource_location_types lt on rl.resource_location_type_id = lt.resource_location_type_id where resource_location_id = {$l}");

                        //display dialog
                        if (!$get->count()) {

                            echo 'not ok';

                        } else {

                            //create message to display on user creation
                            ?>
                            <div id="dialogOk" title="Success">
                            <p>
                            <?php
                            foreach ($get->results() as $data) {
                                echo '<b>' . $data->resource_location_name . '</b> has been updated to <b>' . $data->resource_location_type . '</b>.';
                                ?>
                                </p>
                                </div>
                                <?php
                            }
                        }

                    } catch (Exception $e) {
                        die($e->getMessage());
                    }

                } else {
                    ?>
                    <div id="dialogOk" title="Error">
                        <?php
                        foreach ($validation->errors() as $error) {
                            echo "&#x26a0; " . $error . "", '<br>';
                        }
                        ?>
                    </div>
                    <?php
                }
            }
        }
        ?>
        <div class="content">
            <div class="container">
                <div class="form-style">
                    <h1>Change Location Type</h1>
                    <form action="" method="post">
                        <select name="location">
                            <option value="">----------------------- Choose a Location -----------------------</option>
                            <?php

                            $get = db::getInstance()->query("select resource_location_id, resource_location_name from ims.resource_locations order by 1");

                            if (!$get->count()) {
                                echo 'Empty List';
                            } else {

                                foreach ($get->results() as $l): ?>
                                    <option value="<?php echo escape($l->resource_location_id); ?>">
                                        <?php echo escape($l->resource_location_name); ?>
                                    </option>
                                <?php endforeach;

                            }
                            ?>
                        </select>
                        <select name="type">
                            <option value="">------------------------- Choose a Type -------------------------</option>
                            <?php
                            $get = db::getInstance()->query('select * from ims.resource_location_types order by 1');

                            if (!$get->count()) {
                                echo 'Empty List';
                            } else {

                                foreach ($get->results() as $t): ?>
                                    <option value="<?php echo escape($t->resource_location_type_id); ?>">
                                        <?php echo escape($t->resource_location_type); ?>
                                    </option>
                                <?php endforeach;

                            }
                            ?>
                        </select>
                        <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                        <input type="submit" value="UPDATE"/>
                    </form>
                </div>
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