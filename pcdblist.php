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
			$id = $rows['admin_ID'];
		}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Homepage</title>
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
			<a class="navbar-brand" href="<?php echo site_url('pcdhome.php?sid='.session_id()); ?>" style="color: white">&nbsp; SPCF Online TOR Request System</a>
		</div>

		<ul class="nav navbar-nav navbar-right">
			<li><a href="info.php" data-toggle="tooltip" title="Account Info"><span class="glyphicon glyphicon-user"></span> <?php echo ucwords($name) ?></a></li>
			<li><a href="update.php" data-toggle="tooltip" title="Change Password"><span style="margin-left: -30px" class="glyphicon glyphicon-cog"></span></a></li>
			<li><a href="?out"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
		</ul>
	</nav>
	</div>
	<?php 
		if (isset($_GET['out'])) {
			session_unset();
			session_destroy();

			header("location: adminlogin.php");
		}
	 ?>

			<div class="header" style="color: white">
	<h2>Program Chair Department Blacklist</h2>
</div>
<div>
<form method="post">
	<div class="input-group">
		<label>Student ID</label>
		<input type="text" name="id">
	</div>
	<div class="input-group">
		<label>Remark</label>
		<input type="text" name="remark">
	</div>
	<div class="input-group">
		<button type="submit" class="btn" name="addbtn">Add</button>
	</div>
	<div class="error_msg">	
		<?php 	
			if(isset($_GET['addfailed'])){
					die("This student already have a record!");
			}
			if(isset($_GET['invalid'])){
					die("Invalid Student ID!");
			}
		 ?>
	</div>
</form>

<?php 	
	$row2 = mysqli_query($con,
			"SELECT * FROM department WHERE department_name='Program Chair Department' ");
		while ($rows2 = mysqli_fetch_array($row2)) {
			$did = $rows2['departmentID'];
		}

	if (isset($_POST['addbtn'])) {
		$sid = $_POST['id'];
		$rem = $_POST['remark'];


		$query = "SELECT * FROM blacklist WHERE student_ID = '$sid' AND departmentID='$did'";

				$result1 = mysqli_query($con, $query) or die (mysqli_error($con));

				if (mysqli_num_rows($result1) > 0){
					header("location: pcdblist.php?addfailed");
				}else{

		$sql = "INSERT INTO blacklist (remark, student_ID, departmentID, admin_ID)
				VALUES ('$rem', '$sid', '$did', '$id')";
		$qry = mysqli_query($con, $sql);
		header("location: pcdhome.php?blist");
		}
		$query2 = "SELECT * FROM student_list WHERE student_ID = '$sid'";

				$result = mysqli_query($con, $query2) or die (mysqli_error($con));

				if (mysqli_num_rows($result) == 0){
					header("location: pcdblist.php?invalid");
				}
	}

 ?>

</body>
</html>