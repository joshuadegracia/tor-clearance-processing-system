<?php
session_start();

include 'config.php';

$con = get_db_connection();

$user = $_SESSION['user'];
$pass = $_SESSION['pass'];

if (!isset($user) && !isset($pass)) {
	header("location:adminlogin.php?authenticationrequired");
}

$row = mysqli_query(
	$con,
	"SELECT * FROM requester WHERE student_ID='$user'"
);
while ($rows = mysqli_fetch_array($row)) {
	$name = $rows['student_firstname'];
	$mtr = $rows['student_ID'];
}

if (isset($_GET['out'])) {
	session_unset();
	session_destroy();

	header("location: login.php");
}

if (isset($_POST['save'])) {
	$old = $_POST['old'];
	$new = $_POST['new'];
	$re = $_POST['re'];
	$old = md5($old);

	$qry = mysqli_query($con, "SELECT * FROM `accounts`");
	$row  = mysqli_fetch_array($qry);

	if ($new == $re && $row['password'] == $old) {
		$new = md5($new);
		$result = mysqli_query($con, "UPDATE `accounts` SET password='$new' WHERE admin_ID='$mtr'");
		header("location: ?success");
	} else {
		header("location: ?wrong");
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>User Update</title>
	<meta name="viewport" content="width = device-width, initial-scale =1">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('style4.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('style3.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('style2.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('css/bootstrap.min.css'); ?>">
	<script src="<?php echo site_url('js/jquery.min.js'); ?>"></script>
	<script src="<?php echo site_url('js/bootstrap.min.js'); ?>"></script>
	<!-- Favicon -->
	<link href="<?php echo site_url('img/logo.jpg'); ?>" rel="shortcut icon" type="image/vnd.microsoft.icon" />
</head>

<body>
	<div class="container-fluid">
		<?php include 'nav-user.php'; ?>
	</div>
	<div class="header">
		<h2 style="color: white; ">Change Password</h2>
	</div>
	<div>
		<form method="post">
			<div class="form-group">
				<label for="oldPassword">Current Password</label>
				<input type="password" class="form-control" id="oldPassword" name="old" required>
			</div>

			<div class="form-group">
				<label for="newPassword">New Password</label>
				<input type="password" class="form-control" id="newPassword" name="new" required>
			</div>

			<div class="form-group">
				<label for="rePassword">Re-type New Password</label>
				<input type="password" class="form-control" id="rePassword" name="re" required>
			</div>

			<div class="form-group text-center">
				<button type="submit" class="btn btn-success" name="save">
					Save
				</button>
			</div>

			<div class="error_msg text-center" style="margin-top:10px; color:red;">
				<?php
				if (isset($_GET['failed'])) {
					echo "The two passwords do not match!";
				}
				if (isset($_GET['success'])) {
					echo "<span style='color:green;'>Changed Successfully!</span>";
				}
				if (isset($_GET['wrong'])) {
					echo "The password you entered is incorrect!";
				}
				?>
			</div>
		</form>
	</div>
</body>

</html>