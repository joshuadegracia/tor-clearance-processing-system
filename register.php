<?php

session_start();

include 'config.php';

$con = get_db_connection();

if (isset($_POST['regbtn'])) {
	$lname = strtoupper($_POST['last']);
	$fname = strtoupper($_POST['first']);
	$mname = strtoupper($_POST['mid']);
	$bday = $_POST['bday'];
	$cnum = $_POST['num'];
	$cors = $_POST['cors'];
	$stat = $_POST['stat'];
	$year = $_POST['year'];
	$pass = $_POST['pass'];
	$pass2 = $_POST['pass2'];
	$sid = $_POST['sid'];

	$query = "SELECT * FROM requester WHERE student_ID = '$sid'";
	$result1 = mysqli_query($con, $query) or die(mysqli_error($con));
	if (mysqli_num_rows($result1) > 0) {
		@header("location: register.php?used");
	} else {

		$sql = "SELECT * FROM student_list WHERE student_ID ='$sid' AND lastname ='$lname' AND firstname ='$fname' AND course = '$cors' ";
		$qry = mysqli_query($con, $sql) or die(mysqli_error($con));

		if (mysqli_num_rows($qry) > 0) {
			if ($pass == $pass2) {
				$pass = md5($pass);
				$sql2 = "INSERT INTO requester (date, student_lastname, student_firstname, student_middlename, birthday, contactNo, student_course, status, year_graduated_lastAttended, student_visibility, student_ID) 
		 		VALUES (NOW(), '$lname', '$fname', '$mname', '$bday', '$cnum', '$cors', '$stat', '$year', '1', '$sid')";
				$qry2 = mysqli_query($con, $sql2);

				$sql3 = "INSERT INTO accounts (`type`, `password`, `admin_ID`, `student_ID`) 
		 		VALUES ('user', '$pass', 0, '$sid')";
				$qry3 = mysqli_query($con, $sql3);

				$qry = mysqli_query($con, "SELECT * FROM accounts WHERE student_ID = '$sid' AND password = '$pass'");
				$row  = mysqli_fetch_array($qry);

				if ($row['student_ID'] == $sid && $row['password'] == $pass) {
					session_start();
					$_SESSION['user'] = $sid;
					$_SESSION['pass'] = $pass;
					header("location: home.php?success");
				}
			} else {
				header("location: register.php?loginFailed");
			}
		} else {
			header("location: register.php?invalid");
		}
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Register</title>
	<meta name="viewport" content="width = device-width, initial-scale =1">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('style4.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('style3.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('table.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('css/bootstrap.min.css'); ?>">
	<script src="<?php echo site_url('js/jquery.min.js'); ?>"></script>
	<script src="<?php echo site_url('js/bootstrap.min.js'); ?>"></script>
	<!-- Favicon -->
	<link href="<?php echo site_url('img/logo.jpg'); ?>" rel="shortcut icon" type="image/vnd.microsoft.icon" />
</head>

<body>
	<div class="container-fluid">
		<nav class="navbar navbar-inverse navbar-static-top">
			<div class="navbar-header">
				<a class="navbar-left"><img src="<?php echo site_url('img/logo.jpg'); ?>" style="width: 50px; height: 40px; margin-top: 5px; margin-left: -15px; margin-right: -15px"></a>
				<a class="navbar-brand" href="#" style="color: white">&nbsp; SPCF Online TOR Request System</a>
			</div>

			<ul class="nav navbar-nav navbar-right">
				<li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
				<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			</ul>
		</nav>
	</div>
	<center>
		<table>
			<caption>Register</caption>
			<tr>
				<td>
					<div class="col-sm-12">
						<div class="col-sm-5 col-sm-offset-1">
							<form method="post" action="" style="width: 90%; margin-left: -10%">
								<label style="color: #4B4B4B; font-size: 20pt; margin-left: -33%">Personal Info</label>
								<div class="input-group">
									<label>Student ID</label>
									<input type="number" name="sid" required>
								</div>
								<div class="input-group">
									<label>Last Name</label>
									<input type="text" name="last" placeholder="When in MVGFC" required>
								</div>
								<div class="input-group">
									<label>First Name</label>
									<input type="text" name="first" required>
								</div>
								<div class="input-group">
									<label>Middle Name</label>
									<input type="text" name="mid" placeholder="When in MVGFC">
								</div>
								<div class="input-group">
									<label>Birthday</label>
									<input style="color: dimgray" type="date" name="bday" required>
								</div>
								<div class="input-group">
									<label>Contact No.</label>
									<input type="number" name="num" placeholder="09xxxxxxxxx">
								</div>

						</div>
						<div class="col-sm-5 col-sm-offset-1">
							<form method="post" action="" style="width:90%; max-width:600px; margin:auto;">
								<h3 style="color:#4B4B4B; font-size:20pt; margin-top:20px;">Educational Info</h3>

								<div class="form-group">
									<label for="courseSelect">Course</label>
									<select class="form-control" id="courseSelect" name="cors" required>
										<option value="BSN">Bachelor of Science in Nursing</option>
										<option value="BSIT">Bachelor of Science in Information Technology</option>
										<option value="BSC">Bachelor of Science in Criminology</option>
										<option value="BSE">Bachelor of Science in Education</option>
										<option value="BSA">Bachelor of Science in Accountancy</option>
									</select>
								</div>

								<div class="form-group">
									<label for="statusSelect">Status</label>
									<select class="form-control" id="statusSelect" name="stat" required>
										<option value="Graduate">Graduate</option>
										<option value="Undergraduate">Undergraduate</option>
									</select>
								</div>

								<div class="form-group">
									<label for="yearInput">Year Graduated / Last Attended</label>
									<input type="number" class="form-control" id="yearInput" name="year" min="1965" max="2018" value="2018" required>
								</div>

								<h3 style="color:#4B4B4B; font-size:20pt; margin-top:20px;">Account Info</h3>

								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" class="form-control" id="password" name="pass" required>
								</div>

								<div class="form-group">
									<label for="confirmPassword">Confirm Password</label>
									<input type="password" class="form-control" id="confirmPassword" name="pass2" required>
								</div>

								<div class="form-group text-center">
									<button type="submit" class="btn btn-success" name="regbtn" style="margin-top:20px;">
										Register
									</button>
								</div>
							</form>
						</div>
						<div class="error_msg">
							<?php
							if (isset($_GET['invalid'])) {
								die("For MVGFC students only!");
							}
							if (isset($_GET['loginFailed'])) {
								die("The two passwords do not match!");
							}
							if (isset($_GET['used'])) {
								die("Student ID already used!");
							}
							?>
						</div>
					</div>

				</td>
			</tr>
		</table>
	</center>


</body>

</html>