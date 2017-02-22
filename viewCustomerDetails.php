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
                    $customer->getInventoryCPE($customerId);

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
        if (isset($_GET['accessDenied'])) {
            ?>
            <div id="dialogOk" title="Error">
                <p>Access is denied</p>
            </div>
            <?php
        }
        if (isset($_GET['orderCreated'])) {
            ?>
            <div id="dialogOk" title="Success">
                <p>Order successfully created.</p>
            </div>
            <?php
        }
        if (isset($_GET['orderNotCreated'])) {
            ?>
            <div id="dialogOk" title="Error">
                <p>Failed to create order.</p>
            </div>
            <?php
        }
        if (isset($_GET['installResource'])) {

            $customerId = escape($_GET['id']);

            if ($user->hasPermission('orderInstallResource') || $user->hasPermission('allAccess')){

                echo '<div class="form-style" id="form-dialog" title="Select type of resource">';
                echo '<form action="installResource.php" method="post" name="installResource">';
                echo '  <input type="hidden" name="customerId" value="' . $customerId . '">';
                echo '  <select name="Type" required="required">';
                echo '      <option value="">----------------------- Choose a Type -----------------------</option>';

                $get = db::getInstance()->query("SELECT 
                                                    rt.resource_type_id, rt.resource_type
                                                FROM
                                                    ims.resource_types rt
                                                        INNER JOIN
                                                    ims.resource_models rm ON rt.resource_type_id = rm.resource_type_id
                                                WHERE
                                                    rm.install = 1
                                                GROUP BY 1");

                if (!$get->count()) {
                    echo 'Empty List';
                } else {

                    foreach ($get->results() as $t): ?>
                        <option value="<?php echo escape($t->resource_type_id); ?>">
                            <?php echo escape($t->resource_type); ?>
                        </option>
                    <?php endforeach;

                }

                echo '  </select>';
                echo '<input type="submit" value="CREATE ORDER"/>';
                echo '</form>';
                echo '</div>';

            } else {
                redirect::to('viewCustomerDetails.php?id=' . $customerId . '&accessDenied');
            }

        }
    } else {
        redirect::to('main.php');
    }

} else {
    $hash = new hash();
    redirect::to('index.php?' . hash::sha256('nologin' . $hash->getSalt()));
}