<?php
require_once 'core/init.php';
include_once ("header.php");

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('changeUserStatus') || $user->hasPermission('allAccess')){
        ?>
        <div class="content">
            <div class="container">
                <div class="form-style">
                    <h1>Change User Status</h1>
                    <form action="userStatusChange.php" method="post">
                        <select name="user">
                                <option value="">----------------------- Choose a User -----------------------</option>
                                <?php
                                    $get = db::getInstance()->query('select uid, username from users order by uid');

                                    if (!$get->count()){
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

                            if (!$get->count()){
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
                        <input type="submit" value="UPDATE" />
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