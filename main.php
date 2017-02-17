<?php
require_once 'core/init.php';
include_once ("header.php");

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('access') || $user->hasPermission('allAccess')){
        ?>
        <div class="content">
            <div class="container">
                <?php
                if ($user->hasPermission('stockLevels') || $user->hasPermission('allAccess')) {
                    ?>
                    <div class="separator">
                        <h2>Stock levels for your location</h2>
                    </div>
                    <?php
                    //declare initial variables
                    $userLocation = escape($user->data()->resource_location_id);

                    $inventory = new inventory();

                    //show stock levels at location
                    $inventory->stockLevels($userLocation);

                }
                if ($user->hasPermission('viewPendingTransfers') || $user->hasPermission('allAccess')) {

                    $inventory = new inventory();

                    //show pending transfers
                    $inventory->showPendingTransfers();

                }
                if ($user->hasPermission('viewAllPendingTransfers') || $user->hasPermission('allAccess')) {

                $inventory = new inventory();

                //show pending transfers
                $inventory->showAllPendingTransfers();

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
        $hash = new hash();
        if (isset($_GET[hash::sha256('couldNotAcceptTransfer' . $hash->getSalt())])) {
            ?>
            <div id="dialogOk" title="Error">
                <p>&#x26a0; Could not accept transfer</p>
            </div>
            <?php
        }
        if (isset($_GET[hash::sha256('couldNotRejectTransfer' . $hash->getSalt())])) {
            ?>
            <div id="dialogOk" title="Error">
                <p>&#x26a0; Could not reject transfer</p>
            </div>
            <?php
        }
        if (isset($_GET[hash::sha256('transferAccepted' . $hash->getSalt())])) {
            ?>
            <div id="dialogOk" title="Success">
                <p>Resources have successfully been transferred to your location.</p>
            </div>
            <?php
        }
        if (isset($_GET[hash::sha256('transferRejected' . $hash->getSalt())])) {
            ?>
            <div id="dialogOk" title="Success">
                <p>Transfer rejected</p>
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