<?php

/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 28/01/2017
 * Time: 16:48
 */
class inventory
{
    private $_db,
        $_data;

    public function __construct($user = null)
    {
        $this->_db = db::getInstance();
    }

    public function clearTemp()
    {

        $sql = "delete from ims.temp_resource";

        if (!$this->_db->query($sql)) {
            throw new Exception('There was a problem deleting records');
        };

    }

    public function createInventory($fields = array())
    {
        if (!$this->_db->insert('resources', $fields)) {
            throw new Exception('There was a problem creating entry');
        }
    }

    public function loadAndValidateInventory($file)
    {

        //set handle
        $handle = fopen($file, "r");

        //for each row
        while (($fileop = fgetcsv($handle, 1000, ",")) !== false) {

            //set initial variable values
            $voucherValue = NULL;
            $vrID = 1;
            $reqSNLength = NULL;
            $resourceUniqueValue = escape($fileop[0]);
            $modelIdentifier = escape(substr($resourceUniqueValue, 0, 6));
            $resourceLength = escape(strlen($resourceUniqueValue));

            //get resource brand, model, type and resource_sn_length for resource validation
            $sql = "SELECT 
                        rb.resource_brand_id,
                        rm.resource_model_id,
                        rt.resource_type_id,
                        rmi.resource_sn_length,
                        rmi.voucher_value_id
                    FROM
                        ims.resouce_model_identifiers rmi
                            INNER JOIN
                        ims.resource_models rm ON rmi.resource_model_id = rm.resource_model_id
                            INNER JOIN
                        ims.resource_brands rb ON rm.resource_brand_id = rb.resource_brand_id
                            INNER JOIN
                        ims.resource_types rt ON rm.resource_type_id = rt.resource_type_id
                    WHERE
                        rmi.resource_model_identifier = \"$modelIdentifier\"";

            //Run query
            $get = $this->_db->query($sql);

            //If no results are returned
            if (!$get->count()) {

                //resource model identifier does not match
                $vrID = 3;

                //create fields array to insert values in temp table
                $fields = array(
                    'resource_unique_value' => $resourceUniqueValue,
                    'resource_model_identifier' => $modelIdentifier,
                    'current_sn_length' => $resourceLength,
                    'vr_id' => $vrID
                );

                //insert records in temp table
                if (!$this->_db->insert('temp_resource', $fields)) {
                    throw new Exception('Your file contains duplicate records.');
                }

            } else {

                //If results are returned
                foreach ($get->results() as $r) {

                    //Set variables for brand, model, type and resource_sn_length from previous query
                    if (isset($r->resource_brand_id, $r->resource_model_id, $r->resource_type_id, $r->resource_sn_length)) {
                        $resourceBrandId = escape($r->resource_brand_id);
                        $resourceModelId = escape($r->resource_model_id);
                        $resourceTypeId = escape($r->resource_type_id);
                        $reqSNLength = escape($r->resource_sn_length);
                        if (isset($r->voucher_value_id)) {
                            $voucherValue = escape($r->voucher_value_id);
                        }
                    }

                    //Check if resource already exists
                    $sql = "select * from ims.resources r where r.resource_unique_value = \"$resourceUniqueValue\"";

                    //Run query
                    $get = $this->_db->query($sql);

                    if (!$get->count()) {

                        //If the resource does not exist, set flag to O
                        $existsFlag = 0;

                    } else {

                        //If the resource exists, set flag to 1
                        $existsFlag = 1;

                        //And set validation result to resource exists
                        $vrID = 2;
                    }

                    //If serial number length does not match
                    if ($resourceLength !== $reqSNLength) {

                        //Ser validation result to serial number length is incorrect
                        $vrID = 4;
                    }

                    //create fields array to insert values in temp table
                    $fields = array(
                        'resource_unique_value' => $resourceUniqueValue,
                        'resource_brand_id' => $resourceBrandId,
                        'resource_model_id' => $resourceModelId,
                        'resource_type_id' => $resourceTypeId,
                        'resource_model_identifier' => $modelIdentifier,
                        'current_sn_length' => $resourceLength,
                        'req_sn_length' => $reqSNLength,
                        'voucher_value_id' => $voucherValue,
                        'exists_flag' => $existsFlag,
                        'vr_id' => $vrID
                    );

                    //insert all records in temp table
                    if (!$this->_db->insert('temp_resource', $fields)) {
                        throw new Exception('Your file contains duplicate records.');
                    }

                }

            }

        }

    }

    public function getValidationResults($operator, $value)
    {
        //Prepare sql query
        $sql = "SELECT 
                    tr.resource_unique_value,
                    rb.resource_brand,
                    rm.resource_model,
                    rt.resource_type,
                    vv.voucher_value,
                    vr.description
                FROM
                    ims.temp_resource tr
                        LEFT JOIN
                    ims.resource_models rm ON tr.resource_model_id = rm.resource_model_id
                        LEFT JOIN
                    ims.resource_brands rb ON rm.resource_brand_id = rb.resource_brand_id
                        LEFT JOIN
                    ims.resource_types rt ON rm.resource_type_id = rt.resource_type_id
                        LEFT JOIN
                    ims.validation_results vr ON tr.vr_id = vr.vr_id
                        LEFT JOIN
                    ims.voucher_values vv ON tr.voucher_value_id = vv.voucher_value_id
                WHERE
                    tr.vr_id {$operator} {$value}";

        //Run query
        $get = $this->_db->query($sql);

        //If no results returned
        if (!$get->count()) {

        } else {

            foreach ($get->results() as $r) {

                //Set initial variable value to empty
                $resourceUniqueValue = NULL;
                $resourceBrand = NULL;
                $resourceModel = NULL;
                $resourceType = NULL;
                $voucherValue = NULL;
                $validationResult = NULL;

                //Set variables for brand, model, type and resource_sn_length from previous query
                if (isset($r->resource_unique_value)) {
                    $resourceUniqueValue = escape($r->resource_unique_value);
                    if (isset($r->resource_brand)) {
                        $resourceBrand = escape($r->resource_brand);
                    }
                    if (isset($r->resource_model)) {
                        $resourceModel = escape($r->resource_model);
                    }
                    if (isset($r->resource_type)) {
                        $resourceType = escape($r->resource_type);
                    }
                    if (isset($r->voucher_value)) {
                        $voucherValue = escape($r->voucher_value);
                    }
                    $validationResult = escape($r->description);
                }

                echo '<tr>';
                echo '<td>' . $resourceUniqueValue . '</td>';
                echo '<td>' . $resourceBrand . '</td>';
                echo '<td>' . $resourceModel . '</td>';
                echo '<td>' . $resourceType . '</td>';
                echo '<td>' . $voucherValue . '</td>';
                echo '<td>' . $validationResult . '</td>';
                echo '</tr>';
            }

        }

    }

    public function uploadResource()
    {
        //set initial variable values
        $voucherValueId = NULL;

        //Get all records from temp_resource with vr_id = 1
        $sql = "SELECT 
                    tr.resource_unique_value,
                    tr.resource_model_id,
                    tr.resource_type_id,
                    tr.voucher_value_id
                FROM
                    ims.temp_resource tr
                WHERE
                    tr.vr_id = 1";

        $get = $this->_db->query($sql);

        if (!$get->count()) {
            echo 'Nothing to upload';
        } else {

            //for each record
            foreach ($get->results() as $r) {

                $user = new user();

                //declare variables
                $uid = escape($user->data()->uid);
                $resourceUniqueValue = escape($r->resource_unique_value);
                $resourceModelId = escape($r->resource_model_id);
                $resourceTypeId = escape($r->resource_type_id);
                if (isset($r->voucher_value_id)) {
                    $voucherValueId = escape($r->voucher_value_id);
                }

                //create fields array to insert values in temp table
                $fields = array(
                    'resource_unique_value' => $resourceUniqueValue,
                    'resource_model_id' => $resourceModelId,
                    'resource_type_id' => $resourceTypeId,
                    'voucher_value_id' => $voucherValueId,
                    'resource_status_id' => 1, //Available
                    'resource_location_id' => 1, //Main Warehouse
                    'last_update_user' => $uid,
                );

                //insert resources
                if (!$this->_db->insert('resources', $fields)) {
                    throw new Exception('There was a problem creating entry');
                }
            }

        }

    }

    public function searchResource($field)
    {

        $sql = "select
                    r.resource_id,
                    r.resource_unique_value,
                    rb.resource_brand,
                    rm.resource_model,
                    rt.resource_type,
                    vv.voucher_value,
                    rs.resource_status,
                    rl.resource_location_name,
                    ca.customer_account_id
                FROM
                    ims.resources r
                        LEFT JOIN
                    ims.resource_models rm ON r.resource_model_id = rm.resource_model_id
                        INNER JOIN
                    ims.resource_brands rb ON rm.resource_brand_id = rb.resource_brand_id
                        LEFT JOIN
                    ims.resource_types rt ON r.resource_type_id = rt.resource_type_id
                        LEFT JOIN
                    ims.voucher_values vv ON r.voucher_value_id = vv.voucher_value_id
                        LEFT JOIN
                    ims.resource_statuses rs ON r.resource_status_id = rs.resource_status_id
                        LEFT JOIN
                    ims.resource_locations rl ON r.resource_location_id = rl.resource_location_id
                        LEFT JOIN
                    ims.customer_accounts ca ON r.customer_account_id = ca.customer_account_id  
                where r.resource_unique_value like '%$field%'
                order by 6,7,1";

        $get = $this->_db->query($sql);

        if (!$get->count()) {

        } else {
            ?>
            <div class="separator">
                <h2>Inventory</h2>
            </div>
            <div class="center-table">
                <table>
                    <tr>
                        <th>Resource</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>Customer ID</th>
                        <th>Options</th>
                    </tr>
                    <?php

                    foreach ($get->results() as $r) {

                        //Set initial variable value to empty
                        $voucherValue = NULL;
                        $customerId = NULL;

                        //Set variables from result set
                        $resourceId = escape($r->resource_id);
                        $resourceUniqueValue = escape($r->resource_unique_value);
                        $resourceBrand = escape($r->resource_brand);
                        $resourceModel = escape($r->resource_model);
                        $resourceType = escape($r->resource_type);
                        if (isset($r->voucher_value)) {
                            $voucherValue = escape($r->voucher_value);
                        }
                        $resourceStatus = escape($r->resource_status);
                        $resourceLocation = escape($r->resource_location_name);
                        if (isset($r->customer_account_id)) {
                            $customerId = escape($r->customer_account_id);
                        }

                        echo '<tr>';
                        echo '<td><a href="viewInventoryDetails.php?id=' . $resourceId . '">' . $resourceUniqueValue . '</a></td>';
                        echo '<td>' . $resourceBrand . '</td>';
                        echo '<td>' . $resourceModel . '</td>';
                        echo '<td>' . $resourceType . '</td>';
                        echo '<td>' . $voucherValue . '</td>';
                        echo '<td>' . $resourceStatus . '</td>';
                        echo '<td>' . $resourceLocation . '</td>';
                        echo '<td><a href="viewCustomerDetails.php?id=' . $customerId . '">' . $customerId . '</a></td>';
                        echo '<td></td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
            <?php
        }
    }

    public function validateTransfer($from, $to, $currentLocationId, $location)
    {

        //confirm that resource range is of the same type
        $fromModel = escape(substr($from, 0, 6));
        $toModel = escape(substr($to, 0, 6));

        if($fromModel !== $toModel){

            $hash = new hash();
            redirect::to('inventory.php?' . hash::sha256('notSameModel' . $hash->getSalt()));

        }

        //check if resource range returns any results
        $sql = "select * from ims.resources r where r.resource_unique_value BETWEEN '$from' AND '$to'";

        //get records
        $get = $this->_db->query($sql);

        //get records
        if (!$get->count()) {

            $hash = new hash();
            redirect::to('inventory.php?' . hash::sha256('empty' . $hash->getSalt()));

        } else {

            //select valid
            $sql = "SELECT 
                    r.resource_unique_value,
                    rm.resource_model,
                    rb.resource_brand,
                    rt.resource_type,
                    vv.voucher_value,
                    rs.resource_status,
                    rl.resource_location_name
                FROM
                    ims.resources r
                        INNER JOIN
                    ims.resource_models rm ON r.resource_model_id = rm.resource_model_id
                        INNER JOIN
                    ims.resource_brands rb ON rm.resource_brand_id = rb.resource_brand_id
                        INNER JOIN
                    ims.resource_types rt ON r.resource_type_id = rt.resource_type_id
                        LEFT JOIN
                    ims.voucher_values vv ON r.voucher_value_id = vv.voucher_value_id
                        INNER JOIN
                    ims.resource_statuses rs ON r.resource_status_id = rs.resource_status_id
                        INNER JOIN
                    ims.resource_locations rl ON r.resource_location_id = rl.resource_location_id
                WHERE
                    r.resource_unique_value BETWEEN '$from' AND '$to'
                        AND r.resource_status_id = 1
                        AND r.resource_location_id = '$currentLocationId'
                        AND r.customer_account_id IS NULL";

            //display valid
            $get = $this->_db->query($sql);

            if (!$get->count()) {

            } else {
                ?>
                <div class="form-style">
                    <form action="inventoryTransfer.php" method="post" name="inventoryTransfer">
                        <input type="hidden" name="from" value="<?php echo $from; ?>">
                        <input type="hidden" name="to" value="<?php echo $to; ?>">
                        <input type="hidden" name="currentLocationId" value="<?php echo $currentLocationId; ?>">
                        <input type="hidden" name="LocationId" value="<?php echo $location; ?>">
                        <input type="submit" value="TRANSFER"/>
                    </form>
                </div>
                <div class="center-table">
                    <table>
                        <tr>
                            <th>Resource</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Status</th>
                            <th>Location</th>
                        </tr>
                        <?php

                        foreach ($get->results() as $r) {

                            //Set initial variable value to empty
                            $voucherValue = NULL;

                            //Set variables from result set
                            $resourceUniqueValue = escape($r->resource_unique_value);
                            $resourceBrand = escape($r->resource_brand);
                            $resourceModel = escape($r->resource_model);
                            $resourceType = escape($r->resource_type);
                            if (isset($r->voucher_value)) {
                                $voucherValue = escape($r->voucher_value);
                            }
                            $resourceStatus = escape($r->resource_status);
                            $resourceLocation = escape($r->resource_location_name);

                            echo '<tr>';
                            echo '<td>' . $resourceUniqueValue . '</td>';
                            echo '<td>' . $resourceBrand . '</td>';
                            echo '<td>' . $resourceModel . '</td>';
                            echo '<td>' . $resourceType . '</td>';
                            echo '<td>' . $voucherValue . '</td>';
                            echo '<td>' . $resourceStatus . '</td>';
                            echo '<td>' . $resourceLocation . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </table>
                </div>
                <?php
            }

            //select not valid
            $sql = "SELECT 
                    r.resource_unique_value,
                    rb.resource_brand,
                    rm.resource_model,
                    rt.resource_type,
                    vv.voucher_value,
                    rs.resource_status,
                    rl.resource_location_name,
                    r.customer_account_id
                FROM
                    ims.resources r
                        INNER JOIN
                    ims.resource_models rm ON r.resource_model_id = rm.resource_model_id
                        INNER JOIN
                    ims.resource_brands rb ON rm.resource_brand_id = rb.resource_brand_id
                        INNER JOIN
                    ims.resource_types rt ON r.resource_type_id = rt.resource_type_id
                        LEFT JOIN
                    ims.voucher_values vv ON r.voucher_value_id = vv.voucher_value_id
                        INNER JOIN
                    ims.resource_statuses rs ON r.resource_status_id = rs.resource_status_id
                        INNER JOIN
                    ims.resource_locations rl ON r.resource_location_id = rl.resource_location_id
                WHERE
                    r.resource_unique_value BETWEEN '$from' AND '$to'
                        AND (r.resource_status_id <> 1
                        OR r.resource_location_id <> '$currentLocationId'
                        OR r.customer_account_id IS NOT NULL)";

            //display invalid
            $get = $this->_db->query($sql);

            if (!$get->count()) {

            } else {
                ?>
                <div class="separator">
                    <h2>Inventory listed below cannot be transferred</h2>
                </div>
                <div class="center-table">
                    <table>
                        <tr>
                            <th>Resource</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Customer</th>
                        </tr>
                        <?php

                        foreach ($get->results() as $r) {

                            //Set initial variable value to empty
                            $voucherValue = NULL;
                            $customer = NULL;

                            //Set variables from result set
                            $resourceUniqueValue = escape($r->resource_unique_value);
                            $resourceBrand = escape($r->resource_brand);
                            $resourceModel = escape($r->resource_model);
                            $resourceType = escape($r->resource_type);
                            if (isset($r->voucher_value)) {
                                $voucherValue = escape($r->voucher_value);
                            }
                            $resourceStatus = escape($r->resource_status);
                            $resourceLocation = escape($r->resource_location_name);
                            if (isset($r->customer_account_id)) {
                                $customer = escape($r->customer_account_id);
                            }

                            echo '<tr>';
                            echo '<td>' . $resourceUniqueValue . '</td>';
                            echo '<td>' . $resourceBrand . '</td>';
                            echo '<td>' . $resourceModel . '</td>';
                            echo '<td>' . $resourceType . '</td>';
                            echo '<td>' . $voucherValue . '</td>';
                            echo '<td>' . $resourceStatus . '</td>';
                            echo '<td>' . $resourceLocation . '</td>';
                            echo '<td>' . $customer . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </table>
                </div>
                <?php
            }

        }

    }

    public function createTransferRequest($from, $to, $currentLocationId, $location)
    {
        //continue from here
            //update resources to reserved

            //insert row in inventory transfers
    }

    public function createResourceType($fields = array())
    {
        if (!$this->_db->insert('resource_types', $fields)) {
            throw new Exception('There was a problem creating entry');
        }
    }

    public function createResourceStatus($fields = array())
    {
        if (!$this->_db->insert('resource_statuses', $fields)) {
            throw new Exception('There was a problem creating entry');
        }
    }

    public function createResourceModel($fields = array())
    {
        if (!$this->_db->insert('resource_models', $fields)) {
            throw new Exception('There was a problem creating entry');
        }
    }

    public function createResourceBrand($fields = array())
    {
        if (!$this->_db->insert('resource_brands', $fields)) {
            throw new Exception('There was a problem creating entry');
        }
    }

    public function data()
    {
        return $this->_data;
    }

}