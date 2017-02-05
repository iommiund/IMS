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

                    // redirect back to newInventory.php and display message
                    $hash = new hash();
                    redirect::to('newInventory.php?' . hash::sha256('uploadSuccess' . $hash->getSalt()));

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
                <div class="form-style">
                    <form action="" method="post">
                        <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                        <input type="submit" value="UPLOAD VALID RESOURCES">
                    </form>
                </div>
                <div class="center-table">
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
                    <hr>
                    <p align="center">Resources listed below cannot be uploaded due to validation failure.</p>
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