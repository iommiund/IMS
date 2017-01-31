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

    public function loadInventory($file)
    {

        $handle = fopen($file, "r");

        while (($fileop = fgetcsv($handle, 1000, ",")) !== false) {

            $resourceUniqueValue = $fileop[0];
            $voucherValue = $fileop[1];
            $modelIdentifier = substr($resourceUniqueValue, 0, 6);
            $resourceLength = strlen($resourceUniqueValue);

            $fields = array(
                'resource_unique_value' => $resourceUniqueValue,
                'voucher_value_id' => $voucherValue,
                'resource_model_identifier' => $modelIdentifier,
                'resource_sn_length' => $resourceLength
            );

            if (!$this->_db->insert('temp_resource', $fields)) {
                throw new Exception('Your file contains duplicate records.');
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