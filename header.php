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

    //extra layer of access checking in case user is enabled but still not allowed access
    if ($user->hasPermission('disabled')){

        $user->logout();
        $hash = new hash();
        redirect::to('index.php?' . hash::sha256('disabled' . $hash->getSalt()));

    }

    $name = escape($user->data()->name);
    $surname = escape($user->data()->surname);
    $uid = escape($user->data()->uid);

    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <title>IMS</title>
        <link rel='stylesheet prefetch'
                href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
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
    <div class="width-height">
        <div class="fixheader">
            <div class="header">
                <div class="logo">
                    <ul class="nav">
                        <?php
                        $hash = new hash();
                        if ($user->hasPermission('access') || $user->hasPermission('allAccess')){
                            echo '<li><a href="profile.php">' . $name . ' ' . $surname . '</a></li>';
                        }
                        ?>
                    </ul>
                    <h1 class="header-heading"><strong>IMS</strong>HUB</h1>
                </div>
                <div class="menu">
                    <ul class="nav">
                        <?php
                        if ($user->hasPermission('access') || $user->hasPermission('allAccess')){
                            echo '<li><a href="main.php">Main</a></li>';
                        }
                        if ($user->hasPermission('search') || $user->hasPermission('allAccess')){
                            echo '<li><a href="search.php">Search</a></li>';
                        }
                        if ($user->hasPermission('newInventory') || $user->hasPermission('allAccess')){
                            echo '<li><a href="newInventory.php">New Inventory</a></li>';
                        }
                        if ($user->hasPermission('newCustomer') || $user->hasPermission('allAccess')){
                            echo '<li><a href="newCustomer.php">New Customer</a></li>';
                        }
                        if ($user->hasPermission('stockLevels') || $user->hasPermission('allAccess')){
                            echo '<li><a href="stockLevels.php">Stock Levels</a></li>';
                        }
                        if ($user->hasPermission('reports') || $user->hasPermission('allAccess')){
                            echo '<li><a href="reports.php">Reports</a></li>';
                        }
                        if ($user->hasPermission('admin') || $user->hasPermission('allAccess')){
                            echo '<li><a href="admin.php">Admin</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="nav-bar">
                <div class="logout">
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
} else {
    $hash = new hash();
    redirect::to('index.php?' . hash::sha256('nologin' . $hash->getSalt()));
}
?>