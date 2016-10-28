<?php
	//defining variables
	define('DB_HOST','localhost');
	define('DB_USER','iommi');
	define('DB_PASS','P@$$w0rd87');
	define('DB_NAME','itsrms_iommiunderwood'); 
	
	//connection to mysql server
	$conn=mysql_connect(DB_HOST, DB_USER, DB_PASS) or die ("Error connecting to server: ".mysql_error());
?>