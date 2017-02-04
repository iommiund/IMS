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
            $voucherValue = '';
            $vrID = 1;
            $reqSNLength = '';
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

                    /* echo 'resource unique value: ' . $resourceUniqueValue . '<br>';
                    echo 'resource brand: ' . $resourceBrandId . '<br>';
                    echo 'resource model: ' . $resourceModelId . '<br>';
                    echo 'resource type: ' . $resourceTypeId . '<br>';
                    echo 'model identifier: ' . $modelIdentifier . '<br>';
                    echo 'resource length: ' . $resourceLength . '<br>';
                    echo 'req length: ' . $reqSNLength . '<br>';
                    echo 'voucher value: ' . $voucherValue . '<br>';
                    echo 'exists flag: ' . $existsFlag . '<br>';
                    echo 'validation: ' . $vrID;
                    die();*/

                    //insert all records in temp table
                    if (!$this->_db->insert('temp_resource', $fields)) {
                        throw new Exception('Your file contains duplicate records.');
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