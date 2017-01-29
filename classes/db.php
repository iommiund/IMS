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
    private function __construct()
    {
        try {
            $this->_pdo = new PDO('mysql:host=' . config::get('mysql/host') . ';dbname=' . config::get('mysql/db'), config::get('mysql/username'), config::get('mysql/password'));

        } catch (PDOException $e) {
            die($e->getMessage()); // get error message for db connection failure
        }

    }

    public static function getInstance()
    {

        // If instance is not set, create a new db instance (Prevents multiple connections)
        if (!isset(self::$_instance)) {
            self::$_instance = new db();
        }
        //If instance is already set return instance (no need to reconnect)
        return self::$_instance;
    }

    public function query($sql, $params = array())
    {
        $this->_error = false; // reset error value to false

        //Checking if the sql query is prepared through PDO
        if ($this->_query = $this->_pdo->prepare($sql)) {

            $x = 1; // initial array position for parameter if needed

            // loop through array to run query for each
            if (count($params)) {
                foreach ($params as $param) {
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

    public function action($action, $table, $where = array()){

        if (count($where) === 3) {
            $operators = array('=', '>', '<', '>=', '<=');

            $field      = $where[0];
            $operator   = $where[1];
            $value      = $where[2];

            if (in_array($operator, $operators)) {
                $sql = "{$action} from {$table} where {$field} {$operator} ?";

                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }
        return false;
    }

    public function get($table, $where){

        return $this->action('select *', $table, $where);
    }

    public function delete($table, $where){
        return $this->action('delete', $table, $where);
    }

    public function insert($table, $fields = array()){

        $keys = array_keys($fields);
        $values = null;
        $x = 1;

        foreach ($fields as $field){
            $values .= '?';
            if ($x < count($fields)){
                $values .= ', ';
            }
            $x++;
        }

        $sql = "insert into {$table} (`" . implode('`,`', $keys) . "`) values ({$values})";
        //echo $sql;
        //die();
        if (!$this->query($sql,$fields)->error()){
            return true;
        }

        return false;
    }

    public function update($table, $id, $fields){
        $set = '';
        $x = 1;

        foreach ($fields as $name => $value){
            $set .= "{$name} = ?";
            if ($x < count($fields)){
                $set .= ', ';
            }
            $x++;
        }

        $sql = "update {$table} set {$set} where uid = {$id}"; //user_id needs to be a variable

        if (!$this->query($sql, $fields)->error()){
            return true;
        }

        return false;
    }

    public function results()
    {
        return $this->_results;
    }

    public function first(){
        return $this->results()[0];
    }

    // return error value
    public function error()
    {
        return $this->_error;
    }

    // gets count of rows received from query
    public function count()
    {
        return $this->_count;
    }

}