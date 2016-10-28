<?php

	include_once ('/Config/config.php');
	
	echo "starting install...<br><br>";
	
	//insert dbdump in the same folder as install.php (put them in a separate folder)
	if (empty(DB_PASS)) {
	$command = "C:\\xampp\\mysql\\bin\\mysql -u".DB_USER." < itsrms_iommiunderwood.sql";
	
	exec($command, $output, $return_var);
	
	$output = shell_exec($command);
		
	echo "database created";
	
	} else {
	
	$command = "C:\\xampp\\mysql\\bin\\mysql -u".DB_USER." -p".DB_PASS." < itsrms_iommiunderwood.sql";
	
	exec($command, $output, $return_var);
	
	$output = shell_exec($command);
		
	echo "database created";
	
	}

?>