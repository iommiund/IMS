<?php

class order
{

    private $_db,
        $_data;

    public function __construct($user = null)
    {
        $this->_db = db::getInstance();
    }

    public function createInstallOrder($customerId,$resourceTypeId,$uid){

        //Initiate create order, if failed redirect with failure, els redirect with success
        if (!db::getInstance()->query("insert into ims.orders (order_type_id,order_status_id,customer_id,resource_type_id,initiation_timestamp,initiation_uid) values (4,2,{$customerId},{$resourceTypeId},NOW(),{$uid})")) {
            redirect::to('viewCustomerDetails.php?id=' . $customerId . '&orderNotCreated');
            die();
        } else {
            redirect::to('viewCustomerDetails.php?id=' . $customerId . '&orderCreated');
        }

    }

    public function createReplaceOrder($customerId,$resource,$resourceTypeId,$uid){

        //prepare sql query to check whether a replace order
        $sql = "SELECT * FROM ims.orders o WHERE o.customer_id = {$customerId} AND o.old_resource = '$resource' AND o.order_type_id = 5 AND o.order_status_id = 2";

        //get data
        $get = $this->_db->query($sql);

        //if data returned
        if (!$get->count()) {

            //Initiate create replace order, if failed redirect with failure, els redirect with success
            if (!db::getInstance()->query("insert into ims.orders (order_type_id,order_status_id,customer_id,resource_type_id,old_resource,initiation_timestamp,initiation_uid) values (5,2,{$customerId},{$resourceTypeId},'$resource',NOW(),{$uid})")) {
                redirect::to('viewCustomerDetails.php?id=' . $customerId . '&orderNotCreated');
                die();
            } else {
                redirect::to('viewCustomerDetails.php?id=' . $customerId . '&orderCreated');
            }

        } else {
            redirect::to('viewCustomerDetails.php?id=' . $customerId . '&alreadyCreated');
        }

    }

    public function createCollectOrder($customerId,$resource,$resourceTypeId,$uid){

        //prepare sql query to check whether a collect order
        $sql = "SELECT * FROM ims.orders o WHERE o.customer_id = {$customerId} AND o.old_resource = '$resource' AND o.order_type_id = 6 AND o.order_status_id = 2";

        //get data
        $get = $this->_db->query($sql);

        //if data returned
        if (!$get->count()) {

            //Initiate create collect order, if failed redirect with failure, els redirect with success
            if (!db::getInstance()->query("insert into ims.orders (order_type_id,order_status_id,customer_id,resource_type_id,old_resource,initiation_timestamp,initiation_uid) values (6,2,{$customerId},{$resourceTypeId},'$resource',NOW(),{$uid})")) {
                redirect::to('viewCustomerDetails.php?id=' . $customerId . '&orderNotCreated');
                die();
            } else {
                redirect::to('viewCustomerDetails.php?id=' . $customerId . '&orderCreated');
            }

        } else {
            redirect::to('viewCustomerDetails.php?id=' . $customerId . '&alreadyCreated');
        }

    }

    public function getPendingOrders($customerId){

        ?>
        <div class="center-table">
            <table class="ctable">
                <tr>
                    <td colspan="2"><a href="viewCustomerDetails.php?id=<?php echo $customerId; ?>">BACK</a></td>
                </tr>
            </table>
        </div>
        <div class="separator">
            <h2>Pending Orders</h2>
        </div>
        <?php
        $sql = "SELECT 
                    o.order_id,
                    ot.transaction_type,
                    os.transaction_status,
                    rt.resource_type,
                    o.old_resource,
                    DATE_FORMAT(o.initiation_timestamp, '%D %b %Y') as initiation_timestamp,
                    CONCAT(u.name, ' ', u.surname) AS userName
                FROM
                    ims.orders o
                        INNER JOIN
                    ims.transaction_types ot ON o.order_type_id = ot.transaction_type_id
                        INNER JOIN
                    ims.transaction_statuses os ON o.order_status_id = os.transaction_status_id
                        INNER JOIN
                    ims.customer_accounts ac ON o.customer_id = ac.customer_account_id
                        INNER JOIN
                    ims.resource_types rt ON o.resource_type_id = rt.resource_type_id
                        LEFT JOIN
                    ims.resources r ON o.resource_id = r.resource_id
                        INNER JOIN
                    ims.users u ON o.initiation_uid = u.uid
                WHERE
                    o.customer_id = {$customerId}
                AND
                    o.order_status_id = 2
                ORDER BY 1 DESC";

        //get data
        $get = $this->_db->query($sql);

        //if data returned
        if (!$get->count()) {

        } else {
            ?>
            <div class="center-table">
                <table>
                    <tr>
                        <th>Order Id</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Resource Type</th>
                        <th>Old Resource</th>
                        <th>Ordered Date</th>
                        <th>User Name</th>
                        <th>Options</th>
                    </tr>
                    <?php

                    foreach ($get->results() as $o) {

                        $orderId = escape($o->order_id);
                        $transactionType = escape($o->transaction_type);
                        $transactionStatus = escape($o->transaction_status);
                        $resourceType = escape($o->resource_type);
                        $oldResource = escape($o->old_resource);
                        $initiationTimestamp = escape($o->initiation_timestamp);
                        $userName = escape($o->userName);


                        echo '<tr>';
                        echo '<td>' . $orderId . '</td>';
                        echo '<td>' . $transactionType . '</td>';
                        echo '<td>' . $transactionStatus . '</td>';
                        echo '<td>' . $resourceType . '</td>';
                        echo '<td>' . $oldResource . '</td>';
                        echo '<td>' . $initiationTimestamp . '</td>';
                        echo '<td>' . $userName . '</td>';
                        echo '<td><a href="viewOrders.php?orderId=' . $orderId . '&customerId=' . $customerId . '&cancel">Cancel</a></td>';
                        echo '</tr>';

                    }

                    ?>
                </table>
            </div>
            <?php

        }

    }

    public function showAllPendingOrders(){

        ?>
        <div class="separator">
            <h2>Pending orders</h2>
        </div>
        <?php
        $sql = "SELECT 
                    o.order_id,
                    ot.transaction_type,
                    os.transaction_status,
                    rt.resource_type,
                    r.resource_unique_value,
                    o.initiation_timestamp,
                    CONCAT(u.name, ' ', u.surname) AS userName,
                    o.closing_timestamp
                FROM
                    ims.orders o
                        INNER JOIN
                    ims.transaction_types ot ON o.order_type_id = ot.transaction_type_id
                        INNER JOIN
                    ims.transaction_statuses os ON o.order_status_id = os.transaction_status_id
                        INNER JOIN
                    ims.customer_accounts ac ON o.customer_id = ac.customer_account_id
                        INNER JOIN
                    ims.resource_types rt ON o.resource_type_id = rt.resource_type_id
                        LEFT JOIN
                    ims.resources r ON o.resource_id = r.resource_id
                        INNER JOIN
                    ims.users u ON o.initiation_uid = u.uid
                WHERE
                    o.order_status_id = 2
                ORDER BY 1 DESC";

        //get data
        $get = $this->_db->query($sql);

        //if data returned
        if (!$get->count()) {

        } else {
            ?>
            <div class="center-table">
                <table>
                    <tr>
                        <th>Order Id</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Resource Type</th>
                        <th>Installed Resource</th>
                        <th>Ordered Date</th>
                        <th>User Name</th>
                        <th>Completion Date</th>
                    </tr>
                    <?php

                    foreach ($get->results() as $o) {

                        $orderId = escape($o->order_id);
                        $transactionType = escape($o->transaction_type);
                        $transactionStatus = escape($o->transaction_status);
                        $resourceType = escape($o->resource_type);
                        $resourceUniqueValue = escape($o->resource_unique_value);
                        $initiationTimestamp = escape($o->initiation_timestamp);
                        $userName = escape($o->userName);
                        $closingTimestamp = escape($o->closing_timestamp);


                        echo '<tr>';
                        echo '<td>' . $orderId . '</td>';
                        echo '<td>' . $transactionType . '</td>';
                        echo '<td>' . $transactionStatus . '</td>';
                        echo '<td>' . $resourceType . '</td>';
                        echo '<td>' . $resourceUniqueValue . '</td>';
                        echo '<td>' . $initiationTimestamp . '</td>';
                        echo '<td>' . $userName . '</td>';
                        echo '<td>' . $closingTimestamp . '</td>';
                        echo '</tr>';

                    }

                    ?>
                </table>
            </div>
            <?php

        }

    }

    public function getAllOrders($customerId){
        ?>
        <div class="separator">
            <h2>Full Order History</h2>
        </div>
        <?php
        $sql = "SELECT 
                    o.order_id,
                    ot.transaction_type,
                    os.transaction_status,
                    rt.resource_type,
                    o.old_resource,
                    r.resource_unique_value,
                    DATE_FORMAT(o.initiation_timestamp, '%D %b %Y') as initiation_timestamp,
                    CONCAT(u.name, ' ', u.surname) AS userName,
                    o.closing_timestamp
                FROM
                    ims.orders o
                        INNER JOIN
                    ims.transaction_types ot ON o.order_type_id = ot.transaction_type_id
                        INNER JOIN
                    ims.transaction_statuses os ON o.order_status_id = os.transaction_status_id
                        INNER JOIN
                    ims.customer_accounts ac ON o.customer_id = ac.customer_account_id
                        INNER JOIN
                    ims.resource_types rt ON o.resource_type_id = rt.resource_type_id
                        LEFT JOIN
                    ims.resources r ON o.resource_id = r.resource_id
                        INNER JOIN
                    ims.users u ON o.initiation_uid = u.uid
                WHERE
                    o.customer_id = {$customerId}
                ORDER BY 1 DESC";

        //get data
        $get = $this->_db->query($sql);

        //if data returned
        if (!$get->count()) {

        } else {
            ?>
            <div class="center-table">
                <table>
                    <tr>
                        <th>Order Id</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Resource Type</th>
                        <th>Old Resource</th>
                        <th>New Resource</th>
                        <th>Ordered Date</th>
                        <th>User Name</th>
                        <th>Completion Date</th>
                    </tr>
                    <?php

                    foreach ($get->results() as $o) {

                        $orderId = escape($o->order_id);
                        $transactionType = escape($o->transaction_type);
                        $transactionStatus = escape($o->transaction_status);
                        $resourceType = escape($o->resource_type);
                        $oldResource = escape($o->old_resource);
                        $resourceUniqueValue = escape($o->resource_unique_value);
                        $initiationTimestamp = escape($o->initiation_timestamp);
                        $userName = escape($o->userName);
                        $closingTimestamp = escape($o->closing_timestamp);


                        echo '<tr>';
                        echo '<td>' . $orderId . '</td>';
                        echo '<td>' . $transactionType . '</td>';
                        echo '<td>' . $transactionStatus . '</td>';
                        echo '<td>' . $resourceType . '</td>';
                        echo '<td>' . $oldResource . '</td>';
                        echo '<td>' . $resourceUniqueValue . '</td>';
                        echo '<td>' . $initiationTimestamp . '</td>';
                        echo '<td>' . $userName . '</td>';
                        echo '<td>' . $closingTimestamp . '</td>';
                        echo '</tr>';

                    }

                    ?>
                </table>
            </div>
            <?php

        }

    }

    public function getAllPendingOrders(){

    $sql = "SELECT 
                o.order_id,
                ca.customer_account_id,
                CONCAT(ca.customer_name,
                        ' ',
                        ca.customer_surname) AS customerName,
                CONCAT(s.street_name, ', ', t.town_name) AS address,
                tt.transaction_type,
                o.old_resource,
                rt.resource_type,
                o.initiation_timestamp,
                u.username
            FROM
                ims.orders o
                    INNER JOIN
                ims.transaction_types tt ON o.order_type_id = tt.transaction_type_id
                    INNER JOIN
                ims.customer_accounts ca ON o.customer_id = ca.customer_account_id
                    INNER JOIN
                ims.streets s ON ca.street_id = s.street_id
                    INNER JOIN
                ims.towns t ON ca.town_id = t.town_id
                    INNER JOIN
                ims.resource_types rt ON o.resource_type_id = rt.resource_type_id
                    INNER JOIN
                ims.users u ON o.initiation_uid = u.uid
            WHERE
                o.order_status_id = 2
            ORDER BY 1";

        //get data
        $get = $this->_db->query($sql);

        //if data returned
        if (!$get->count()) {

        } else {

            //set initial old resource value to null
            $oldResource = null;

            ?>
            <div class="separator">
                <h2>All Pending Orders</h2>
            </div>
            <div class="center-table">
                <table>
                    <tr>
                        <th>Order Id</th>
                        <th>Action</th>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>Resource Type</th>
                        <th>Old Resource</th>
                        <th>Pending Since</th>
                        <th>Creator</th>
                    </tr>
            <?php
            foreach ($get->results() as $o) {
                $orderId = escape($o->order_id);
                $customerId = escape($o->customer_account_id);
                $customerName = escape($o->customerName);
                $address = escape($o->address);
                $action = escape($o->transaction_type);
                $resourceType = escape($o->resource_type);
                if (isset($o->old_resource)){
                $oldResource = escape($o->old_resource);
                }
                $timestamp = escape($o->initiation_timestamp);
                $username = escape($o->username);

                echo '<tr>';
                echo '<td>' . $orderId . '</td>';
                echo '<td>' . $action . '</td>';
                echo '<td><a href="viewCustomerDetails.php?id=' . $customerId . '">' . $customerName . '</a></td>';
                echo '<td>' . $address . '</td>';
                echo '<td>' . $resourceType . '</td>';
                echo '<td>' . $oldResource . '</td>';
                echo '<td>' . $timestamp . '</td>';
                echo '<td>' . $username . '</td>';
                echo '</tr>';

            }
            ?>
                </table>
            </div>
            <?php

        }

    }

}