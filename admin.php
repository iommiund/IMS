<?php
require_once 'core/init.php';
include_once("header.php");

if ($user->isLoggedIn()) {

    //check if user has permission
    if ($user->hasPermission('admin') || $user->hasPermission('allAccess')) {
        ?>
        <div class="content">
            <div class="container">
                <div class="admin">
                    <div class="separator">
                        <h1>Administration</h1>
                        <h2>Users</h2>
                    </div>
                    <table class="ctable">
                        <tr>
                            <td colspan="2">
                                <?php
                                if ($user->hasPermission('addUser') || $user->hasPermission('allAccess')) {
                                    echo '<a href="addUser.php">Add New User</a>';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php
                                if ($user->hasPermission('changeUserStatus') || $user->hasPermission('allAccess')) {
                                    echo '<a href="changeUserStatus.php">Change User Status</a>';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php
                                if ($user->hasPermission('changeUserType') || $user->hasPermission('allAccess')) {
                                    echo '<a href="changeUserType.php">Change User Type</a>';
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                    <div class="separator">
                        <h2>Locations</h2>
                    </div>
                    <table class="ctable">
                        <tr>
                            <td colspan="2">
                                <?php
                                if ($user->hasPermission('addLocation') || $user->hasPermission('allAccess')) {
                                    echo '<a href="addLocation.php">Add New Location</a>';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php
                                if ($user->hasPermission('addLocationType') || $user->hasPermission('allAccess')) {
                                    echo '<a href="addLocationType.php">Add New Location Type</a>';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php
                                if ($user->hasPermission('changeLocationType') || $user->hasPermission('allAccess')) {
                                    echo '<a href="changeLocationType.php">Change Location Type</a>';
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                    <div class="separator">
                        <h2>Resources</h2>
                    </div>
                    <table class="ctable">
                        <tr>
                            <td>
                                <?php
                                if ($user->hasPermission('addResourceType') || $user->hasPermission('allAccess')) {
                                    echo '<a href="addResourceType.php">Add New Resource Type</a>';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                if ($user->hasPermission('addResourceStatus') || $user->hasPermission('allAccess')) {
                                    echo '<a href="addResourceStatus.php">Add New Resource Status</a>';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                if ($user->hasPermission('addResourceModel') || $user->hasPermission('allAccess')) {
                                    echo '<a href="addResourceModel.php">Add New Resource Model</a>';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                if ($user->hasPermission('addResourceBrand') || $user->hasPermission('allAccess')) {
                                    echo '<a href="addResourceBrand.php">Add New Resource Brand</a>';
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $('table tr:nth-child(odd)').addClass('alt');
                        });
                    </script>
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