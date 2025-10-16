<?php include 'config.php'; ?>
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
		<form method="post" action="login.php">
			<div class="input-group">
				<label>Student ID</label>
				<input type="text" name="id">
			</div>
			<div class="input-group">
				<label>Password</label>
				<input type="password" name="password">
			</div>
			<div class="input-group">
				<button style="color: white" type="submit" class="btn" name="login">Login</button>
			</div>
			<a href="adminlogin.php">as admin?</a>
			<div class="error_msg">
				<?php
				if (isset($_GET['loginfailed'])) {
					die("The Username or Password you entered is incorrect!");
				}
				if (isset($_GET['authenticationrequired'])) {
					die("You must login first!");
				}
				?>
			</div>
		</form>
		<?php
		$con = get_db_connection();

		if (isset($_POST['login'])) {
			$sid = $_POST['id'];
			$pass = $_POST['password'];
			$pass = md5($pass);

			$qry = mysqli_query($con, "SELECT * FROM accounts WHERE student_ID = '$sid' AND password = '$pass' AND type='user'");
			$row  = mysqli_fetch_array($qry);

			if ($row['student_ID'] == $sid && $row['password'] == $pass) {
				session_start();
				$_SESSION['user'] = $sid;
				$_SESSION['pass'] = $pass;
				header("location: home.php");
			} else {
				header("location:login.php?loginfailed");
			}
		}
		?>
	</div>

</body>

</html>