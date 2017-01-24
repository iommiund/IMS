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
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;

    public function __construct($user = null){
        $this->_db = db::getInstance();

        $this->_sessionName = config::get('session/session_name');
        $this->_cookieName = config::get('remember/cookie_name');

        if (!$user){
            if (session::exists($this->_sessionName)){
                $user = session::get($this->_sessionName);

                if ($this->find($user)){
                    $this->_isLoggedIn = true;
                } else {
                    //process logout
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function update($fields = array(), $uid = null){

        if (!$uid && $this->isLoggedIn()){
            $uid = $this->data()->uid;
        }

        if(!$this->_db->update('users', $uid, $fields)){
            throw new Exception('There was a problem updating your details');
        }
    }

    public function create($fields = array()){
        if (!$this->_db->insert('users', $fields)){
            throw new Exception('There was a problem creating entry');
        }
    }

    // check if user exists in database by selecting with id or username
    public function find($user = null){

        if ($user) {
            $field = (is_numeric($user)) ? 'uid' : 'username';
            $data = $this->_db->get('users', array($field, '=', $user));

            // get user data from query result
            if ($data->count()){

                $this->_data = $data->first();

                return true;
            }
        }
        return false;
    }

    public function login($username = null, $password = null, $remember = false){

        if(!$username && !$password && $this->exists()){

            session::put($this->_sessionName, $this->data()->uid);

        } else {
            $user = $this->find($username);

            //If data is returned check that the password+salt match password in db
            if ($user) {
                if ($this->data()->password === hash::make($password, $this->data()->salt)) {

                    //if passwords match, create session
                    session::put($this->_sessionName, $this->data()->uid);

                    if ($remember) {
                        $hash = hash::unique();
                        $hashCheck = $this->_db->get('users_session', array('uid', '=', $this->data()->uid));

                        if (!$hashCheck->count()) {
                            $this->_db->insert('users_session', array(
                                'uid' => $this->data()->uid,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        cookie::put($this->_cookieName, $hash, config::get('remember/cookie_expiry'));

                    }

                    return true;
                }
            }

            return false;

        }

        return false;
    }

    public function logout(){

        $this->_db->delete('users_session', array('uid', '=', $this->data()->uid));

        session::delete($this->_sessionName);
        cookie::delete($this->_cookieName);
    }

    public function hasPermission($key){
        //get user permissions by user_type_id
        $type = $this->_db->get('user_types', array('user_type_id', '=', $this->data()->user_type_id));

        //if user has permissions
        if ($type->count()){

            //decode permissions in array
            $permissions = json_decode($type->first()->user_permissions, true);

            //if the value of permissions is the value of the key return true
            if (isset($permissions[$key]) == true){
                return true;
            }
        }
        return false;

    }

    public function exists(){
        return (!empty($this->_data)) ? true : false;
    }

    public function data(){
        return $this->_data;
    }

    public function isLoggedIn(){
        return $this->_isLoggedIn;
    }

}