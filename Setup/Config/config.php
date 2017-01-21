<?php
//defining variables
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "ims";

//connection to mysql server
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

//test connection
if (mysqli_connect_errno()) {
    die ("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
}

?>