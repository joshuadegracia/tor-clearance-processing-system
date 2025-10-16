<?php 
	session_start();
	
	include 'config.php';

	$con = get_db_connection();
	
	$user = $_SESSION['user'];
	$pass = $_SESSION['pass'];

	if(!isset($user) && !isset($pass)){
		header("location:adminlogin.php?authenticationrequired");
	}

	$row = mysqli_query($con,
			"SELECT * FROM admin WHERE admin_ID='$user'");
		while ($rows = mysqli_fetch_array($row)) {
			$name = $rows['admin_firstname'];
			$mtr = $rows['admin_ID'];
		}
 ?>
 <?php 
		if (isset($_GET['out'])) {
			session_unset();
			session_destroy();

			header("location: adminlogin.php");
		}
	?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Register</title>
	<meta name="viewport" content="width = device-width, initial-scale =1">
	<link rel="stylesheet" type="text/css" href="style4.css">
	<link rel="stylesheet" type="text/css" href="style3.css">
	<link rel="stylesheet" type="text/css" href="style2.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
	<div class="container-fluid">
	<nav class="navbar navbar-inverse navbar-static-top">
		<div class="navbar-header">
			<a class="navbar-left"><img src="<?php echo site_url('img/logo.jpg'); ?>" style="width: 50px; height: 40px; margin-top: 5px; margin-left: -15px; margin-right: -15px"></a>
			<a class="navbar-brand" href="#" style="color: white">&nbsp; SPCF Online TOR Request System</a>
		</div>

		<ul class="nav navbar-nav navbar-right">
			<li><a href="info.php"><span class="glyphicon glyphicon-user"></span> <?php echo ucwords($name) ?></a></li>
			<li><a href="update.php" data-toggle="tooltip" title="Change Password"><span style="margin-left: -30px" class="glyphicon glyphicon-cog"></span></a></li>
			<li><a href="?out"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
		</ul>
	</nav>
	</div>
	<div class="header">
	<h2 style="color: white; ">Change Password</h2>
</div>
<div>
<form method="post" >
	<div class="input-group">
		<label>Current Password</label>
		<input type="password" name="old" required>
	</div>
	<div class="input-group">
		<label>New Password</label>
		<input type="password" name="new" required>
	</div>
	<div class="input-group">
		<label>Re-type New Password</label>
		<input type="password" name="re" required>
	</div>
	<div class="input-group">
		<button type="submit" class="btn btn-sucess" name="save">Save</button>
	</div>
	<div class="error_msg">	
		<?php 	
			if(isset($_GET['failed'])){
					die("The two passwords do not match!");
			}
			if(isset($_GET['success'])){
					die("Changed Successfully!");
			}
			if(isset($_GET['wrong'])){
					die("The password you entered is incorrect!");
			}
		 ?>
	</div>
</div>

<?php 
	$con = get_db_connection();

	if (isset($_POST['save'])) {
		$old = $_POST['old'];
		$new = $_POST['new'];
		$re= $_POST['re'];
		$old = md5($old);

		$qry = mysqli_query($con, "SELECT * FROM accounts");
			$row  = mysqli_fetch_array($qry);

			if ($new == $re && $row['password'] == $old) {
		 		$new = md5($new);
		 		$result = mysqli_query($con, "UPDATE accounts SET password='$new' WHERE admin_ID='$mtr'");
	 			header("location: ?success");
			}else{
				header("location: ?wrong");
			}
	}
 ?>
</body>
</html>