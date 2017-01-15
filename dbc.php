<?php
		
	//INCLUDING CONFIG.PHP
	include_once ('/Setup/Config/config.php');
		
	//selecting database					
	mysqli_select_db($con,$dbname) or die ("Error connecting to database on mysql server: ".mysqli_error($con));

?>