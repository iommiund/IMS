<?php

/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 18/01/2017
 * Time: 20:51
 */
class user
{
    private $_db,
            $_data;

    public function __construct($user = null)
    {
        $this->_db = db::getInstance();
    }

    public function create($name, $surname, $email, $username, $password, $saltValue, $type, $status){

        $addUser = $this->_db->query("INSERT INTO ims_iommiunderwood.users (user_name,user_surname,user_email,user_username,user_password,user_salt,user_type_id,user_status_id) VALUES ('$name','$surname','$email','$username','$password','$saltValue','$type','$status')");

        if ($addUser) {
            return true;
        } else {
            throw new Exception('There was a problem creating new user!');
        }
    }

    // check if user exists in database by selecting with id or username
    public function find($user = null){

        if ($user) {
            $field = (is_numeric($user)) ? 'user_id' : 'user_username';
            $data = $this->_db->query("select * from ims_iommiunderwood.users where $field = '$user'");

            // get user data from query result
            if ($data->count()){
                $this->_data = $data;
                return true;
            }
        }
        return false;
    }

    public function login($username = null, $password = null){

        $user = $this->find($username);

        if ($user){
            if ($this->data()->user_password === hash::make($password, $this->data()->user_salt)){
                echo 'ok';
            }
        }

        return false;
    }

    private function data(){
        return $this->_data;
    }

}