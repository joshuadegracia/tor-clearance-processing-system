<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>

<head>
	<title>Admin Login</title>
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
				<li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
				<li><a href="adminregister.php"><span class="glyphicon glyphicon-pencil"></span> Register</a></li>
			</ul>
		</nav>
	</div>

	<?php
	$conn = get_db_connection();
	$sql = "SELECT department_name FROM department WHERE dep_visibility = 1 ORDER BY department_name";
	$result = mysqli_query($conn, $sql);
	$departments = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$departments[] = $row['department_name'];
	}
	mysqli_close($conn);
	?>

	<div class="header" style="color:#fff; ">
		<h2>Admin Login</h2>
	</div>
	<div>
		<form method="post">
			<div class="form-group">
				<label for="department">Department</label>
				<select class="form-control" id="department" name="dep" required>
					<option value="All">All</option>
					<?php foreach ($departments as $dep): ?>
						<option value="<?php echo htmlspecialchars($dep); ?>"><?php echo htmlspecialchars($dep); ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="form-group">
				<label for="username">Admin ID</label>
				<input type="text" class="form-control" id="username" name="username" required>
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password" required>
			</div>

			<div class="form-group text-center">
				<button type="submit" class="btn btn-success btn-block" name="login">
					Login
				</button>
			</div>

			<div class="text-center">
				<a href="login.php" class="text-muted">Login as student?</a>
			</div>

			<div class="error_msg text-center" style="margin-top:10px; color:red;">
				<?php
				if (isset($_GET['loginfailed'])) {
					echo "The Department, Username or Password you entered is incorrect!";
				}
				if (isset($_GET['authenticationrequired'])) {
					echo "You must login first!";
				}
				?>
			</div>
		</form>

		<?php
		$con = get_db_connection();

		if (isset($_POST['login'])) {
			$dep = $_POST['dep'];
			$user = $_POST['username'];
			$pass = $_POST['password'];
			$pass = md5($pass);

			$qry = mysqli_query($con, "SELECT * FROM `accounts` WHERE admin_ID = '$user' AND `password` = '$pass'");
			$row  = mysqli_fetch_array($qry);

			$qry2 = mysqli_query($con, "SELECT * FROM `admin` WHERE admin_department = '$dep'");
			$row2 = mysqli_fetch_array($qry2);

			if ($row['admin_ID'] == $user && $row2['admin_ID'] == $user && $row['password'] == $pass && $row['type'] == 'master' && $row2['admin_department'] == "All") {
				session_start();
				$_SESSION['user'] = $user;
				$_SESSION['pass'] = $pass;
				header("location: masterhome.php");
			} elseif ($row['admin_ID'] == $user && $row2['admin_ID'] == $user && $row['password'] == $pass && $row['type'] == 'admin' && $row2['admin_department'] == "Program Chair Department") {
				session_start();
				$_SESSION['user'] = $user;
				$_SESSION['pass'] = $pass;
				header("location: pcdhome.php");
			} elseif ($row['admin_ID'] == $user && $row2['admin_ID'] == $user && $row['password'] == $pass && $row['type'] == 'admin' && $row2['admin_department'] == "Library") {
				session_start();
				$_SESSION['user'] = $user;
				$_SESSION['pass'] = $pass;
				header("location: libraryhome.php");
			} elseif ($row['admin_ID'] == $user && $row2['admin_ID'] == $user && $row['password'] == $pass && $row['type'] == 'admin' && $row2['admin_department'] == "SPS/Guidance") {
				session_start();
				$_SESSION['user'] = $user;
				$_SESSION['pass'] = $pass;
				header("location: guidancehome.php");
			} elseif ($row['admin_ID'] == $user && $row2['admin_ID'] == $user && $row['password'] == $pass && $row['type'] == 'admin' && $row2['admin_department'] == "Finance") {
				session_start();
				$_SESSION['user'] = $user;
				$_SESSION['pass'] = $pass;
				header("location: financehome.php");
			} else {
				header("location: adminlogin.php?loginfailed");
			}
		}
		?>
	</div>

</body>

</html>