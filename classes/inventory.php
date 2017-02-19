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

                        //Set validation result to serial number length is incorrect
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
                    'resource_latitude' => 35.891747,
                    'resource_longitude' => 14.458700,
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
                    rs.resource_status_id,
                    rs.resource_status,
                    rl.resource_location_id,
                    rl.resource_location_name,
                    rl.resource_location_type_id,
                    ca.customer_account_id,
                    rm.sell,
                    rm.install
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
                order by 1";

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
                        <th colspan="3">Options</th>
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
                        $resourceStatusId = escape($r->resource_status_id);
                        $resourceStatus = escape($r->resource_status);
                        $resourceLocationId = escape($r->resource_location_id);
                        $resourceLocation = escape($r->resource_location_name);
                        $resourceLocationTypeId = escape($r->resource_location_type_id);
                        if (isset($r->customer_account_id)) {
                            $customerId = escape($r->customer_account_id);
                        }
                        $sellFlag = escape($r->sell);
                        $installFlag = escape($r->install);

                        echo '<tr>';
                        echo '<td><a href="viewInventoryDetails.php?id=' . $resourceId . '">' . $resourceUniqueValue . '</a></td>';
                        echo '<td>' . $resourceBrand . '</td>';
                        echo '<td>' . $resourceModel . '</td>';
                        echo '<td>' . $resourceType . '</td>';
                        echo '<td>' . $voucherValue . '</td>';
                        echo '<td>' . $resourceStatus . '</td>';
                        echo '<td>' . $resourceLocation . '</td>';
                        echo '<td><a href="viewCustomerDetails.php?id=' . $customerId . '">' . $customerId . '</a></td>';

                        $user = new user();
                        $userLocationId = escape($user->data()->resource_location_id);

                        //if customer id is null, and status = available, and location <> customer, and install = 1 leave blank
                        if ($installFlag == 1 && $customerId == null && $resourceStatusId == 1 && $resourceLocationId !== 7) {
                            echo '<td></td>';

                            //else if customer id is not null, and status = allocated and location = customer and install = 1 insert link for replace
                        } elseif ($installFlag == 1 && $customerId !== null && $resourceStatusId == 2 && $resourceLocationId == 7) {

                            if ($user->hasPermission('orderReplaceResource') || $user->hasPermission('allAccess')) {
                                echo '<td><a href="replaceResource.php?id=' . $resourceId . '">Replace</a></td>';
                            }

                            //else leave blank
                        } else {
                            echo '<td></td>';
                        }

                        //if customer id is null, and status = available, and location <> customer, and install = 1 leave blank
                        if ($installFlag == 1 && $customerId == null && $resourceStatusId == 1 && $resourceLocationId != 7) {
                            echo '<td></td>';

                            //else if customer id is not null, and status = allocated and location = customer and install = 1 insert link for collection
                        } elseif ($customerId !== null && $resourceStatusId == 2 && $resourceLocationId == 7 && $installFlag == 1) {

                            if ($user->hasPermission('orderCollectResource') || $user->hasPermission('allAccess')) {
                                echo '<td><a href="collectResource.php?id=' . $resourceId . '">Collect</a></td>';
                            }

                            //else leave blank
                        } else {
                            echo '<td></td>';
                        }

                        //if resource location is main warehouse or location type = field user leave blank
                        if (($sellFlag == 1 && $resourceLocationId == 1) || ($sellFlag == 1 && $resourceLocationTypeId == 2)) {
                            echo '<td></td>';

                            //else if sell = 1, and status = available, and location = user location link for sell
                        } elseif ($sellFlag == 1 && $resourceStatusId == 1 && $resourceLocationId == $userLocationId) {

                            if ($user->hasPermission('sellResource') || $user->hasPermission('allAccess')) {
                                echo '<td><a href="sellResource.php?id=' . $resourceId . '">Sell</a></td>';
                            }

                            //else leave blank
                        } else {
                            echo '<td></td>';

                        }
                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
            <?php
        }
    }

    public function validateTransfer($from, $to, $currentLocationId, $location, $latitude, $longitude)
    {
        //confirm that resource range is of the same type
        $fromModel = escape(substr($from, 0, 6));
        $toModel = escape(substr($to, 0, 6));

        if ($fromModel !== $toModel) {

            $hash = new hash();
            redirect::to('inventory.php?' . hash::sha256('notSameModel' . $hash->getSalt()));

        }

        //check if resource range returns any results
        $sql = "select * from ims.resources r where r.resource_unique_value BETWEEN '$from' AND '$to'";

        //get records
        $getResults = $this->_db->query($sql);

        //if records returned
        if (!$getResults->count()) {

            $hash = new hash();
            redirect::to('inventory.php?' . hash::sha256('empty' . $hash->getSalt()));

        } else {

            //hold the count of rows for all resources
            $allRowsCount = $getResults->count();

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
            $getValid = $this->_db->query($sql);

            if (!$getValid->count()) {

            } else {

                //hold the count of rows for valid resources
                $validRowsCount = $getValid->count();

                //if all valid rows is less than all rows count display message to edit range
                if ($validRowsCount < $allRowsCount) {
                    ?>
                    <div class="reset-password">
                        <div id="error">
                            <br>
                            The range you entered is not all valid, please <a href="inventory.php">go back</a> and edit
                            range.
                        </div>
                    </div>
                    <?php

                    //else if rows count = valid rows display transfer button
                } else {
                    ?>
                    <div class="form-style">
                        <form action="inventoryTransfer.php" method="post" name="inventoryTransfer">
                            <input type="hidden" name="from" value="<?php echo $from; ?>">
                            <input type="hidden" name="to" value="<?php echo $to; ?>">
                            <input type="hidden" name="currentLocationId" value="<?php echo $currentLocationId; ?>">
                            <input type="hidden" name="locationId" value="<?php echo $location; ?>">
                            <input type="hidden" name="latitude" value="<?php echo $latitude; ?>">
                            <input type="hidden" name="longitude" value="<?php echo $longitude; ?>">
                            <input type="submit" value="TRANSFER"/>
                        </form>
                    </div>
                    <?php
                }
                ?>
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

                        foreach ($getValid->results() as $r) {

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

    public function createTransferRequest($from, $to, $currentLocationId, $location, $latitude, $longitude)
    {
        //get description
        $sql = "select
                  concat(rb.resource_brand, ' ', rm.resource_model, ' ', rt.resource_type) as description
                from ims.resources r
                    inner join
                    ims.resource_models rm on r.resource_model_id = rm.resource_model_id
                    inner join
                    ims.resource_brands rb on rm.resource_brand_id = rb.resource_brand_id
                    inner join ims.resource_types rt on rm.resource_type_id = rt.resource_type_id
                    where r.resource_unique_value = '$from'";

        //get data
        $get = $this->_db->query($sql);

        //if results returned
        if (!$get->count()) {

        } else {

            //declare description variable
            foreach ($get->results() as $d) {

                //Set variables from result set
                $description = escape($d->description);
            }

            $user = new user();

            //declare variables
            $uid = escape($user->data()->uid);

            //create fields array to insert values in inventory transfers table
            $fields = array(
                'creation_uid' => $uid,
                'from_resource' => $from,
                'to_resource' => $to,
                'description' => $description,
                'from_location' => $currentLocationId,
                'to_location' => $location,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'status_id' => 1
            );

            //insert records in inventory transfers table
            if (!$this->_db->insert('inventory_transfers', $fields)) {
                throw new Exception('error');
            } else {

                $hash = new hash();
                redirect::to('inventory.php?' . hash::sha256('createTransferRequestSuccess' . $hash->getSalt()));

            }

        }

    }

    public function showPendingTransfers()
    {

        $user = new user();

        //get user location
        $userLocation = escape($user->data()->resource_location_id);

        //get pending resource transfers for destined for user location
        $sql = "SELECT
                it.transfer_id,
                concat(u.name, ' ' , u.surname) as full_name,
                it.from_resource,
                it.to_resource,
                it.description,
                rl.resource_location_name,
                it.to_location,
                date_format(it.timestamp,'%D %b %Y') as pending_since,
                it.latitude,
                it.longitude
                FROM ims.inventory_transfers it
                    inner join
                    ims.users u on it.creation_uid = u.uid
                    inner join
                    ims.resource_locations rl on it.from_location = rl.resource_location_id
                    inner join
                    ims.inventory_transfers_statuses its on it.status_id = its.status_id
                where to_location = {$userLocation} and it.status_id = 1";

        //get data
        $get = $this->_db->query($sql);

        //if data returned
        if (!$get->count()) {

        } else {
            ?>

            <div class="separator">
                <h2>Pending Transfers for your location</h2>
            </div>
            <div class="center-table">
                <table>
                    <tr>
                        <th>Initiator</th>
                        <th>First Resource</th>
                        <th>Last Resource</th>
                        <th>Description</th>
                        <th>Arriving From</th>
                        <th>Pending Since</th>
                        <th colspan="2">Options</th>
                    </tr>
                    <?php

                    foreach ($get->results() as $t) {

                        //Set variables from result set
                        $transferId = escape($t->transfer_id);
                        $initiator = escape($t->full_name);
                        $firstResource = escape($t->from_resource);
                        $lastResource = escape($t->to_resource);
                        $description = escape($t->description);
                        $arrivingFrom = escape($t->resource_location_name);
                        $destination = escape($t->to_location);
                        $pendingSince = escape($t->pending_since);
                        $latitude = escape($t->latitude);
                        $longitude = escape($t->longitude);

                        echo '<tr>';
                        echo '<td>' . $initiator . '</td>';
                        echo '<td>' . $firstResource . '</td>';
                        echo '<td>' . $lastResource . '</td>';
                        echo '<td>' . $description . '</td>';
                        echo '<td>' . $arrivingFrom . '</td>';
                        echo '<td>' . $pendingSince . '</td>';
                        if ($user->hasPermission('acceptTransfer') || $user->hasPermission('allAccess')) {
                            echo '<td><a href="acceptTransfer.php?id=' . $transferId . '&firstResource=' . $firstResource . '&lastResource=' . $lastResource . '&destination=' . $destination . '&latitude=' . $latitude . '&longitude=' . $longitude . '">Accept</a></td>';
                        } else {
                            echo '<td></td>';
                        }
                        if ($user->hasPermission('rejectTransfer') || $user->hasPermission('allAccess')) {
                            echo '<td><a href="rejectTransfer.php?id=' . $transferId . '&firstResource=' . $firstResource . '&lastResource=' . $lastResource . '">Reject</a></td>';
                        } else {
                            echo '<td></td>';
                        }
                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
            <?php
        }

    }

    public function showAllPendingTransfers()
    {

        //get pending resource transfers for destined for user location
        $sql = "SELECT
                concat(u.name, ' ' , u.surname) as full_name,
                it.from_resource,
                it.to_resource,
                it.description,
                rl.resource_location_name,
                date_format(it.timestamp,'%D %b %Y') as pending_since
                FROM ims.inventory_transfers it
                    inner join
                    ims.users u on it.creation_uid = u.uid
                    inner join
                    ims.resource_locations rl on it.to_location = rl.resource_location_id
                    inner join
                    ims.inventory_transfers_statuses its on it.status_id = its.status_id
                    where it.status_id = 1";

        //display invalid
        $get = $this->_db->query($sql);

        if (!$get->count()) {

        } else {
            ?>

            <div class="separator">
                <h2>All Pending Transfers</h2>
            </div>
            <div class="center-table">
                <table>
                    <tr>
                        <th>Initiator</th>
                        <th>First Resource</th>
                        <th>Last Resource</th>
                        <th>Description</th>
                        <th>Destination</th>
                        <th>Pending Since</th>
                    </tr>
                    <?php

                    foreach ($get->results() as $t) {

                        //Set variables from result set
                        $initiator = escape($t->full_name);
                        $firstResource = escape($t->from_resource);
                        $lastResource = escape($t->to_resource);
                        $description = escape($t->description);
                        $arrivingFrom = escape($t->resource_location_name);
                        $pendingSince = escape($t->pending_since);

                        echo '<tr>';
                        echo '<td>' . $initiator . '</td>';
                        echo '<td>' . $firstResource . '</td>';
                        echo '<td>' . $lastResource . '</td>';
                        echo '<td>' . $description . '</td>';
                        echo '<td>' . $arrivingFrom . '</td>';
                        echo '<td>' . $pendingSince . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
            <?php
        }

    }

    public function acceptTransfer($uid, $transferId, $firstResource, $lastResource, $destination, $latitude, $longitude)
    {

        //update transaction status and closing user
        if (!db::getInstance()->query("update ims.inventory_transfers set status_id = 2, closing_uid = {$uid} where transfer_id = {$transferId}")) {
            echo 'could not update inventory transfers table';
            die();
        } else {

            //update resources with available status and final destination
            if (!db::getInstance()->query("update ims.resources set resource_status_id = 1, resource_location_id = {$destination}, resource_latitude = '$latitude', resource_longitude = '$longitude', last_update_user = {$uid} where resource_unique_value between '$firstResource' and '$lastResource'")) {
                echo 'could not update resources table';
                die();
            } else {

                //prepare query to get all resource_ids for the updated resources
                $sql = "SELECT 
                    resource_id
                FROM
                    ims.resources
                WHERE
                    resource_unique_value BETWEEN '$firstResource' AND '$lastResource'";

                $get = $this->_db->query($sql);

                if (!$get->count()) {
                    echo 'could not get resource ids';
                } else {

                    foreach ($get->results() as $r) {

                        //set variables from result set
                        $resourceId = escape($r->resource_id);

                        //insert a new transaction for the updated resource
                        db::getInstance()->query("insert into ims.transactions (uid, resource_id, resource_status_id, resource_location_id, transaction_type_id,transaction_status_id, resource_latitude, resource_longitude) values({$uid},{$resourceId},1,{$destination},2,1, '$latitude', '$longitude')");

                    }

                    $hash = new hash();
                    redirect::to('main.php?' . hash::sha256('transferAccepted' . $hash->getSalt()));

                }

            }

        }

    }

    public function rejectTransfer($uid, $transferId, $firstResource, $lastResource)
    {

        //update transaction status and closing user
        if (!db::getInstance()->query("update ims.inventory_transfers set status_id = 3, closing_uid = {$uid} where transfer_id = {$transferId}")) {
            echo 'could not update inventory transfers table';
        } else {

            //update resources with available status
            if (!db::getInstance()->query("update ims.resources set resource_status_id = 1 where resource_unique_value between '$firstResource' and '$lastResource'")) {
                echo 'could not update resources table';
            } else {

                $hash = new hash();
                redirect::to('main.php?' . hash::sha256('transferRejected' . $hash->getSalt()));

            }

        }

    }

    public function allStockLevels()
    {

        //prepare sql query to get all locations
        $sql = "SELECT 
                    rl.resource_location_id, rl.resource_location_name
                FROM
                    resource_locations rl
                WHERE
                    rl.resource_location_type_id <> 3";

        $get = $this->_db->query($sql);

        if (!$get->count()) {
            echo 'could not get data';
        } else {

            foreach ($get->results() as $l) {
                $locationId = escape($l->resource_location_id);
                $locationName = escape($l->resource_location_name);

                echo '<div class="separator">';
                echo '<h2>Stock levels for ' . $locationName . '</h2>';
                echo '</div>';

                $this->stockLevels($locationId);
            }

        }

    }

    public function stockLevels($userLocation)
    {
        ?>
        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {

                // Create the data table.
                var data = google.visualization.arrayToDataTable([
                    ['Model', 'Quantity', {role: 'style'}, {role: 'annotation'}]
                    <?php

                    //get data to populate table
                    $sql = "SELECT 
                                CONCAT(rm.resource_model,
                                        ' ',
                                        IFNULL(r.voucher_value_id, '')) AS model,
                                COUNT(*) AS quantity,
                                rm.warning,
                                rm.danger
                            FROM
                                ims.resources r
                                    INNER JOIN
                                ims.resource_models rm ON r.resource_model_id = rm.resource_model_id
                            WHERE
                                r.resource_location_id = {$userLocation}
                                    AND r.resource_status_id = 1
                            GROUP BY model
                            ORDER BY 1";

                    $get = $this->_db->query($sql);

                    if (!$get->count()) {
                        echo 'could not get data';
                    } else {

                        foreach ($get->results() as $m) {

                            //set variables from result set
                            $model = escape($m->model);
                            $quantity = escape($m->quantity);
                            $warning = escape($m->warning);
                            $danger = escape($m->danger);

                            if ($quantity > $warning) {
                                echo ",['" . $model . "', " . $quantity . ", 'color: #009688', " . $quantity . "]";
                            } elseif ($quantity <= $warning && $quantity > $danger) {
                                echo ",['" . $model . "', " . $quantity . ", 'color: #FFC107', " . $quantity . "]";
                            } elseif ($quantity <= $danger) {
                                echo ",['" . $model . "', " . $quantity . ", 'color: #F44336', " . $quantity . "]";
                            }

                        }

                    }

                    ?>
                ]);

                var options = {
                    legend: {position: 'none'},
                    backgroundColor: "transparent",
                    width: 1175,
                    height: 300
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('chart_div<?php echo $userLocation; ?>'));
                chart.draw(data, options);

            }
        </script>
        <div id="chart_div<?php echo $userLocation; ?>"></div>
        <?php
    }

    public function getInventoryDetails($resourceId)
    {

        //prepare sql query to get resource details
        $sql = "SELECT 
                    r.resource_id,
                    r.resource_unique_value,
                    rb.resource_brand,
                    CONCAT(rm.resource_model,
                            ' ',
                            IFNULL(r.voucher_value_id, '')) AS model,
                    rt.resource_type,
                    rs.resource_status,
                    rl.resource_location_name,
                    r.customer_account_id,
                    r.resource_latitude,
                    r.resource_longitude
                FROM
                    ims.resources r
                        INNER JOIN
                    ims.resource_models rm ON r.resource_model_id = rm.resource_model_id
                        INNER JOIN
                    ims.resource_brands rb ON rm.resource_brand_id = rb.resource_brand_id
                        INNER JOIN
                    ims.resource_types rt ON r.resource_type_id = rt.resource_type_id
                        INNER JOIN
                    ims.resource_statuses rs ON r.resource_status_id = rs.resource_status_id
                        INNER JOIN
                    ims.resource_locations rl ON r.resource_location_id = rl.resource_location_id
                where r.resource_id = {$resourceId}";

        //execute sql query
        $get = $this->_db->query($sql);

        //if no error returned display details
        if (!$get->count()) {
            echo 'could not get data';
        } else {

            foreach ($get->results() as $i) {

                //set initial variable values
                $customer = 'Not allocated to any customer';
                $latitude = null;
                $longitude = null;

                //Set variables from result set
                $resourceUniqueValue = escape($i->resource_unique_value);
                $resourceBrand = escape($i->resource_brand);
                $resourceModel = escape($i->model);
                $resourceType = escape($i->resource_type);
                $resourceStatus = escape($i->resource_status);
                $resourceLocation = escape($i->resource_location_name);
                if (isset($i->customer_account_id)) {
                    $customerId = escape($i->customer_account_id);
                    $customer = '<a href="viewCustomerDetails.php?id=' . $customerId . '">' . $customerId . '</a>';
                }
                if (isset($i->resource_latitude)) {
                    $latitude = escape($i->resource_latitude);
                }
                if (isset($i->resource_longitude)) {
                    $longitude = escape($i->resource_longitude);
                }

                ?>
                <div class="separator">
                    <h1>Inventory Details</h1>
                </div>
                <table class="ctable">
                    <tr>
                        <td><b>Resource SN: </b></td>
                        <td><?php echo $resourceUniqueValue; ?></td>
                    </tr>
                    <tr>
                        <td><b>Vendor: </b></td>
                        <td><?php echo $resourceBrand; ?></td>
                    </tr>
                    <tr>
                        <td><b>Model: </b></td>
                        <td><?php echo $resourceModel; ?></td>
                    </tr>
                    <tr>
                        <td><b>Type: </b></td>
                        <td><?php echo $resourceType; ?></td>
                    </tr>
                    <tr>
                        <td><b>Status: </b></td>
                        <td><?php echo $resourceStatus; ?></td>
                    </tr>
                    <tr>
                        <td><b>Location: </b></td>
                        <td><?php echo $resourceLocation; ?></td>
                    </tr>
                    <tr>
                        <td><b>Customer: </b></td>
                        <td><?php echo $customer; ?></td>
                    </tr>
                </table>
                <?php
                if ($latitude == null && $longitude == null) {

                } else {
                    ?>
                    <div class="separator">
                        <h2>Resource Map Location</h2>
                    </div>
                    <div id="map"></div>
                    <script>
                        function initMap() {
                            var location = {lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?>};
                            var map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 14,
                                center: location,
                                disableDefaultUI: true,
                                styles: <?php include_once('includes/mapStyle.php');?>
                            });
                            var marker = new google.maps.Marker({
                                position: location,
                                map: map
                            });
                        }
                    </script>
                    <script async defer
                            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWv5w-eY6YEfFCJfbQBaHsxHMplfhpxEc&callback=initMap">
                    </script>
                    <?php
                }

            }

        }

    }

    public function getResourceHistory($resourceId)
    {
        ?>
        <div class="separator">
            <h2>Resource History</h2>
        </div>
        <?php

        //prepare sql query to get resource history
        $sql = "SELECT 
                    t.transaction_id,
                    CONCAT(u.name, ' ', u.surname) as fullName,
                    rs.resource_status,
                    rl.resource_location_name,
                    t.customer_account_id,
                    t.initiation_timestamp,
                    tt.transaction_type,
                    ts.transaction_status
                FROM
                    ims.transactions t
                        INNER JOIN
                    ims.users u ON t.uid = u.uid
                        INNER JOIN
                    ims.resources r ON t.resource_id = r.resource_id
                        INNER JOIN
                    ims.resource_statuses rs ON t.resource_status_id = rs.resource_status_id
                        INNER JOIN
                    ims.resource_locations rl ON t.resource_location_id = rl.resource_location_id
                        INNER JOIN
                    ims.transaction_types tt ON t.transaction_type_id = tt.transaction_type_id
                        INNER JOIN
                    ims.transaction_statuses ts ON t.transaction_status_id = ts.transaction_status_id
                WHERE
                    t.resource_id = {$resourceId}
                ORDER BY t.transaction_id DESC";

        $get = $this->_db->query($sql);

        if (!$get->count()) {

        } else {
            ?>
            <div class="center-table">
                <table>
                    <tr>
                        <th>User Name</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>Customer</th>
                        <th>Date & Time</th>
                        <th>Type</th>
                        <th>Transaction Status</th>
                    </tr>
                    <?php

                    foreach ($get->results() as $h) {

                        //Set initial variable value to empty
                        $customer = NULL;

                        //Set variables from result set
                        $fullName = escape($h->fullName);
                        $resourceStatus = escape($h->resource_status);
                        $resourceLocation = escape($h->resource_location_name);
                        if (isset($h->customer_account_id)) {
                            $customerId = escape($h->customer_account_id);
                            $customer = '<a href="viewCustomerDetails.php?id=' . $customerId . '">' . $customerId . '</a>';
                        }
                        $timestamp = escape($h->initiation_timestamp);
                        $transactionType = escape($h->transaction_type);
                        $transactionStatus = escape($h->transaction_status);

                        echo '<tr>';
                        echo '<td>' . $fullName . '</td>';
                        echo '<td>' . $resourceStatus . '</td>';
                        echo '<td>' . $resourceLocation . '</td>';
                        echo '<td>' . $customer . '</td>';
                        echo '<td>' . $timestamp . '</td>';
                        echo '<td>' . $transactionType . '</td>';
                        echo '<td>' . $transactionStatus . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
            <?php
        }

    }

    public function getInventoryOptions($resourceId)
    {

        $sql = "select
                    r.resource_id,
                    rs.resource_status_id,
                    rl.resource_location_id,
                    rl.resource_location_type_id,
                    r.customer_account_id,
                    rm.sell,
                    rm.install
                FROM
                    ims.resources r
                        LEFT JOIN
                    ims.resource_models rm ON r.resource_model_id = rm.resource_model_id
                        LEFT JOIN
                    ims.resource_statuses rs ON r.resource_status_id = rs.resource_status_id
                        LEFT JOIN
                    ims.resource_locations rl ON r.resource_location_id = rl.resource_location_id  
                where r.resource_id like '$resourceId'";

        $get = $this->_db->query($sql);

        if (!$get->count()) {

        } else {

            foreach ($get->results() as $r) {

                //Set initial variable value to empty
                $customerId = NULL;

                //Set variables from result set
                $resourceId = escape($r->resource_id);
                $resourceStatusId = escape($r->resource_status_id);
                $resourceLocationId = escape($r->resource_location_id);
                $resourceLocationTypeId = escape($r->resource_location_type_id);
                if (isset($r->customer_account_id)) {
                    $customerId = escape($r->customer_account_id);
                }
                $sellFlag = escape($r->sell);
                $installFlag = escape($r->install);

                $user = new user();
                $userLocationId = escape($user->data()->resource_location_id);

                //if customer id is null, and status = available, and location <> customer, and install = 1 leave blank
                if ($installFlag == 1 && $customerId == null && $resourceStatusId == 1 && $resourceLocationId !== 7) {

                    //else if customer id is not null, and status = allocated and location = customer and install = 1 insert link for replace
                } elseif ($installFlag == 1 && $customerId !== null && $resourceStatusId == 2 && $resourceLocationId == 7) {

                    echo '<div class="separator">';
                    echo '<h2>options</h2>';
                    echo '</div>';
                    echo '<table class="ctable">';
                    echo '<tr>';
                    if ($user->hasPermission('orderReplaceResource') || $user->hasPermission('allAccess')) {
                        echo '<td><a href="replaceResource.php?id=' . $resourceId . '">Replace</a></td>';
                    }
                    if ($user->hasPermission('orderCollectResource') || $user->hasPermission('allAccess')) {
                        echo '<td><a href="collectResource.php?id=' . $resourceId . '">Collect</a></td>';
                    }
                    echo '</tr>';
                    echo '</table>';

                    //else leave blank
                } else {

                }

                //if resource location is main warehouse or location type = field user leave blank
                if (($sellFlag == 1 && $resourceLocationId == 1) || ($sellFlag == 1 && $resourceLocationTypeId == 2)) {

                    //else if sell = 1, and status = available, and location = user location link for sell
                } elseif ($sellFlag == 1 && $resourceStatusId == 1 && $resourceLocationId == $userLocationId) {

                    if ($user->hasPermission('sellResource') || $user->hasPermission('allAccess')) {
                        echo '<div class="separator">';
                        echo '<h2>options</h2>';
                        echo '</div>';
                        echo '<table class="ctable">';
                        echo '<tr>';
                        echo '<td><a href="sellResource.php?id=' . $resourceId . '">Sell</a></td>';
                        echo '</tr>';
                        echo '</table>';
                    }

                    //else leave blank
                } else {

                }

            }

        }

    }

    public function sellResource($resourceId, $userLocationId)
    {

        //prepare sql query to get other params
        $sql = "select
                    rs.resource_status_id,
                    rl.resource_location_id,
                    rl.resource_location_type_id,
                    rm.sell
                FROM
                    ims.resources r
                        LEFT JOIN
                    ims.resource_models rm ON r.resource_model_id = rm.resource_model_id
                        LEFT JOIN
                    ims.resource_statuses rs ON r.resource_status_id = rs.resource_status_id
                        LEFT JOIN
                    ims.resource_locations rl ON r.resource_location_id = rl.resource_location_id  
                where r.resource_id = {$resourceId}";

        //get data
        $get = $this->_db->query($sql);

        //if data returned
        if (!$get->count()) {
            echo 'no results returned';
            die();
        } else {

            foreach ($get->results() as $r) {

                //Set variables from result set
                $resourceStatusId = escape($r->resource_status_id);
                $resourceLocationId = escape($r->resource_location_id);
                $resourceLocationTypeId = escape($r->resource_location_type_id);
                $sellFlag = escape($r->sell);

                //if resource location is main warehouse or location type = field user leave blank
                if (($sellFlag == 1 && $resourceLocationId == 1) || ($sellFlag == 1 && $resourceLocationTypeId == 2)) {
                    redirect::to('viewInventoryDetails.php?id=' . $resourceId . '&cannotBeSoldMainOrField');

                    //else if sell = 1, and status = available, and location = user location link for sell
                } elseif ($sellFlag == 1 && $resourceStatusId == 1 && $resourceLocationId == $userLocationId) {

                    $user = new user();
                    $uid = $user->data()->uid;

                    if ($user->hasPermission('sellResource') || $user->hasPermission('allAccess')) {

                        //update status, location, latitude, longitude, and user
                        if (!db::getInstance()->query("UPDATE ims.resources r SET resource_status_id = 4, resource_location_id = 7, resource_latitude = NULL, resource_longitude = NULL, last_update_user = {$uid} WHERE resource_id = {$resourceId}")) {
                            redirect::to('viewInventoryDetails.php?id=' . $resourceId . '&resourceNotUpdated');
                            die();
                        } else {

                            if (!db::getInstance()->query("insert into ims.transactions (uid,resource_id,resource_status_id,resource_location_id,transaction_type_id,transaction_status_id,resource_latitude,resource_longitude) values ({$uid},{$resourceId},4,7,3,1,null,null)")) {
                                redirect::to('viewInventoryDetails.php?id=' . $resourceId . '&transferNotUpdated');
                                die();
                            } else {
                                redirect::to('viewInventoryDetails.php?id=' . $resourceId . '&resourceSold');
                            }

                        }

                    }

                    //else leave blank
                } else {
                    redirect::to('viewInventoryDetails.php?id=' . $resourceId . '&cannotBeSold');
                }

            }
        }

    }

    public
    function createResourceType($fields = array())
    {
        if (!$this->_db->insert('resource_types', $fields)) {
            throw new Exception('There was a problem creating entry');
        }
    }

    public
    function createResourceStatus($fields = array())
    {
        if (!$this->_db->insert('resource_statuses', $fields)) {
            throw new Exception('There was a problem creating entry');
        }
    }

    public
    function createResourceModel($fields = array())
    {
        if (!$this->_db->insert('resource_models', $fields)) {
            throw new Exception('There was a problem creating entry');
        }
    }

    public
    function createResourceBrand($fields = array())
    {
        if (!$this->_db->insert('resource_brands', $fields)) {
            throw new Exception('There was a problem creating entry');
        }
    }

    public
    function data()
    {
        return $this->_data;
    }

}