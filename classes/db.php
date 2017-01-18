<?php

/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 18/01/2017
 * Time: 20:48
 */
class db
{

    private static $_instance = null; // store db instance if initiated
    private $_pdo, //store PDO object
            $_query, //store last executed query
            $_error = false, //representing any present errors
            $_results, // stores results set
            $_count = 0; // stores count of result

    // private prevents from being called directly from other pages multiple times
    private function __construct() {
        try {
            $this->_pdo = new PDO('mysql:host='. config::get('mysql/host') . ';dbname=' . config::get('mysql/db'), config::get('mysql/username'), config::get('mysql/password'));

        } catch(PDOException $e) {
            die($e->getMessage(0)); // get error message for db connection failure
        }

    }

    public static function getInstance(){

        // If instance is not set create a new db instance (Prevents multiple connections)
        if (!isset(self::$_instance)){
            self::$_instance = new db();
        }
        //If instance is already set return instance
        return self::$_instance;
    }

    public function query($sql, $params = array()){
        $this->_error = false; // reset error value to false

        //Checking if the sql query is prepared through PDO
        if ($this->_query = $this->_pdo->prepare($sql)){

            $x = 1; // initial array position for parameter if needed

            // loop through array to run query for each
            if (count($params)){
                foreach ($params as $param){
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            //if no array execute query
            if ($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();

            } else {
                $this->_error = true;
            }
        }

        return $this; // return the current object

    }

    public function results(){
        return $this->_results;
    }

    // return error value
    public function error(){
        return $this->_error;
    }

    // gets count of rows received from query
    public function count(){
        return $this->_count;
    }
}