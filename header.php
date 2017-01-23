<?php
/**
 * Created by PhpStorm.
 * User: lommi
 * Date: 23/01/2017
 * Time: 08:16 PM
 */
// Require init.php for core config and class auto load
require_once 'core/init.php';

$user = new user();

if ($user->isLoggedIn()) {

    $name = $user->data()->name;
    $surname = $user->data()->surname;
    $uid = $user->data()->uid;

    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <title>IMS</title>
        <link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $( function() {
                $( "#dialogOk" ).dialog({
                    modal: true,
                    buttons: {
                        Ok: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });
            } );
        </script>
    </head>
    <body>
    <-- Migrated from ITS RMS -->
    <div class="width-height">
        <div class="fixheader">
            <div class="header">
                <div class="logo">
                    <h1 class="header-heading"><strong>IMS</strong></h1>
                    <?php
                        echo $name . ' ' . $surname;
                    ?>
                </div>
                <div class="menu">
                    <ul class="nav">
                        <li><a href="main.php">Main</a></li>
                        <li><a href="addResource.php">Add Resource</a></li>
                        <li><a href="searchResource.php">Search</a></li>
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="help.php">Help Centre</a></li>
                        <li><a href="admin.php">Admin</a></li>
                    </ul>
                </div>
            </div>
            <div class="nav-bar">
                <div class="logout">
                    <a href="main.php?logout">Logout</a>
                </div>
            </div>
        </div>
        <-- migrated from index.php --!>
    <p>
        hello <b><a href="profile.php?user=<?php echo $username; ?>">
                <?php echo $name . ' ' . $surname; ?>
            </a></b>
    </p>

    <ul>
        <li><a href="logout.php">Log Out</a></li>
        <li><a href="updateProfile.php">Change Name</a></li>
        <li><a href="changePassword.php">Change Password</a></li>
    </ul>

    </body>
    </html>
    <?php

    //user permissions, apply to menu
    if ($user->hasPermission('admin')){
        echo 'you are an administrator';
    }

} else {
    echo '<p> You need to <a href="login.php">Login</a> or <a href="register.php">register</a> </p>';
}
?>