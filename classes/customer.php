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

}