<?php
require_once 'core/init.php';
include_once ("header.php");

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('viewCustomer') || $user->hasPermission('allAccess')){
        if(isset($_GET['id'])){
            $customerId = escape($_GET['id']);

            $customer = new customer();
        } else {
            redirect::to('main.php');
        }
        ?>
        <div class="content">
            <div class="container">
                <?php
                try {

                    //get customer details
                    $customer->getCustomerDetails($customerId);

                    //get list of inventory installed at customer premises
                    $customer ->getInventoryCPE($customerId);

                } catch (Exception $e) {
                    $hash = new hash();
                    redirect::to('main.php?' . hash::sha256('couldNotFindCustomer' . $hash->getSalt()));
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
        if (isset($_GET['noStatusReturned'])) {
            ?>
            <div id="dialogOk" title="Error">
                <p>Could not get data for customer.</p>
            </div>
            <?php
        }
        if (isset($_GET['notUpdated'])) {
            ?>
            <div id="dialogOk" title="Error">
                <p>Customer status not updated.</p>
            </div>
            <?php
        }
        if (isset($_GET['updated'])) {
            ?>
            <div id="dialogOk" title="Success">
                <p>Customer status updated.</p>
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