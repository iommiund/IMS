<?php

/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 18/01/2017
 * Time: 20:51
 */
class location
{
    private $_db,
        $_data;

    public function __construct($user = null){
        $this->_db = db::getInstance();
    }

    public function createLocation($fields = array()){
        if (!$this->_db->insert('resource_locations', $fields)){
            throw new Exception('There was a problem creating entry');
        }
    }

    public function createLocationType($fields = array()){
        if (!$this->_db->insert('resource_location_types', $fields)){
            throw new Exception('There was a problem creating entry');
        }
    }

    public function data(){
        return $this->_data;
    }

}