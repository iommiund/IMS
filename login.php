<?php
//print variables being inserted into database table
//echo "<pre>";
//print_r($_POST);
				
	//setting variables for user login
	if(isset($_POST['username'], $_POST['password'], $_GET['login']) && !empty($_POST['username'])){
		$username=$_POST['username'];
		$password=md5($_POST['password']);
	}		
	//connection to database
	include_once ("dbc.php");	
		
	$get=mysql_query ("SELECT user_status_id FROM users WHERE USERNAME = \"$username\"");
	
	$result=mysql_result($get,0);
						
		if ($result == 1) {
		
		$get=mysql_query ("select count(user_id) from users where username=\"$username\" and user_password=\"$password\"");
		
		$result=mysql_result($get,0);
							
			if ($result!=1) {
		  		
				header ('location: index.php?error');
				die();
				exit();
		  					
			} else {
		  					
	  			//START SESSION
	  			$_SESSION['username'] = $username;
				include_once ("header.php");
	  		}
		
		} else {
		
			header ('location: index.php?disable');
			die();
			exit();

		} 
			
?>