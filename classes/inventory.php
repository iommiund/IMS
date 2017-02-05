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
                    if (isset($r->resource_brand_id, $r->resource_model_id, $r->resource_type_id, $r->resource_sn_length)){
                        $resourceBrandId = escape($r->resource_brand_id);
                        $resourceModelId = escape($r->resource_model_id);
                        $resourceTypeId = escape($r->resource_type_id);
                        $reqSNLength = escape($r->resource_sn_length);
                        if (isset($r->voucher_value_id)) {$voucherValue = escape($r->voucher_value_id);}
                    }

                    //Check if resource already exists
                    $sql = "select * from ims.resources r where r.resource_unique_value = \"$resourceUniqueValue\"";

                    //Run query
                    $get = $this->_db->query($sql);

                    if(!$get->count()){

                        //If the resource does not exist, set flag to O
                        $existsFlag = 0;

                    } else {

                        //If the resource exists, set flag to 1
                        $existsFlag = 1;

                        //And set validation result to resource exists
                        $vrID = 2;
                    }

                    //If serial number length does not match
                    if($resourceLength !== $reqSNLength){

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

            echo '<tr>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '</tr>';

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
                if (isset($r->resource_unique_value)){
                    $resourceUniqueValue = escape($r->resource_unique_value);
                    if (isset($r->resource_brand)){$resourceBrand = escape($r->resource_brand);}
                    if (isset($r->resource_model)){$resourceModel = escape($r->resource_model);}
                    if (isset($r->resource_type)){$resourceType = escape($r->resource_type);}
                    if (isset($r->voucher_value)) {$voucherValue = escape($r->voucher_value);}
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

                //declare variables
                $resourceUniqueValue = escape($r->resource_unique_value);
                $resourceModelId = escape($r->resource_model_id);
                $resourceTypeId = escape($r->resource_type_id);
                if (isset($r->voucher_value_id)) {$voucherValueId = escape($r->voucher_value_id);}

                //create fields array to insert values in temp table
                $fields = array(
                    'resource_unique_value' => $resourceUniqueValue,
                    'resource_model_id' => $resourceModelId,
                    'resource_type_id' => $resourceTypeId,
                    'voucher_value_id' => $voucherValueId,
                    'resource_status_id' => 1, //Available
                    'resource_location_id' => 1 //Main Warehouse
                );

                //insert resources
                if (!$this->_db->insert('resources', $fields)) {
                    throw new Exception('There was a problem creating entry');
                } else {

                    $user = new user();

                    //get resource id for newly added resource
                    $sql = "select * from ims.resources r where r.resource_unique_value = {$resourceUniqueValue}";

                    $get = $this->_db->query($sql);

                    if (!$get->count()) {
                        echo 'Nothing to upload';
                    } else {

                        //for each record
                        foreach ($get->results() as $t) {

                            //declare variables
                            $uid = escape($user->data()->uid);
                            $resourceId = escape($t->resource_id);
                            $resourceStatusId = escape($t->resource_status_id);
                            $resourceLocationId = escape($t->resource_location_id);

                            //create fields array to insert values in temp table
                            $fields = array(
                                'uid' => $uid,
                                'resource_id' => $resourceId,
                                'resource_status_id' => $resourceStatusId,
                                'resource_location_id' => $resourceLocationId,
                                'transaction_type_id' => 1, //Resource Upload
                                'transaction_status_id' => 1 //Complete
                            );

                            //insert transaction
                            if (!$this->_db->insert('transactions', $fields)) {
                                throw new Exception('There was a problem creating entry');
                            }

                        }

                    }

                }

            }

        }

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