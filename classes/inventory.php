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

    public function __construct($user = null){
        $this->_db = db::getInstance();
    }

    public function createInventory($fields = array()){
        if (!$this->_db->insert('resources', $fields)){
            throw new Exception('There was a problem creating entry');
        }
    }

    public function createResourceType($fields = array()){
        if (!$this->_db->insert('resource_types', $fields)){
            throw new Exception('There was a problem creating entry');
        }
    }

    public function createResourceStatus($fields = array()){
        if (!$this->_db->insert('resource_statuses', $fields)){
            throw new Exception('There was a problem creating entry');
        }
    }

    public function createResourceModel($fields = array()){
        if (!$this->_db->insert('resource_models', $fields)){
            throw new Exception('There was a problem creating entry');
        }
    }

    public function createResourceBrand($fields = array()){
        if (!$this->_db->insert('resource_brands', $fields)){
            throw new Exception('There was a problem creating entry');
        }
    }

    public function data(){
        return $this->_data;
    }

}