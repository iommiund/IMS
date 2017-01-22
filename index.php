<?php

// Require init.php for core config and class auto load
require_once 'core/init.php';

//display message from user creation
if (session::exists('home')){
    echo session::flash('home');
}

$user = new user();

if ($user->isLoggedIn()){

    $name = $user->data()->name;
    $surname = $user->data()->surname;
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <title>IMS Login</title>
        <link rel='stylesheet prefetch'
              href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <p>
        hello <b><a href="#"><?php echo $name . ' ' . $surname; ?></a></b>
    </p>

    <ul>
        <li><a href="logout.php">Log Out</a></li>
        <li><a href="updateProfile.php">Change Name</a></li>
        <li><a href="changePassword.php">Change Password</a></li>
    </ul>

    </body>
    </html>
    <?php
} else {
    echo '<p> You need to <a href="login.php">Login</a> or <a href="register.php">register</a> </p>';
}
?>