	<body>
		<div class="width-height">
			<div class="fixheader">
				<div class="header">
					<div class="logo">
						<h1 class="header-heading">ITS<strong>RMS</strong></h1>
						<?php				
							if (isset($_SESSION['username'])) {
								
								//CONNECTION TO DATABASE
								include_once ("dbc.php");
												
								//SELECTING FULL NAME FROM DB TO DISPLAY IN HEADER				
								$username=$_SESSION['username'];
								$query=mysqli_query ("select concat(user_name, ' ', user_surname) as 'fullName' from users where username = \"$username\"");
								$fullName = mysqli_fetch_assoc($query);
								
								echo "" . $fullName . "";							
							} else if (empty($_SESSION['username'])) {
	
								header ('location: index.php?nologin');
								die();
						
							}	
							
						?>
					</div>
					<div class="menu">
						<ul class="nav">
							<li><a href="main.php">Main</a></li>
							<li><a href="addResource.php">Add Resource</a></li>
							<li><a href="searchResource.php">Search</a></li>
							<li><a href="profile.php">Profile</a></li>
							<li><a href="help.php">Help Centre</a></li>
						</ul>
					</div>
				</div>
				<div class="nav-bar">
					<div class="logout">
						<a href="main.php?logout">Logout</a>
					</div>
				</div>
			</div>