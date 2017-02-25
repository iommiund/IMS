<?php
require_once 'core/init.php';
include_once ("header.php");

if ($user->isLoggedIn()){

    //check if user has permission
    if ($user->hasPermission('viewOrders') || $user->hasPermission('allAccess')){
        ?>
        <div class="content">
            <div class="container">
                <div class="separator">
                    <h1>Customer Order History</h1>
                </div>
                <?php
                if(isset($_GET['id'])){

                    $customerId = escape($_GET['id']);

                    $order = new order();

                    $order->getPendingOrders($customerId);

                    $order->getAllOrders($customerId);

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
        if (isset($_GET['accessDenied'])) {
            ?>
            <div id="dialogOk" title="Error">
                <p>Access is denied</p>
            </div>
            <?php
        }
        if (isset($_GET['notCancelled'])) {
            ?>
            <div id="dialogOk" title="Error">
                <p>Failed to cancel order</p>
            </div>
            <?php
        }
        if (isset($_GET['cancelled'])) {
            ?>
            <div id="dialogOk" title="Success">
                <p>Order Cancelled</p>
            </div>
            <?php
        }
        if(isset($_GET['cancel'])){

            $orderId = escape($_GET['orderId']);
            $customerId = escape($_GET['customerId']);

            if ($user->hasPermission('cancelOrder') || $user->hasPermission('allAccess')){

                $inventory = new inventory();
                $uid = $user->data()->uid;

                $inventory->cancelOrder($orderId,$uid,$customerId);

            } else {

                redirect::to('viewOrders.php?id=' . $customerId . '&accessDenied');

            }

        }
    } else {
        redirect::to('main.php');
    }

} else {
    $hash = new hash();
    redirect::to('index.php?' . hash::sha256('nologin' . $hash->getSalt()));
}