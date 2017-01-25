<?php
require_once 'core/init.php';
include_once("header.php");

if ($user->isLoggedIn()) {

    //check if user has permission
    if ($user->hasPermission('admin') || $user->hasPermission('allAccess')) {
        ?>
        <div class="content">
            <div class="container">
                <h1>Administration Page</h1>
                <hr>
                <div class="admin">
                    <ul class="admin">
                        <?php
                        if ($user->hasPermission('addUser') || $user->hasPermission('allAccess')) {
                            echo '<li><a href="addUser.php">Add New User</a></li><br><br>';
                        }
                        if ($user->hasPermission('changeUserStatus') || $user->hasPermission('allAccess')) {
                            echo '<li><a href="changeUserStatus.php">Change User Status</a></li><br><br>';
                        }
                        if ($user->hasPermission('changeUserType') || $user->hasPermission('allAccess')) {
                            echo '<li><a href="changeUserType.php">Change User Type</a></li><br><br>';
                        }
                        echo '<hr>';
                        if ($user->hasPermission('allLocation') || $user->hasPermission('allAccess')) {
                            echo '<li><a href="addLocation.php">Add New Location</a></li><br><br>';
                        }
                        if ($user->hasPermission('addLocationType') || $user->hasPermission('allAccess')) {
                            echo '<li><a href="addLocationType.php">Add New Location Type</a></li><br><br>';
                        }
                        echo '<hr>';
                        if ($user->hasPermission('addResourceType') || $user->hasPermission('allAccess')) {
                            echo '<li><a href="addResourceType.php">Add New Resource Type</a></li><br><br>';
                        }
                        if ($user->hasPermission('addResourceStatus') || $user->hasPermission('allAccess')) {
                            echo '<li><a href="addResourceStatus.php">Add New Resource Status</a></li><br><br>';
                        }
                        if ($user->hasPermission('addResourceModel') || $user->hasPermission('allAccess')) {
                            echo '<li><a href="addResourceModel.php">Add New Resource Model</a></li><br><br>';
                        }
                        if ($user->hasPermission('addResourceBrand') || $user->hasPermission('allAccess')) {
                            echo '<li><a href="addResourceBrand.php">Add New Resource Brand</a></li><br><br>';
                        }
                        ?>
                    </ul>
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