<?php
require_once 'core/init.php';
include_once("header.php");

//$user = new user();

if ($user->isLoggedIn()) {

    //check if user has permission
    if ($user->hasPermission('newInventory') || $user->hasPermission('allAccess')) {

        //Validate user input
        if (input::exists()) {

            // validate whether token exists before performing any action
            if (token::check(input::get('token'))) {

                $inventory = new inventory();

                try {

                    //Insert all valid records in resources table and add transaction
                    $inventory->uploadResource();

                    //clear temp resources
                    $inventory->clearTemp();

                    // redirect back to inventory.php and display message
                    $hash = new hash();
                    redirect::to('inventory.php?' . hash::sha256('uploadSuccess' . $hash->getSalt()));

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
                <div class="center-table">
                <?php

                $get = db::getInstance()->query("select * from ims.temp_resource where vr_id = 1");

                if (!$get->count()) {

                } else {
                ?>
                <div class="form-style">
                    <form action="" method="post">
                        <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                        <input type="submit" value="UPLOAD VALID RESOURCES">
                    </form>
                </div>
                    <table>
                        <tr>
                            <th>Resource</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Result</th>
                        </tr>
                        <?php
                        $inventory = new inventory();
                        $inventory->getValidationResults('=', '1');
                        ?>
                    </table>
                    <?php
                    }

                    $get = db::getInstance()->query("select * from ims.temp_resource where vr_id <> 1");

                    if (!$get->count()) {

                    } else {
                        ?>
                        <div class="separator">
                            <h2>Inventory listed below cannot be uploaded due to validation failure</h2>
                        </div>
                        <table>
                            <tr>
                                <th>Resource</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Result</th>
                            </tr>
                            <?php
                            $inventory = new inventory();
                            $inventory->getValidationResults('<>', '1');
                            ?>
                        </table>
                        <?php
                    }

                    ?>

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