<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>IMS</title>
		<link rel='stylesheet prefetch' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
		<link rel="stylesheet" href="css/style.css">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	</head>
		<?php
			session_start ();
		?>
		<?php
			if (isset($_GET['logout'])) {
			
				session_destroy ();
				header ('location: index.php');
				die();

	  		} if (isset($_GET['login'])) {
	  		
				include_once ("login.php");
			
			} else if (isset($_SESSION['username'])){ 
			
				include_once ("header.php");

			}
		?>