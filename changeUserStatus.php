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
                    'user' => array('required' => true),
                    'status' => array('required' => true)
                ));

                if ($validation->passed()) {

                    try {

                        $u = escape(input::get('user'));
                        $s = escape(input::get('status'));

                        //if new status is disabled
                        if ($s == 2) {

                            //update user type_id to 9 (disabled)
                            $update = db::getInstance()->query("update ims.users set user_type_id = 9, user_status_id = {$s} where uid = {$u}");

                            //get data to display dialog
                            $get = db::getInstance()->query("select concat(u.name, ' ', u.surname) name, us.user_status from ims.users u inner join ims.user_statuses us on u.user_status_id = us.user_status_id where u.uid = {$u}");

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
                                    echo 'Status of <b>' . $data->name . '</b> has been updated to <b>' . $data->user_status . '</b>.';
                                    ?>
                                    </p>
                                    </div>
                                    <?php
                                }
                            }
                        } else if ($s == 1) {

                            //update user type_id to 9 (disabled)
                            $update = db::getInstance()->query("update ims.users set user_status_id = {$s} where uid = {$u}");

                            //get data to display dialog
                            $get = db::getInstance()->query("select concat(u.name, ' ', u.surname) name, us.user_status from ims.users u inner join ims.user_statuses us on u.user_status_id = us.user_status_id where u.uid = {$u}");

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
                                    echo 'Status of <b>' . $data->name . '</b> has been updated to <b>' . $data->user_status . '</b>.<br><br>';
                                    echo 'You must ';
                                    if ($user->hasPermission('changeUserType') || $user->hasPermission('allAccess')) {
                                        echo '<a href="changeUserType.php">update the user profile</a>';
                                    }
                                    ?>
                                    </p>
                                    </div>
                                    <?php
                                }
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
                    <h1>Change User Status</h1>
                    <form action="" method="post">
                        <select name="user">
                            <option value="">----------------------- Choose a User -----------------------</option>
                            <?php

                            $get = db::getInstance()->query("select uid, username from users where uid <> {$uid} order by uid");

                            if (!$get->count()) {
                                echo 'Empty List';
                            } else {

                                foreach ($get->results() as $u): ?>
                                    <option value="<?php echo escape($u->uid); ?>">
                                        <?php echo escape($u->username); ?>
                                    </option>
                                <?php endforeach;

                            }
                            ?>
                        </select>
                        <select name="status">
                            <option value="">---------------------- Choose a Status ----------------------</option>
                            <?php
                            $get = db::getInstance()->query('select user_status_id, user_status from user_statuses order by user_status_id');

                            if (!$get->count()) {
                                echo 'Empty List';
                            } else {

                                foreach ($get->results() as $s): ?>
                                    <option value="<?php echo escape($s->user_status_id); ?>">
                                        <?php echo escape($s->user_status); ?>
                                    </option>
                                <?php endforeach;

                            }
                            ?>
                        </select>
                        <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                        <input type="submit" value="UPDATE"/>
                    </form>
                    <br>
                    <!--ERROR MESSAGES-->
                    <div class="form-link">
                        <?php
                        if (isset($_GET['error'])) {
                            echo "<div id='error'>The user already has this status!</div>";
                        } else if (isset($_GET['success'])) {
                            echo "<div id='success'>Status Changed!</div>";
                        }
                        ?>
                    </div>
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