<?php
require_once 'core/init.php';
include_once ("header.php");

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('viewResource') || $user->hasPermission('allAccess')){
        if(isset($_GET['id'])){
            $resourceId = escape($_GET['id']);

            $inventory = new inventory();
        }
        ?>
        <div class="content">
            <div class="container">
                    <?php
                    try {

                        //get inventory details
                        $inventory->getInventoryDetails($resourceId);

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
    } else {
        redirect::to('main.php');
    }

} else {
    $hash = new hash();
    redirect::to('index.php?' . hash::sha256('nologin' . $hash->getSalt()));
}