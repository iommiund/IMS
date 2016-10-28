<?php
	include_once ("topSection.php");
?>
<?php
	//IF THE SESSION USERNAME IS EMPTY, REDIRECT TO LOGIN SCREEN
	if (empty($_SESSION['username'])) {
	
		header ('location: index.php?nologin');
		die();
		exit();

	}	
?>
			<div class="content">
				<!--<div class="container">-->
					<div id="center-form">
						<div class="center-table">
							<h1>Low in Stock:</h1>
							<table>
								<tr>
									<th>Description</th>
									<th>location</th>
									<th>Quantity</th>
								</tr>
								<?php
								
									include_once ("stockLogic.php");
									
								?>
							</table>
							<hr><br>
							<h1>Last 10 Transactions:</h1>
							<table>
								<tr>
									<th>Description</th>
									<th>Serial Number</th>
									<th>State</th>
									<th>Condition</th>
									<th>Status</th>
									<th>Owner</th>
									<th>Location</th>
									<th>Transaction Date</th>
									<th>Updated By</th>
								</tr>
								<?php
								
									include_once ("latestTransactions.php");
									
								?>
							</table>
							<hr>
							<script type="text/javascript">
								$(document).ready(function () {
								$('table tr:nth-child(odd)').addClass('alt');
								});
							</script>	
						</div>
					</div>
				<!--</div>-->
			</div>
<?php
	include_once ("bottomSection.php");
?>