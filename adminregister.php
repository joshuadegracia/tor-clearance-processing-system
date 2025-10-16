<?php include 'config.php'; ?>
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
			<a class="navbar-left"><img src="./img/logo.png" style="width: 50px; height: 40px; margin-top: 5px; margin-left: -15px; margin-right: -15px"></a>
			<a class="navbar-brand" href="#" style="color: white">&nbsp; SPCF Online TOR Request System</a>
		</div>

		<ul class="nav navbar-nav navbar-right">
			<li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
			<li><a href="adminlogin.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
		</ul>
	</nav>
	</div>
	<div class="header">
	<h2 style="color: bisque; ">Register As Admin</h2>
</div>
<div>
<form method="post" >
	<div class="input-group">
		<label>Admin ID</label>
		<input type="number" name="aid" required>
	</div>
	<div class="input-group">
		<label>Last Name</label>
		<input type="text" name="last" required>
	</div>
	<div class="input-group">
		<label>First Name</label>
		<input type="text" name="first" required>
	</div>
	<div class="input-group">
		<label>Middle Name</label>
		<input type="text" name="mid">
	</div>
	<div class="input-group">
		<label>Department</label>
		<select name="dep" required>
			<option value="Program Chair Department">Program Chair Department</option>
			<option value="Library">Library</option>
			<option value="SPS/Guidance">SPS/Guidance</option>
			<option value="Finance">Finance</option>
		</select>
	</div>
	<div class="input-group">
		<label>Role</label>
		<select name="role" required>
			<option value="Property Custodian">Property Custodian</option>
			<option value="Librarian">Librarian</option>
			<option value="Guidance Councilor">Guidance Councilor</option>
			<option value="Finance Officer">Finance Officer</option>
		</select>
	</div>
	<div class="input-group">
		<label>Password</label>
		<input type="password" name="pass" required>
	</div>
	<div class="input-group">
		<label>Confirm Password</label>
		<input type="password" name="pass2" required>
	</div>
	
	<div class="input-group">
		<button type="submit" class="btn" name="regbtn" style="color: bisque">Register</button>
	</div>
	<a href="register.php">as student?</a>
	<div class="error_msg">	
		<?php 	
			if(isset($_GET['failed'])){
					die("The two password do not match!");
			}
			if(isset($_GET['success'])){
					die("Successfully Added!");
			}
			if(isset($_GET['exist'])){
					die("Already have an account!");
			}
		 ?>
	</div>
</div>

<?php 
	$con = get_db_connection();

	if (isset($_POST['regbtn'])) {
		$aid = $_POST['aid'];
		$lname = $_POST['last'];
		$fname = $_POST['first'];
		$mname = $_POST['mid'];
		$dep = $_POST['dep'];
		$role = $_POST['role'];
		$pass = $_POST['pass'];
		$pass2 = $_POST['pass2'];

			if ($pass == $pass2) {
		 		$pass = md5($pass);
		 		$sql2 = "INSERT INTO admin (admin_ID, admin_lastname, admin_firstname, admin_middlename, admin_department, admin_role) 
		 		VALUES ('$aid','$lname', '$fname', '$mname', '$dep', '$role')";
		 		$qry2 = mysqli_query($con, $sql2);

		 		$sql3 = "INSERT INTO accounts (type, password, admin_ID) 
		 		VALUES ('admin','$pass', '$aid')";
		 		$qry3 = mysqli_query($con, $sql3);
				header("location: adminlogin.php");
			}else{
				header("location: ?failed");
			}
	}
 ?>
</body>
</html>