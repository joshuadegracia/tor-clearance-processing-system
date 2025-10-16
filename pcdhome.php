 <?php
	require 'vendor/autoload.php';
	include 'config.php';

	session_start();

	use SMSGatewayMe\Client\ApiClient;
	use SMSGatewayMe\Client\Configuration;
	use SMSGatewayMe\Client\Api\MessageApi;
	use SMSGatewayMe\Client\Model\SendMessageRequest;

	$config = Configuration::getDefaultConfiguration();
	$config->setApiKey('Authorization', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU0MjcwMDQ5NCwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjY0MzUyLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.7B6LgWanGsrr2tfVVRwqA0xUlncyhRE6CZOYKbf-oW0');
	$apiClient = new ApiClient($config);
	$messageClient = new MessageApi($apiClient);

	if (isset($_POST['add'])) {
		header("location: pcdblist.php");
	}


	$con = get_db_connection();

	$user = $_SESSION['user'];
	$pass = $_SESSION['pass'];

	if (!isset($user) && !isset($pass)) {
		header("location:adminlogin.php?authenticationrequired");
	}

	$row = mysqli_query(
		$con,
		"SELECT * FROM `admin` WHERE admin_ID='$user'"
	);
	while ($rows = mysqli_fetch_array($row)) {
		$name = $rows['admin_firstname'];
		$aid = $rows['admin_ID'];
	}

	if (isset($_GET['out'])) {
		session_unset();
		session_destroy();

		header("location: adminlogin.php");
	}
	?>

 <?php
	if (isset($_GET['del'])) {
		$stud = $_GET['del'];

		$row7 = mysqli_query(
			$con,
			"SELECT * FROM `department` WHERE department_name='Program Chair Department' "
		);
		while ($rows7 = mysqli_fetch_array($row7)) {
			$dep = $rows7['departmentID'];

			$row10 = "SELECT * FROM `clearance` WHERE departmentID='$dep' AND student_ID='$stud' AND admin_ID='$aid'";
			$rows10 = mysqli_query($con, $row10);

			if (mysqli_num_rows($rows10) > 0) {
				header("location: pcdhome.php?reqs");
			} else {

				$sql2 = "INSERT INTO `clearance` (clearance_status, student_ID, departmentID, admin_ID) 
	 	 			VALUES ('Not Clear', '$stud', '$dep', '$aid')";
				$qry2 = mysqli_query($con, $sql2);
				header("location: pcdhome.php?reqs");
			}
		}
	}
	?>

 <?php
	if (isset($_GET['ok'])) {
		$stud = $_GET['ok'];

		$row7 = mysqli_query(
			$con,
			"SELECT * FROM `department` WHERE department_name='Program Chair Department' "
		);
		while ($rows7 = mysqli_fetch_array($row7)) {
			$dep = $rows7['departmentID'];

			$row10 = "SELECT * FROM `clearance` WHERE `departmentID`='$dep' AND student_ID='$stud' AND admin_ID='$aid'";
			$rows10 = mysqli_query($con, $row10);

			if (mysqli_num_rows($rows10) > 0) {
				header("location: pcdhome.php?reqs");
			} else {

				$sql2 = "INSERT INTO `clearance` (clearance_status, student_ID, `departmentID`, admin_ID) 
						VALUES ('Clear', '$stud', '$dep', '$aid')";
				$qry2 = mysqli_query($con, $sql2);
				header("location: pcdhome.php?reqs");
			}
		}
	}
	?>

 <?php
	if (isset($_GET['erase'])) {
		$stud = $_GET['erase'];
		$result2 = mysqli_query($con, "DELETE FROM clearance WHERE student_ID=$stud AND admin_ID=$aid");
		header("location: pcdhome.php?reqs");
	}
	?>

 <!DOCTYPE html>
 <html>

 <head>
 	<title>Admin Homepage</title>
 	<meta name="viewport" content="width = device-width, initial-scale =1">
 	<link rel="stylesheet" type="text/css" href="style4.css">
 	<link rel="stylesheet" type="text/css" href="table.css">
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

 </head>

 <body>
 	<div class="container-fluid">
 		<nav class="navbar navbar-inverse navbar-static-top">
 			<div class="navbar-header">
 				<a class="navbar-left"><img src="<?php echo site_url('img/logo.jpg'); ?>" style="width: 50px; height: 40px; margin-top: 5px; margin-left: -15px; margin-right: -15px"></a>
 				<a class="navbar-brand" href="<?php echo site_url('pcdhome.php?sid='.session_id()); ?>" style="color: white">&nbsp; SPCF Online TOR Request System</a>
 			</div>

 			<ul class="nav navbar-nav navbar-right">
 				<li><a href="info.php" data-toggle="tooltip" title="Account Info"><span class="glyphicon glyphicon-user"></span> <?php echo ucwords($name) ?></a></li>
 				<li><a href="update.php" data-toggle="tooltip" title="Change Password"><span style="margin-left: -30px" class="glyphicon glyphicon-cog"></span></a></li>
 				<li><a href="?out"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
 			</ul>
 		</nav>
 	</div>
 	<form method="get">
 		<button class="tablink" style="color: white; margin-top: -20px; width: 50%" name="reqs">Request</button>
 		<button class="tablink" style="color: white; margin-top: -20px; width: 50%" name="blist">Blacklist</button>
 	</form>


 	<?php
		if (isset($_GET['blist'])) {
			echo "<center>
				  <table>
				  	<caption style='margin-top: 20px'> Program Chair Department Blacklist </caption>	
						
					<tr>
						<td>
							<form method='post' style = 'text-align: left; '>
								<div class='input-group'>
								<label style='font-size: 13pt; margin-left: 18px'>Add</label>
								<button type='submit' name='add' style='margin-left: 5px; background-color: #158a43; border: none; border-radius: 3px 3px 3px 3px'><span class='glyphicon glyphicon-plus'></span></button>
								<input type='text' name='searchkey' style='margin-left:750px' placeholder=' Search'>
								<button type='submit' name='submit' value='Add' style=' background-color: none; border: none; padding: 4px; margin-left: 2px'><span class='glyphicon glyphicon-search'></span></button>
								</div>
						</td>
							</form>
	
					</tr>
					<table>
						<tr>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 13pt; color: red'>Student ID</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 13pt; color: red'>Name</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 13pt; color: red'>Course</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 13pt; color: red'>Remark</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 13pt; color: blue;'>Clear</label>
								</td>
							</div>
						</tr>
					</table>
				  </table>
				  </center>";


			if (isset($_POST['submit'])) {
				$searchkey = $_POST['searchkey'];

				$sql = "SELECT * FROM blacklist WHERE admin_ID='$aid' AND student_ID LIKE '%{$searchkey}%'";

				$result = mysqli_query($con, $sql);
				if (mysqli_num_rows($result) == 0) {
					echo "<center>";
					echo "<table>";
					echo "<tr>";
					echo "<div class='input-group'>";
					echo "<td style='border-right: 2px solid #158A43; width: 100px; padding: 6px; text-align: center'>";
					echo "<label style='font-size: 13pt; color: black;'>";
					echo "No Result!";
					echo "</label>";
					echo "</td>";
					echo "</tr>";
					echo "</table>";
					echo "</center>";
				}
				while ($row5 = mysqli_fetch_array($result)) {
					echo "<center>";
					echo "<table>";
					echo "<tr>";
					echo "<div class='input-group'>";
					echo "<td style='border-right: 2px solid #158A43; width: 100px; padding: 6px; text-align: center'>";
					echo "<label style='font-size: 13pt; color: blue;'>";
					echo $row5['student_ID'];
					echo "</label>";
					echo "</td>";
					echo "</tr>";
					echo "</table>";
					echo "</center>";
				}
			}

			$row3 = mysqli_query(
				$con,
				"SELECT * FROM department WHERE department_name='Program Chair Department' "
			);
			while ($rows3 = mysqli_fetch_array($row3)) {
				$did = $rows3['departmentID'];

				$row2 = mysqli_query(
					$con,
					"SELECT * FROM blacklist WHERE departmentID='$did' AND admin_ID='$aid'"
				);
				while ($rows2 = mysqli_fetch_array($row2)) {
					$remark = $rows2['remark'];
					$sid = $rows2['student_ID'];

					$row4 = mysqli_query(
						$con,
						"SELECT * FROM student_list WHERE student_ID='$sid' "
					);
					while ($rows4 = mysqli_fetch_array($row4)) {
						$ln = $rows4['lastname'];
						$fn = $rows4['firstname'];
						$mn = $rows4['middlename'];
						$full = $ln . ", " . $fn . " " . $mn;
						$cors = $rows4['course'];


		?>

 					<center>
 						<table>
 							<tr>
 								<div class='input-group'>
 									<td style='text-align: center; border: solid 1px #158A43'>
 										<label style='font-size: 13pt; '><?php echo ucwords($sid); ?></label>
 									</td>
 								</div>
 								<div class='input-group'>
 									<td style='text-align: center; border: solid 1px #158A43'>
 										<label style='font-size: 13pt;'><?php echo ucwords($full); ?></label>
 									</td>
 								</div>
 								<div class='input-group'>
 									<td style='text-align: center; border: solid 1px #158A43'>
 										<label style='font-size: 13pt;'><?php echo ucwords($cors); ?></label>
 									</td>
 								</div>
 								<div class='input-group'>
 									<td style='text-align: center; border: solid 1px #158A43'>
 										<label style='font-size: 13pt; '><?php echo ucwords($remark); ?></label>
 									</td>
 								</div>
 								<div class='input-group'>
 									<td style='text-align: center; border: solid 1px #158A43'>
 										<a href="pcdhome.php?trash=<?php echo "$rows2[student_ID]" ?>">
 											<button type="button" name="clear" style='font-size: 15px; color: #0F0F0F; background: tomato; border: none; border-radius: 5px; width: 45px; height: 30px'>
 												<span class='glyphicon glyphicon-trash'></span>
 											</button>
 										</a>
 									</td>
 								</div>

 							</tr>
 						</table>
 					</center>

 					</center>
 	<?php
					}
				}
			}
		}
		?>

 	<?php
		if (isset($_GET['trash'])) {
			$stud2 = $_GET['trash'];
			$result2 = mysqli_query($con, "DELETE FROM blacklist WHERE student_ID=$stud2 AND admin_ID=$aid");
			header("location: pcdhome.php?blist");
		}
		?>

 	<?php
		if (isset($_GET['reqs'])) {
			echo "<center>
				  <table style='width: 90%'>
				  	<caption style='margin-top: 20px'>Request List</caption>	
						
					<table style='width: 90%'>
						<tr>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 13pt; color: orange'>Status</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 13pt; color: red'>Date</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 13pt; color: red'>Student ID</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 13pt; color: red'>Name</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 13pt; color: red'>Course</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 13pt; color: red'>Educ. Level</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 13pt; color: red'>Contact No.</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 13pt; color: green;'>Clear</label>
								</td>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 13pt; color: red;'>Not Clear</label>
								</td>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 13pt; color: black;'>Erase</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 13pt; color: blue;'>Notify</label>
								</td>
							</div>
						</tr>
					</table>
				  </table>
				  </center>";


			$row6 = mysqli_query(
				$con,
				"SELECT * FROM requester WHERE student_visibility='1' order by date asc"
			);
			while ($rows6 = mysqli_fetch_array($row6)) {
				$academic_status = $rows6['status'];
				$date = $rows6['date'];
				$id2 = $rows6['student_ID'];
				$ln2 = $rows6['student_lastname'];
				$fn2 = $rows6['student_firstname'];
				$mn2 = $rows6['student_middlename'];
				$full2 = $ln2 . ", " . $fn2 . " " . $mn2;
				$cors2 = $rows6['student_course'];
				$cnum = $rows6['contactNo'];

		?>
 			<center>
 				<table style="width: 90%">
 					<tr>
 						<div class='input-group'>
 							<td style='text-align: center; border: solid 1px #158A43'>
 								<label style='font-size: 10pt; color: dimgray'>
 									<?php
										$row8 = mysqli_query(
											$con,
											"SELECT * FROM clearance WHERE student_ID='$id2' AND admin_ID='$aid'"
										);
										while ($rows8 = mysqli_fetch_array($row8)) {

											if ($rows8['clearance_status'] == "Clear") {
												echo "<span class='glyphicon glyphicon-ok' style= 'font-size: 10pt; margin: -10px; color: limegreen'>";
												echo "</span>";
											}

											if ($rows8['clearance_status'] == "Not Clear") {
												echo "<span class='glyphicon glyphicon-remove' style= 'font-size: 10pt; margin: -10px; color: tomato'>";
												echo "</span>";
											}
										}
										?>
 								</label>
 							</td>
 						</div>
 						<div class='input-group'>
 							<td style='text-align: center; border: solid 1px #158A43'>
 								<label style='font-size: 10pt; color: dimgray'><?php echo ucwords($date); ?></label>
 							</td>
 						</div>
 						<div class='input-group'>
 							<td style='text-align: center; border: solid 1px #158A43'>
 								<label style='font-size: 10pt;'><?php echo ucwords($id2); ?></label>
 							</td>
 						</div>
 						<div class='input-group'>
 							<td style='text-align: center; border: solid 1px #158A43'>
 								<label style='font-size: 10pt;'><?php echo ucwords($full2); ?></label>
 							</td>
 						</div>
 						<div class='input-group'>
 							<td style='text-align: center; border: solid 1px #158A43'>
 								<label style='font-size: 10pt; '><?php echo ucwords($cors2); ?></label>
 							</td>
 						</div>
 						<div class='input-group'>
 							<td style='text-align: center; border: solid 1px #158A43'>
 								<label style='font-size: 10pt; '><?php echo ucwords($academic_status); ?></label>
 							</td>
 						</div>
 						<div class='input-group'>
 							<td style='text-align: center; border: solid 1px #158A43'>
 								<label style='font-size: 10pt; '><?php echo ucwords($cnum); ?></label>
 							</td>
 						</div>
 						<div class='input-group'>
 							<td style='text-align: center; border: solid 1px #158A43'>
 								<a href="pcdhome.php?ok=<?php echo "$rows6[student_ID]" ?>">
 									<button method="post" type="submit" name="clear" style='font-size: 15px; color: #0F0F0F; background: limegreen; border: none; border-radius: 5px; width: 45px; height: 30px'>
 										<span class='glyphicon glyphicon-ok'></span>
 									</button>
 								</a>
 							</td>
 						</div>
 						<div class='input-group'>
 							<td style='text-align: center; border: solid 1px #158A43'>
 								<a href="pcdhome.php?del=<?php echo "$rows6[student_ID]" ?>">
 									<button method="post" type="submit" name="clear" style='font-size: 15px; color: #0F0F0F; background: tomato; border: none; border-radius: 5px; width: 45px; height: 30px'>
 										<span class='glyphicon glyphicon-remove'></span>
 									</button>
 								</a>
 							</td>
 						</div>
 						<div class='input-group'>
 							<td style='text-align: center; border: solid 1px #158A43'>
 								<a href="pcdhome.php?erase=<?php echo "$rows6[student_ID]" ?>">
 									<button method="post" type="submit" name="clear" style='font-size: 15px; color: #0F0F0F; background: #4C8BF4; border: none; border-radius: 5px; width: 45px; height: 30px'>
 										<span class='glyphicon glyphicon-erase'></span>
 									</button>
 								</a>
 							</td>
 						</div>
 						<div class='input-group'>
 							<td style='text-align: center; border: solid 1px #158A43'>
 								<form method="post">
 									<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="<?php echo "#" . $id2; ?>" style='font-size: 15px; color: #0F0F0F; background: #FFCD42; border: none; border-radius: 5px; width: 45px; height: 30px'"> 
      								<span class='glyphicon glyphicon-envelope'></span>
   									</button>
   									</form>

   									<div class=" modal fade" id="<?php echo $id2; ?>" role="dialog">
 										<div class="modal-dialog">
 											<div class="modal-content">
 												<div class="modal-header">
 													<button type="button" class="close" data-dismiss="modal">&times;</button>
 													<h4 class="modal-title">SMS Notification</h4>
 												</div>
 												<div class="modal-body">
 													<form method="POST">
 														<label style="color: dimgray">Number: </label>
 														<input style="border-radius: 3px 3px 3px 3px; border: solid 1px #808080; " type="number" name="number" value="<?php echo $cnum; ?>"><br><br>
 														<label style="color: dimgray">Message</label><br>
 														<input style="border-radius: 3px 3px 3px 3px; border: solid 1px #808080; width: 500px; height: 200px; text-align: center; color: dimgray" type="text" name="message" value="Sorry! We cannot process your request. We found a suspicious remark on your student profile which disallowed the requested transaction. Please prepare documents such as Certificate of Registration, latest Student ID issued and/or Report of Grades and cash for financial liabilities if any, and proceed to the school registrar immediaxtely.">
 														<br><br>
 														<input type="submit" name="send" value="Send">
 													</form>

 													<?php
														if (isset($_POST['send'])) {
															$num = $_POST['number'];
															$message = $_POST['message'];

															$sendMessageRequest1 = new SendMessageRequest([
																'phoneNumber' => $num,
																'message' => $message,
																'deviceId' => 105637
															]);

															$sendMessages = $messageClient->sendMessages([$sendMessageRequest1]);
															if ($sendMessages) {
																echo "Sent!";
															}
														}
														?>
 												</div>
 											</div>
 										</div>
 						</div>
 						</td>
 						</div>

 					</tr>
 				</table>
 			</center>

 			</center>

 	<?php
			}
		}
		?>

 </body>

 </html>