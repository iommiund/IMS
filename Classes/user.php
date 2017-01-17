<?php
include "Setup/Config/dbc.php";

class user
{

    public $db;

    public function _construct()
    {
        $this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        IF (mysqli_connect_errno()) {
            echo "Error: Could not connect to database.";
            exit;
        }
    }

    /** Add New User */
    public function addUser($name, $surname, $email, $username, $password)
    {

        $password = md5($password);
        $select1 = "select * from users where user_username = \"$username\" or user_email = \"$email\"";

        /** checking if the username or email is available in db */
        $check = $this->db->query($select1);
        $count_row = $check->num_rows;

        /** if the username is not in db then insert to the table */
        if ($count_row == 0) {
            $insert = "insert into users set user_name = \"$name\", user_surname = \"$surname\", user_email = \"$email\", user_username = \"$username\", user_password = \"$password\", user_type_id = \"1\", user_status_id = \"1\"";

            $result = mysqli_query($this->db, $insert)
            or die (mysqli_connect_errno() . " Data not inserted");
            return $result;
        } else {
            return false;
        }
    }

    /** User Login */
    public function loginUser($username, $password)
    {

        $password = md5($password);
        $select1 = "select user_id from users where user_username = \"$username\" and user_password = \"$password\"";

        /** check user count, if 1 login */
        $result = mysqli_query($this->db, $select1);
        $user_data = mysqli_fetch_array($result);
        $count_row = $result->num_rows;

        if ($count_row == 1) {

            //establish new session
            $_SESSION['login'] = true;
            $_SESSION['userId'] = $user_data['user_id'];
            return true;
        } else {
            return false;
        }
    }

    /** Show full name */
    public function getFullname($userId)
    {
        $select2 = "select concat(user_name, ' ', user_surname) as fullname from users where user_id = \"$userId\"";
        $result = mysqli_query($this->db, $select2);
        $user_data = mysqli_fetch_array($result);
        echo $user_data['fullname'];
    }

    /** Start Session */
    public function getSession()
    {
        return $_SESSION['login'];
    }

    /** End Session */
    public function logoutUser()
    {
        $_SESSION['login'] = false;
        session_destroy();
    }
}
/** http://www.w3programmers.com/login-registration-using-oop/ */