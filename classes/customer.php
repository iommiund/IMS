<?php

/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 28/01/2017
 * Time: 16:48
 */
class customer
{
    private $_db,
        $_data;

    public function __construct($user = null){
        $this->_db = db::getInstance();
    }

    public function createCustomer($fields = array()){
        if (!$this->_db->insert('customer_accounts', $fields)){
            throw new Exception('There was a problem creating entry');
        }
    }

    public function data(){
        return $this->_data;
    }

    public function searchCustomer($field){

        $sql = "SELECT 
                    ca.customer_account_id,
                    ca.customer_name,
                    ca.customer_surname,
                    ca.customer_email,
                    n.nationality,
                    cas.customer_account_status
                FROM
                    ims.customer_accounts ca
                        INNER JOIN
                    ims.nationalities n ON ca.nationality_id = n.nationality_id
                        INNER JOIN
                    ims.customer_account_statuses cas ON ca.customer_account_status_id = cas.customer_account_status_id
                WHERE
                    ca.customer_account_id LIKE '%$field%'
                        OR ca.customer_name LIKE '%$field%'
                        OR ca.customer_surname LIKE '%$field%'
                        OR ca.customer_email LIKE '%$field%'
                ORDER BY 2 , 3";

        $get = $this->_db->query($sql);

        if (!$get->count()) {

        } else {
            ?>
            <div class="separator">
                <h2>Customers</h2>
            </div>
            <div class="center-table">
                <table>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Nationality</th>
                        <th>Account Status</th>
                        <th>Options</th>
                    </tr>
                    <?php
                    foreach ($get->results() as $r) {

                        //Set variables from result set
                        $customerId = escape($r->customer_account_id);
                        $customerName = escape($r->customer_name);
                        $customerSurname = escape($r->customer_surname);
                        $email = escape($r->customer_email);
                        $nationality = escape($r->nationality);
                        $status = escape($r->customer_account_status);

                        echo '<tr>';
                        echo '<td>' . $customerName . ' ' . $customerSurname . '</td>';
                        echo '<td>' . $email . '</td>';
                        echo '<td>' . $nationality . '</td>';
                        echo '<td>' . $status . '</td>';
                        echo '<td><a href="viewCustomerDetails.php?id=' . $customerId . '">View</a></td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
            <hr>
            <?php
        }
    }

    public function getCustomerDetails($customerId){

        //prepare sql query to ger customer details
        $sql = "SELECT 
                    CONCAT(ca.customer_name,
                            ' ',
                            ca.customer_surname) AS fullName,
                    ca.customer_email,
                    ca.customer_dob,
                    n.nationality,
                    ca.customer_account_status_id,
                    cas.customer_account_status
                FROM
                    ims.customer_accounts ca
                        INNER JOIN
                    ims.nationalities n ON ca.nationality_id = n.nationality_id
                        INNER JOIN
                    ims.customer_account_statuses cas ON ca.customer_account_status_id = cas.customer_account_status_id
                WHERE
                    ca.customer_account_id = {$customerId}";

        //execute sql query
        $get = $this->_db->query($sql);

        //if no error returned display details
        if (!$get->count()) {
            echo 'could not get data';
        } else {

            foreach ($get->results() as $c) {

                //set variables for result set
                $fullName = escape($c->fullName);
                $email = escape($c->customer_email);
                $dob = escape($c->customer_dob);
                $nationality = escape($c->nationality);
                $customerStatusId = escape($c->customer_account_status_id);
                $customerStatus = escape($c->customer_account_status);

            }
            ?>
            <div class="separator">
                <h1>Customer Details</h1>
            </div>
            <table class="ctable">
                <tr>
                    <td><b>Customer Name: </b></td>
                    <td><?php echo $fullName; ?></td>
                </tr>
                <tr>
                    <td><b>Email: </b></td>
                    <td><?php echo $email; ?></td>
                </tr>
                <tr>
                    <td><b>Date Of Birth: </b></td>
                    <td><?php echo $dob; ?></td>
                </tr>
                <tr>
                    <td><b>Nationality: </b></td>
                    <td><?php echo $nationality; ?></td>
                </tr>
                <tr>
                    <td><b>Customer Status: </b></td>
                    <td><?php echo $customerStatus; ?></td>
                </tr>
                <?php
                if ($customerStatusId == 2){
                ?>
                <tr>
                    <td colspan="2"><a href="changeCustomerStatus.php?id=<?php echo $customerId; ?>&statusId=1">Enable</a></td>
                </tr>
                <?php
                }
                if ($customerStatusId == 1){
                    ?>
                    <tr>
                        <td colspan="2"><a href="changeCustomerStatus.php?id=<?php echo $customerId; ?>&statusId=2">Disable</a></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php

        }
    }

    public function changeCustomerStatus($customerId,$statusId) {

        //check whether customer is already disabled/enabled
        $sql = "select customer_account_status_id from ims.customer_accounts where customer_account_id = {$customerId}";

        //execute sql query
        $get = $this->_db->query($sql);

        //if no error returned display details
        if (!$get->count()) {
            redirect::to('viewCustomerDetails.php?id=' . $customerId . '&noStatusReturned');
        } else {

            foreach ($get->results() as $s) {

                //set variables for result set
                $currentStatus = escape($s->customer_account_status_id);

            }

            //if the current status = requested status redirect with error
            if ($statusId == $currentStatus){
                redirect::to('viewCustomerDetails.php?id=' . $customerId . '&notUpdated');

            } elseif ($statusId == 1){

                //if new status = enabled enable customer account
                db::getInstance()->query("update ims.customer_accounts set customer_account_status_id = 1 where customer_account_id = {$customerId} and customer_account_status_id = 2");

                //redirect with success message
                redirect::to('viewCustomerDetails.php?id=' . $customerId . '&updated');

            } elseif ($statusId == 2){

                //if new status = disabled disable customer account
                db::getInstance()->query("update ims.customer_accounts set customer_account_status_id = 2 where customer_account_id = {$customerId} and customer_account_status_id = 1");

                //check whether customer has any inventory and create order to collect inventory from customer


                //redirect with success message
                redirect::to('viewCustomerDetails.php?id=' . $customerId . '&updated');
            }

        }

    }

    public function getInventoryCPE($customerId) {



    }

}