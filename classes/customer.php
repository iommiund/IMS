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
                    $hash = new hash();
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

}