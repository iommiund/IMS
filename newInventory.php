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
                <div class="form-style">
                    <h1> Load From File </h1>
                    <form action="" method="post" name="loadTemp" enctype="multipart/form-data">
                        <input type="file" name="file"/>
                        <input type="hidden" name="token" value="<?php echo token::generate(); ?>">
                        <input type="submit" value="LOAD & VALIDATE"/>
                    </form>
                </div>
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
    } else {
        redirect::to('main.php');
    }

} else {
    $hash = new hash();
    redirect::to('index.php?' . hash::sha256('nologin' . $hash->getSalt()));
}