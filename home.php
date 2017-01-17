<?php
session_start();
include_once 'Classes/user.php';
$user = new user();
$userId = $_SESSION['userId'];
if (!$user->getSession()) {
    header("location:index.php");
}

if (isset($_GET['q'])) {
    $user->logoutUser();
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>IMS Login</title>
    <link rel='stylesheet prefetch'
          href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<a href="home.php?q=logout">LOGOUT</a><br><br>
<h1 Hello <?php $user->getFullname($userId); ?>></h1>
</body>
</html>