<?php

/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 18/01/2017
 * Time: 20:51
 */
class validation
{
    private $_passed = false,
            $_errors = array(),
            $_db = null;

    //connect to db
    public function __construct()
    {
        $this->_db = db::getInstance();
    }

    //loop through all post irems to check if they meet specified requirements
    public function check($source, $items = array()){
        foreach($items as $item => $rules){

            //loop through each rule
            foreach ($rules as $rule => $rule_value){

                //get the value of each item
                $value = trim($source[$item]);
                $item=escape($item); //escape all values

                //if the value is required but is empty display error
                if ($rule == 'required' && empty($value)) {
                    $this->addError("{$item} is required");
                } else if (!empty($value)){
                    switch ($rule){
                        case 'min';
                            if (strlen($value) < $rule_value){
                                $this->addError("{$item} must be a minimum of {$rule_value} characters.");
                            }
                            break;
                        case 'max';
                            if (strlen($value) > $rule_value){
                                $this->addError("{$item} must be a maximum of {$rule_value} characters.");
                            }
                            break;
                        case 'unique';

                            $check = $this->_db->query("select * from ims_iommiunderwood.users where user_username = '$value' or user_email = '$value'");

                            if ($check->count()){
                                $this->addError("{$item} already exists");
                            }
                            break;
                    }
                }

            }
        }

        // check if any errors exist and sets passed to true
        if (empty($this->_errors)){
            $this->_passed = true;
        }

        return $this;
    }

    // sets error message
    private function addError($error){
        $this->_errors[] = $error;
    }

    // returns a list of errors
    public function errors(){
        return $this->_errors;
    }

    public function passed() {
        return $this->_passed;
    }
}