<?php
require_once 'core/init.php';
include_once ("header.php");

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('viewResource') || $user->hasPermission('allAccess')){
        if(isset($_GET['id'])){
            $resourceId = escape($_GET['id']);

            $inventory = new inventory();
        } else {
            redirect::to('main.php');
        }
        ?>
        <div class="content">
            <div class="container">
                    <?php
                    try {

                        //get inventory details
                        $inventory->getInventoryDetails($resourceId);

                        //show options
                        $inventory->getInventoryOptions($resourceId);

                    } catch (Exception $e) {
                        $hash = new hash();
                        redirect::to('main.php?' . hash::sha256('couldNotFindInventory' . $hash->getSalt()));
                    }
                    if ($user->hasPermission('viewResourceHistory') || $user->hasPermission('allAccess')){

                        try {

                            //get resource history
                            $inventory->getResourceHistory($resourceId);

                        } catch (Exception $e) {
                            $hash = new hash();
                            redirect::to('main.php?' . hash::sha256('couldNotFindInventory' . $hash->getSalt()));
                        }

                    }
                    ?>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('table tr:nth-child(odd)').addClass('alt');
                    });
                </script>
            </div>
        </div>
        <?php
        if (isset($_GET['cannotBeSold'])) {
            ?>
            <div id="dialogOk" title="Error">
                <p>Resource cannot be sold.</p>
            </div>
            <?php
        }
        if (isset($_GET['cannotBeSoldMainOrField'])) {
            ?>
            <div id="dialogOk" title="Error">
                <p>Resource location cannot sell resources.</p>
            </div>
            <?php
        }
        if (isset($_GET['resourceNotUpdated'])) {
            ?>
            <div id="dialogOk" title="Error">
                <p>Resource cannot be updated.</p>
            </div>
            <?php
        }
        if (isset($_GET['transferNotUpdated'])) {
            ?>
            <div id="dialogOk" title="Error">
                <p>Transfer cannot be updated.</p>
            </div>
            <?php
        }
        if (isset($_GET['resourceSold'])) {
            ?>
            <div id="dialogOk" title="Success">
                <p>Resource successfully sold.</p>
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