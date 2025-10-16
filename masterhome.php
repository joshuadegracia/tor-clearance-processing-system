<?php
session_start();

require 'vendor/autoload.php';

use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\Model\SendMessageRequest;

$config = Configuration::getDefaultConfiguration();
$config->setApiKey('Authorization', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhZG1pbiIsImlhdCI6MTU0MjcwMDQ5NCwiZXhwIjo0MTAyNDQ0ODAwLCJ1aWQiOjY0MzUyLCJyb2xlcyI6WyJST0xFX1VTRVIiXX0.7B6LgWanGsrr2tfVVRwqA0xUlncyhRE6CZOYKbf-oW0');
$apiClient = new ApiClient($config);
$messageClient = new MessageApi($apiClient);


include 'config.php';

$con = get_db_connection();

$user = $_SESSION['user'];
$pass = $_SESSION['pass'];

if (!isset($user) && !isset($pass)) {
	header("location:adminlogin.php?authenticationrequired");
}

$row = mysqli_query(
	$con,
	"SELECT * FROM admin WHERE admin_ID='$user'"
);
while ($rows = mysqli_fetch_array($row)) {
	$name = $rows['admin_firstname'];
	$mtr = $rows['admin_ID'];
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Master Admin Homepage</title>
	<meta name="viewport" content="width = device-width, initial-scale =1">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('style4.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('table.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('css/bootstrap.min.css'); ?>">
	<script src="<?php echo site_url('js/jquery.min.js'); ?>"></script>
	<script src="<?php echo site_url('js/bootstrap.min.js'); ?>"></script>
	<!-- Favicon -->
	<link href="<?php echo site_url('img/logo.jpg'); ?>" rel="shortcut icon" type="image/vnd.microsoft.icon" />
</head>

<body>
	<div class="container-fluid">
		<?php include 'nav-admin.php'; ?>
	</div>
	<form method="get">
		<button class="tablink" style="color: white; margin-top: -20px; width: 35%" name="dep">Department</button>
		<button class="tablink" style="color: white; margin-top: -20px; width: 35%" name="req">Request</button>
		<button class="tablink" style="color: white; margin-top: -20px; width: 30%" name="list">Student List</button>
	</form>
	<?php
	if (isset($_GET['out'])) {
		session_unset();
		session_destroy();

		header("location: adminlogin.php");
	}

	if (isset($_POST['save'])) {
		$add = $_POST['add'];
		$query = "SELECT * FROM department WHERE department_name = '$add'";
		$result1 = mysqli_query($con, $query) or die(mysqli_error($con));

		if (mysqli_num_rows($result1) > 0) {
		} else {
			$sql = "INSERT INTO department (department_name, dep_visibility) VALUES ('$add', '1')";
			$qry = mysqli_query($con, $sql);
			header("location: masterhome.php?dep");
		}
	}

	if (isset($_GET['del'])) {
		$depid = $_GET['del'];
		$result2 = mysqli_query($con, "UPDATE department SET dep_visibility='0' WHERE departmentID=$depid");
		header("location: masterhome.php?dep");
	}

	if (isset($_GET['dep'])) {
		echo "<center>
				  <table>
				  	<caption style='margin-top: 20px'>Department</caption>	
					<tr>
						<td>
							<form method='post'>
								<b>Add Department:</b> <input type='text' name='add'>
								<input type='submit' name='save' value='Save' style= 'font-size: 15px; color: #ffffffff; background: #158A43; border: none; border-radius: 5px; margin-bottom: 10px'><br>
							<a href='addadmin.php' style = 'cursor: pointer; margin-left: 50px '> Add admin account</a>
							</form>
						</td>
					</tr>
				  </table>
				  </center>";



		$sql2 = "SELECT * FROM department WHERE dep_visibility='1'";
		$qry2 = mysqli_query($con, $sql2);
		while ($row2 = mysqli_fetch_array($qry2)) {
			$id = $row2['departmentID'];
	?>
			<center>
				<table>
					<tr>
						<td>
							<div class="card">
								<label class="card-header" style='float: left; font-size: 15pt'> <?php echo $row2['department_name']; ?> </label>

								<a href="masterhome.php?del=<?php echo "$row2[departmentID]" ?>">
									<button type="submit" class="btn btn-info btn-lg" data-toggle="modal" data-target="#delete" style='float: right; font-size: 15px; color: #0F0F0F; background: #DD5145; border: none; border-radius: 5px;'>
										<span class='glyphicon glyphicon-trash'></span>
									</button>
								</a>

								<form method="post">
									<input type="hidden" name="id" value="<?php echo "$row2[departmentID]" ?>">

									<button type="submit" name="ok" value="Edit" style="float: right; font-size: 15px; color: #0F0F0F; background: #FFCD43; border: none; border-radius: 5px; width: 49px; height: 39px"><span class='glyphicon glyphicon-edit'> </span></button>
									</a>
									<input type="text" name="edited" placeholder="Edit Department" style="float: right; margin: 6px; text-align: center; ">
								</form>


								<?php

								if (isset($_POST['ok'])) {
									$id = $_POST['id'];
									$edited = $_POST['edited'];

									$result = mysqli_query(
										$con,
										"UPDATE department SET department_name='$edited' WHERE departmentID=$id"
									);
									header("location: masterhome.php?dep");
								}
								?>
							</div>
						</td>
					</tr>
				</table>
			</center>

	<?php
		}
	}
	?>

	<?php
	if (isset($_POST['addstu'])) {
		header("location: addstudent.php");
	}
	?>

	<?php
	if (isset($_GET['list'])) {
		echo "<center>
				  <table>
				  	<caption style='margin-top: 20px'> Student List </caption>	
						
					<tr>
						<td>
							<form method='post' style = 'text-align: left; '>
								<div class='input-group'>
								<label style='font-size: 13pt; margin-left: 13px'>Add Student</label>
								<button type='submit' name='addstu' style='margin-left: 12px; background-color: #4A8AF4; border: none; border-radius: 2px 2px 2px 2px'><span class='glyphicon glyphicon-plus'></span></button>
								<input type='text' name='searchkey' style='margin-left:660px' placeholder=' Search'>
								<button type='submit' name='submit' style=' background-color: none; border: none; padding: 4px; margin-left: 2px'><span class='glyphicon glyphicon-search'></span></button>
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
									<label style='font-size: 13pt; color: blue;'>Edit</label>
								</td>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 13pt; color: black;'>Remove</label>
								</td>
							</div>
					</table>
				  </table>
				  </center>";

		if (isset($_POST['submit'])) {
			$searchkey = $_POST['searchkey'];

			$sql5 = "SELECT * FROM student_list WHERE student_ID LIKE '%{$searchkey}%'";

			$result4 = mysqli_query($con, $sql5);
			if (mysqli_num_rows($result4) == 0) {
				echo "<center>";
				echo "<table>";
				echo "<tr>";
				echo "<div class='input-group'>";
				echo "<td style='text-align: center'>";
				echo "<label style='font-size: 13pt; color: black;'>";
				echo "No Result!";
				echo "</label>";
				echo "</td>";
				echo "</tr>";
				echo "</table>";
				echo "</center>";
			}
			while ($rowww = mysqli_fetch_array($result4)) {
				$fn3 = $rowww['firstname'];
				$ln3 = $rowww['lastname'];
				$mn3 = $rowww['middlename'];
				$full3 = $ln3 . ", " . $fn3 . " " . $mn3;
				echo "<center>";
				echo "<table>";
				echo "<tr>";
				echo "<div class='input-group'>";
				echo "<td style='text-align: center;'>";
				echo "<label style='font-size: 13pt; color: blue;'>";
				echo $rowww['student_ID'];
				echo "</label>";
				echo "</td>";
				echo "</tr>";
				echo "</table>";
				echo "</center>";
			}
		}

		$sql4 = "SELECT * FROM student_list WHERE visibility = '1'";
		$qry4 = mysqli_query($con, $sql4);
		while ($row4 = mysqli_fetch_array($qry4)) {
			$stid = $row4['student_ID'];
			$ln =	$row4['lastname'];
			$fn =	$row4['firstname'];
			$mn =	$row4['middlename'];
			$cor =  $row4['course'];

			$fullname = $ln . ", " . $fn . " " . $mn;

	?>

			<?php
			if (isset($_POST['saave'])) {
				$sid = $_POST['sid'];
				$last = strtoupper($_POST['last']);
				$first = strtoupper($_POST['first']);
				$mid = strtoupper($_POST['mid']);
				$corss = $_POST['corss'];


				$res = mysqli_query(
					$con,
					"UPDATE student_list SET student_ID='$sid', lastname='$last', firstname='$first', middlename='$mid', course='$corss' WHERE student_ID=$stid"
				);
				header("location: masterhome.php?list");
			}
			?>

			<center>
				<table>
					<tr>
						<div class='input-group'>
							<td style='text-align: center; border: solid 1px #158A43'>
								<label style='font-size: 12pt'><?php echo $row4['student_ID']; ?></label>
							</td>
						</div>
						<div class='input-group'>
							<td style='text-align: center; border: solid 1px #158A43'>
								<label style='font-size: 12pt'><?php echo ucwords($fullname); ?></label>
							</td>
						</div>
						<div class='input-group'>
							<td style='text-align: center; border: solid 1px #158A43'>
								<label style='font-size: 12pt'><?php echo $row4['course']; ?></label>
							</td>
						</div>
						<div class='input-group'>
							<td style='text-align: center; border: solid 1px #158A43'>
								<form method="post">
									<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="<?php echo "#" . $stid; ?>" style='font-size: 15px; color: #0F0F0F; background: #FFCD42; border: none; border-radius: 5px; width: 50px; height: 40px'"> 
      								<span class='glyphicon glyphicon-edit'></span>
   									</button>
   									</form>

   									<div class=" modal fade" id="<?php echo $stid; ?>" role="dialog">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">Edit Student Info</h4>
												</div>
												<div class="modal-body">
													<form method="POST">
														<label style="color: dimgray">Student ID</label><br>
														<input style="text-align: center; color: dimgray;" type="text" name="sid" value="<?php echo $row4['student_ID']; ?>"><br><br>

														<label style="color: dimgray">Last Name</label><br>
														<input style="text-align: center; color: dimgray;" type="text" name="last" value="<?php echo $row4['lastname']; ?>"><br><br>

														<label style="color: dimgray">First Name</label><br>
														<input style="text-align: center; color: dimgray;" type="text" name="first" value="<?php echo $row4['firstname']; ?>"><br><br>

														<label style="color: dimgray">Middle Name</label><br>
														<input style="text-align: center; color: dimgray;" type="text" name="mid" value="<?php echo $row4['middlename']; ?>"><br><br>

														<label style="color: dimgray">Course</label><br>
														<select name="corss">
															<?php
															// Ensure $cor is defined to avoid notices
															$cor = isset($cor) ? $cor : '';

															$query = "SELECT DISTINCT course AS course_code, course AS course_name FROM student_list ORDER BY course ASC";
															$result = mysqli_query($con, $query);

															if ($result && mysqli_num_rows($result) > 0):
																while ($course = mysqli_fetch_assoc($result)):
																	$selected = ($course['course_code'] == $cor) ? 'selected' : '';
															?>
																	<option value="<?php echo htmlspecialchars($course['course_code']); ?>" <?php echo $selected; ?>>
																		<?php echo htmlspecialchars($course['course_name']); ?>
																	</option>
															<?php
																endwhile;
															endif;
															?>
														</select><br><br>


														<input type="submit" name="saave" value="Save">
													</form>
												</div>
											</div>
										</div>
						</div>
						</td>
						</div>
						<div class=' input-group'>
							<td style='text-align: center; border: solid 1px #158A43'>
								<a href="masterhome.php?ex=<?php echo "$row4[student_ID]" ?>">
									<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#delete" style='font-size: 15px; color: #0F0F0F; background: #DD5145; border: none; border-radius: 5px; margin-top: -3px'>
										<span class='glyphicon glyphicon-trash'></span>
									</button>
								</a>
							</td>
						</div>
				</table>
			</center>

			</center>
			</form>
	<?php
		}
	}
	?>

	<?php
	if (isset($_GET['ex'])) {
		$stid4 = $_GET['ex'];
		$res4 = mysqli_query($con, "UPDATE student_list SET visibility = '0' WHERE student_ID=$stid4");
		header("location: masterhome.php?list");
	}
	?>

	<?php
	if (isset($_GET['req'])) {
		echo "<center>
				  <table style='width: 90%'>
				  	<caption style='margin-top:20px'> Request List </caption>	
						
					<table style='width: 90%'>
						<tr>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 12pt; color: red'>Date</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 12pt; color: red'>Student ID</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 12pt; color: red'>Name</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 12pt; color: red'>Course</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 12pt; color: red'>Contact No.</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 12pt; color: orange;'>PCD</label>
								</td>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 12pt; color: orange;'>Library</label>
								</td>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 12pt; color: orange;'>Finance</label>
								</td>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 12pt; color: orange;'>Guidance</label>
								</td>
							</div>
							<div class='input-group'>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 12pt; color: blue'>Notify</label>
								</td>
								<td style='text-align: center; border: solid 1px #158A43'>
									<label style='font-size: 12pt; color: black'>Remove</label>
								</td>
							</div>
					</table>
				  </table>
				  </center>";


		$row6 = mysqli_query(
			$con,
			"SELECT * FROM requester WHERE student_visibility='1' order by date asc"
		);
		while ($rows6 = mysqli_fetch_array($row6)) {
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
								<label style='font-size: 11pt; color: dimgray'><?php echo ucwords($date); ?></label>
							</td>
						</div>
						<div class='input-group'>
							<td style='text-align: center; border: solid 1px #158A43'>
								<label style='font-size: 11pt; color: blue'><?php echo ucwords($id2); ?></label>
							</td>
						</div>
						<div class='input-group'>
							<td style='text-align: center; border: solid 1px #158A43'>
								<label style='font-size: 11pt; color: dimgray'><?php echo ucwords($full2); ?></label>
							</td>
						</div>
						<div class='input-group'>
							<td style='text-align: center; border: solid 1px #158A43'>
								<label style='font-size: 11pt; '><?php echo ucwords($cors2); ?></label>
							</td>
						</div>
						<div class='input-group'>
							<td style='text-align: center; border: solid 1px #158A43'>
								<label style='font-size: 11pt; color: dimgray'><?php echo ucwords($cnum); ?></label>
							</td>
						</div>
						<div class='input-group'>
							<td style='text-align: center; border: solid 1px #158A43'>
								<label style='font-size: 10pt;'>
									<?php
									$row8 = mysqli_query(
										$con,
										"SELECT * FROM department WHERE department_name='Program Chair Department' "
									);
									while ($rows8 = mysqli_fetch_array($row8)) {
										$did = $rows8['departmentID'];

										$row7 = mysqli_query(
											$con,
											"SELECT * FROM clearance WHERE student_ID='$id2' AND departmentID='$did'"
										);
										while ($rows7 = mysqli_fetch_array($row7)) {
											if ($rows7['clearance_status'] == "Clear") {
												echo "<span class='glyphicon glyphicon-ok' style= 'font-size: 10pt; margin: -10px; color: limegreen'>";
												echo "</span>";
											}
											if ($rows7['clearance_status'] == "Not Clear") {
												echo "<span class='glyphicon glyphicon-remove' style= 'font-size: 10pt; margin: -10px; color: tomato'>";
												echo "</span>";
											}
										}
									}
									?>
								</label>
							</td>
						</div>
						<div class='input-group'>
							<td style='text-align: center; border: solid 1px #158A43'>
								<label style='font-size: 10pt;'>
									<?php
									$row9 = mysqli_query(
										$con,
										"SELECT * FROM department WHERE department_name='Library' "
									);
									while ($rows9 = mysqli_fetch_array($row9)) {
										$did = $rows9['departmentID'];

										$row10 = mysqli_query(
											$con,
											"SELECT * FROM clearance WHERE student_ID='$id2' AND departmentID='$did'"
										);
										while ($rows10 = mysqli_fetch_array($row10)) {
											if ($rows10['clearance_status'] == "Clear") {
												echo "<span class='glyphicon glyphicon-ok' style= 'font-size: 10pt; margin: -10px; color: limegreen'>";
												echo "</span>";
											}
											if ($rows10['clearance_status'] == "Not Clear") {
												echo "<span class='glyphicon glyphicon-remove' style= 'font-size: 10pt; margin: -10px; color: tomato'>";
												echo "</span>";
											}
										}
									}
									?>
								</label>

							</td>
						</div>
						<div class='input-group'>
							<td style='text-align: center; border: solid 1px #158A43'>
								<label style='font-size: 10pt;'>
									<?php
									$row11 = mysqli_query(
										$con,
										"SELECT * FROM department WHERE department_name='Finance' "
									);
									while ($rows11 = mysqli_fetch_array($row11)) {
										$did = $rows11['departmentID'];

										$row12 = mysqli_query(
											$con,
											"SELECT * FROM clearance WHERE student_ID='$id2' AND departmentID='$did'"
										);
										while ($rows12 = mysqli_fetch_array($row12)) {
											if ($rows12['clearance_status'] == "Clear") {
												echo "<span class='glyphicon glyphicon-ok' style= 'font-size: 10pt; margin: -10px; color: limegreen'>";
												echo "</span>";
											}
											if ($rows12['clearance_status'] == "Not Clear") {
												echo "<span class='glyphicon glyphicon-remove' style= 'font-size: 10pt; margin: -10px; color: tomato'>";
												echo "</span>";
											}
										}
									}
									?>
								</label>

							</td>
						</div>
						<div class='input-group'>
							<td style='text-align: center; border: solid 1px #158A43'>
								<label style='font-size: 10pt;'>
									<?php
									$row13 = mysqli_query(
										$con,
										"SELECT * FROM department WHERE department_name='SPS/Guidance' "
									);
									while ($rows13 = mysqli_fetch_array($row13)) {
										$did = $rows13['departmentID'];

										$row14 = mysqli_query(
											$con,
											"SELECT * FROM clearance WHERE student_ID='$id2' AND departmentID='$did'"
										);
										while ($rows14 = mysqli_fetch_array($row14)) {
											if ($rows14['clearance_status'] == "Clear") {
												echo "<span class='glyphicon glyphicon-ok' style= 'font-size: 10pt; margin: -10px; color: limegreen'>";
												echo "</span>";
											}
											if ($rows14['clearance_status'] == "Not Clear") {
												echo "<span class='glyphicon glyphicon-remove' style= 'font-size: 10pt; margin: -10px; color: tomato'>";
												echo "</span>";
											}
										}
									}
									?>
								</label>

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
														<input style="border-radius: 3px 3px 3px 3px; border: solid 1px #808080; width: 500px; height: 200px; text-align: center; color: dimgray" type="text" name="message" value="THANK YOU! Your request is now on process. Allow us one month or 24 working days to complete your TOR request. Upon claiming of the completed TOR please prepare P300.00 per page for processing fee."><br><br>
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
						<div class='input-group'>
							<td style='text-align: center; border: solid 1px #158A43'>
								<a href="masterhome.php?trash=<?php echo "$rows6[student_ID]" ?>">
									<button method="post" type="submit" name="clear" style='font-size: 15px; color: #0F0F0F; background: tomato; border: none; border-radius: 5px; width: 45px; height: 30px'>
										<span class='glyphicon glyphicon-trash'></span>
									</button>
								</a>
							</td>
						</div>
					</tr>
				</table>
			</center>

			</center>
			</form>
	<?php
		}
	}
	?>

	<?php
	if (isset($_GET['trash'])) {
		$stid2 = $_GET['trash'];
		$res = mysqli_query($con, "UPDATE requester SET student_visibility='0' WHERE student_ID=$stid2");
		header("location: masterhome.php?req");
	}
	?>
</body>

</html>