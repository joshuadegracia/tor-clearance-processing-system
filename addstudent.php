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
	"SELECT * FROM admin WHERE admin_ID='$user'"
);
while ($rows = mysqli_fetch_array($row)) {
	$name = $rows['admin_firstname'];
	$mtr = $rows['admin_ID'];
}

if (isset($_GET['out'])) {
	session_unset();
	session_destroy();

	header("location: adminlogin.php");
}

if (isset($_POST['addbtn'])) {
	$sid = $_POST['id'];
	$ln = strtoupper($_POST['ln']);
	$fn = strtoupper($_POST['fn']);
	$mn = strtoupper($_POST['mn']);
	$cors = $_POST['cors'];


	$query = "SELECT * FROM `student_list` WHERE student_ID = '$sid'";

	$result1 = mysqli_query($con, $query) or die(mysqli_error($con));

	if (mysqli_num_rows($result1) > 0) {
		header("location: addstudent.php?addfailed");
	} else {

		$sql = "INSERT INTO `student_list` (student_ID, lastname, firstname, middlename, course, visibility)
				VALUES ('$sid', '$ln', '$fn', '$mn', '$cors', '1')";
		$qry = mysqli_query($con, $sql);
		header("location: masterhome.php?list");
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Admin Homepage</title>
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
		<?php include 'nav-admin.php'; ?>
	</div>

	<div class="header" style="color: white">
		<h2>Add To Student List</h2>
	</div>
	<div>
		<form method="post" class="form-horizontal" role="form">
			<div class="form-group">
				<label for="id" class="control-label">Student ID</label>
				<input type="text" name="id" id="id" class="form-control input-sm" required>
			</div>

			<div class="form-group">
				<label for="ln" class="control-label">Last Name</label>
				<input type="text" name="ln" id="ln" class="form-control input-sm" required>
			</div>

			<div class="form-group">
				<label for="fn" class="control-label">First Name</label>
				<input type="text" name="fn" id="fn" class="form-control input-sm" required>
			</div>

			<div class="form-group">
				<label for="mn" class="control-label">Middle Name</label>
				<input type="text" name="mn" id="mn" class="form-control input-sm">
			</div>

			<div class="form-group">
				<label for="cors" class="control-label">Course</label>
				<select name="cors" id="cors" class="form-control input-sm" required>
					<?php
					// Example: classic SQL query (adjust table & field names to match yours)
					$query = "SELECT course_code, course_name FROM courses ORDER BY course_name ASC";
					$result = mysqli_query($con, $query);

					if ($result && mysqli_num_rows($result) > 0):
						while ($course = mysqli_fetch_assoc($result)):
					?>
							<option value="<?php echo htmlspecialchars($course['course_code']); ?>">
								<?php echo htmlspecialchars($course['course_name']); ?>
							</option>
					<?php
						endwhile;
					endif;
					?>
				</select>
			</div>

			<div class="form-group text-center">
				<button type="submit" class="btn btn-success btn-sm" name="addbtn">
					<span class="glyphicon glyphicon-plus"></span> Add
				</button>
				<a href="masterhome.php?list" class="btn btn-default btn-sm" style="margin-left: 10px;">
					<span class="glyphicon glyphicon-arrow-left"></span> Back
				</a>
			</div>

			<div class="form-group text-center">
				<?php if (isset($_GET['addfailed'])): ?>
					<div class="alert alert-danger" style="display: inline-block;">
						This student already added!
					</div>
				<?php endif; ?>
			</div>
		</form>

</body>

</html>