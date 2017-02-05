<?php
require_once 'core/init.php';
//include_once("header.php");

$user = new user();

if ($user->isLoggedIn()) {

    //check if user has permission
    if ($user->hasPermission('newInventory') || $user->hasPermission('allAccess')) {

        //Check if upload
        $hash = new hash();
        if (isset($_GET[upload])) {

            try {
                $inventory = new inventory();

                //Insert all valid records in resources table and add transaction
                $inventory->uploadResource();

                //create message to display on user creation
                ?>
                <div id="dialogOk" title="Error">
                    <p>
                        <?php
                        echo 'Resources Uploaded';
                        ?>
                    </p>
                </div>
                <?php

            } catch (Exception $e) {
                //create message to display on user creation
                ?>
                <div id="dialogOk" title="Error">
                    <p>
                        <?php
                        echo '&#x26a0; Resources could not be uploaded';
                        ?>
                    </p>
                </div>
                <?php
            }

        }

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
                    $hash = new hash();
                    redirect::to('newInventory.php?' . hash::sha256('results' . $hash->getSalt()));

                } catch (Exception $e) {
                    //create message to display on user creation
                    ?>
                    <div id="dialogOk" title="Error">
                        <p>
                            <?php
                            echo '&#x26a0; Please remove all <b>duplicate records</b> from file and try again.';
                            ?>
                        </p>
                    </div>
                    <?php
                }

            }

        }

        ?>
        <div class="content">
        <div class="container">
        <div class="form-style">
            <h1> Load From File </h1>
            <form action="" method="post" name="loadTemp" enctype="multipart/form-data">
                <input type="file" name="file"/>
                <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                <input type="submit" value="LOAD & VALIDATE"/>
            </form>
        </div>
        <?php
        $hash = new hash();
        if (isset($_GET[hash::sha256('results' . $hash->getSalt())])) {
            ?>
            <div class="form-style">
                <form action="" method="get">
                    <input type="hidden" name="upload" value="upload">
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
        }
    } else {
        redirect::to('main.php');
    }

} else {
    $hash = new hash();
    redirect::to('index.php?' . hash::sha256('nologin' . $hash->getSalt()));
}