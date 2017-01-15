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

	$get=mysqli_query ($con,"SELECT user_status_id FROM users WHERE USERNAME = \"$username\"");
	
	$result=mysqli_fetch_assoc($get);
						
		if ($result == 1) {
		
		$get=mysqli_query ($con,"select count(user_id) from users where username=\"$username\" and user_password=\"$password\"");
		
		$result=mysqli_fetch_assoc($get);
							
			if ($result!=1) {
		  		
				header ('location: index.php?error');
				die();
		  					
			} else {
		  					
	  			//START SESSION
	  			$_SESSION['username'] = $username;
				include_once ("header.php");
	  		}
		
		} else {
		
			header ('location: index.php?disable');
			die();

		} 
			
?>