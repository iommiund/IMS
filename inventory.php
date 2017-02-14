<?php
require_once 'core/init.php';
include_once("header.php");

//$user = new user();

if ($user->isLoggedIn()) {

    //check if user has permission
    if ($user->hasPermission('inventory') || $user->hasPermission('allAccess')) {

        //Validate user input
        if (input::exists()) {

            // validate whether token exists before performing any action
            if (token::check(input::get('token'))) {

                $inventory = new inventory();

                try {
                    //delete all rows from temp table
                    $inventory->clearTemp();

                    //load and validate new inventory to temp table
                    $file = $_FILES['file']['tmp_name'];

                    $inventory->loadAndValidateInventory($file);

                    //redirect to same page to display results
                    redirect::to('validationResults.php');

                } catch (Exception $e) {
                    //create message to display on user creation
                    ?>
                    <div id="dialogOk" title="Error">
                        <p>&#x26a0; Resources could not be uploaded</p>
                    </div>
                    <?php
                }

            }

        }

        ?>
        <div class="content">
            <div class="container">
                <?php
                    if ($user->hasPermission('newInventory') || $user->hasPermission('allAccess')) {
                        ?>
                        <div class="separator">
                            <h1>Load Inventory From File</h1>
                        </div>
                        <div class="form-style">
                            <form action="" method="post" name="loadTemp" enctype="multipart/form-data">
                                <input type="file" name="file" required="required"/>
                                <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                                <input type="submit" value="LOAD & VALIDATE"/>
                            </form>
                        </div>
                        <?php
                    }

                    if ($user->hasPermission('transferResourceLocation') || $user->hasPermission('allAccess')) {
                        $user = new user();
                        $locationId = escape($user->data()->resource_location_id);

                        ?>
                        <div class="separator">
                            <h1>Inventory Transfer</h1>
                        </div>
                        <div class="form-style">
                            <form action="validateTransfer.php" method="post" name="validateTransfer">
                                <input type="text" name="from" placeholder="Start SN" autocomplete="off" required="required">
                                <input type="text" name="to" placeholder="End SN" autocomplete="off" required="required">
                                <p> <b> Note: </b>Input same value above for single resource transfer.</p>
                                <input type="hidden" name="currentLocationId" value="<?php echo $locationId; ?>">
                                <?php

                                $sql = "SELECT resource_location_name FROM ims.resource_locations rl where rl.resource_location_id = {$locationId}";

                                $get = db::getInstance()->query($sql);

                                if (!$get->count()) {
                                } else {

                                    foreach ($get->results() as $l): ?>
                                        <input type="hidden" name="currentLocation"
                                               value="<?php echo $l->resource_location_name; ?>" disabled>
                                    <?php endforeach;

                                }
                                ?>
                                <select name="location">
                                    <option value="">---------------------- Choose a Location ----------------------</option>
                                    <?php
                                    $sql = "SELECT resource_location_id, resource_location_name FROM ims.resource_locations rl where rl.resource_location_id <> {$locationId} order by 1";

                                    $get = db::getInstance()->query($sql);

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
                                <input type="submit" value="VALIDATE TRANSFER"/>
                            </form>
                        </div>
                        <?php
                        if ($user->hasPermission('transferResourceLocation') || $user->hasPermission('allAccess')) {

                            $inventory = new inventory();

                            //show pending transfers
                            $inventory->showPendingTransfers();

                        }
                    }
                ?>
            </div>
        </div>
        <?php
        $hash = new hash();
        if (isset($_GET[hash::sha256('uploadSuccess' . $hash->getSalt())])) {
            ?>
            <div id="dialogOk" title="Success">
                <p>Resources uploaded.</p>
            </div>
            <?php
        }
        if (isset($_GET[hash::sha256('empty' . $hash->getSalt())])) {
            ?>
            <div id="dialogOk" title="Error">
                <p>&#x26a0; Resource range not found.</p>
            </div>
            <?php
        }
        if (isset($_GET[hash::sha256('allFieldsRequired' . $hash->getSalt())])) {
            ?>
            <div id="dialogOk" title="Error">
                <p>&#x26a0; All fields are required.</p>
            </div>
            <?php
        }
        if (isset($_GET[hash::sha256('notSameModel' . $hash->getSalt())])) {
            ?>
            <div id="dialogOk" title="Error">
                <p>&#x26a0; Resource range must contain only one distinct type of resource.</p>
            </div>
            <?php
        }
        if (isset($_GET[hash::sha256('createTransferRequestSuccess' . $hash->getSalt())])) {
            ?>
            <div id="dialogOk" title="Success">
                <p>Resource transfer was successfully initiated and is pending acceptance.</p>
            </div>
            <?php
        }
    } else {
        redirect::to('main.php');
    }

} else {
    $hash = new hash();
    redirect::to('index.php?' . hash::sha256('nologin' . $hash->getSalt()));
}