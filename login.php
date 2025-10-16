<?php

include 'config.php';
$con = get_db_connection();

if (isset($_POST['login'])) {
	$sid = $_POST['id'];
	$pass = $_POST['password'];
	$pass = md5($pass);

	$sql = "SELECT * FROM `accounts` WHERE student_ID = '".$sid."' AND `password` = '".$pass."' AND `type` = 'user' ";
	$qry = mysqli_query($con, $sql);
	$row  = mysqli_fetch_array($qry);

	if ($row['student_ID'] == $sid && $row['password'] == $pass) {
		session_start();
		$_SESSION['user'] = $sid;
		$_SESSION['pass'] = $pass;
		header("location: home.php?redirect=user&sid" . session_id());
	} else {
		header("location:login.php?loginfailed");
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale =1">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('style4.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('style3.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('style2.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('css/bootstrap.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('css/font-awesome.min.css'); ?>">
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
				<li><a href="<?php echo site_url('index.php'); ?>"><span class="glyphicon glyphicon-home"></span> Home</a></li>
				<li><a href="<?php echo site_url('register.php'); ?>"><span class="glyphicon glyphicon-pencil"></span> Register</a></li>
			</ul>
		</nav>
	</div>

	<div class="header">
		<h2 style="color: white">Login</h2>
	</div>
	<div>
		<form method="post" action="login.php?sid=<?php echo session_id(); ?>">
			<div class="form-group">
				<label for="studentID">Student ID</label>
				<input type="text" class="form-control" id="studentID" name="id" placeholder="Enter your student ID" required>
			</div>

			<div class="form-group">
				<label for="studentPassword">Password</label>
				<input type="password" class="form-control" id="studentPassword" name="password" placeholder="Enter your password" required>
			</div>

			<div class="form-group text-center">
				<button type="submit" class="btn btn-success btn-block" name="login">
					Login
				</button>
			</div>

			<div class="text-center">
				<a href="adminlogin.php" class="text-muted">Login as admin?</a>
			</div>

			<div class="error_msg text-center text-danger" style="margin-top:15px;">
				<?php
				if (isset($_GET['loginfailed'])) {
					echo "The Username or Password you entered is incorrect!";
				}
				if (isset($_GET['authenticationrequired'])) {
					echo "You must login first!";
				}
				?>
			</div>
		</form>
	</div>

</body>

</html>