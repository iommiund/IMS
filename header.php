<?php
	//IF THE SESSION USERNAME IS EMPTY, REDIRECT TO LOGIN SCREEN
	if (empty($_SESSION['username'])) {
	
		header ('location: index.php?nologin');
		die();

	}	
?>
<?php
	$username=$_SESSION['username'];
	
	include_once ("dbc.php");	

	$get=mysqli_query ($con,"SELECT user_type_id FROM users WHERE USERNAME = \"$username\"");
	
	$result=mysqli_fetch_assoc($get);
						
		if ($result == 1) {
			include_once ("header1.php");	  					
		} else if ($result == 0) {
			header ('location: index.php');
		} 
		else if ($result == 2) {
			include_once ("header2.php");
  		}
?>