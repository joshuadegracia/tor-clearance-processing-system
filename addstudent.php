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
	<title>Admin Homepage</title>
	<meta name="viewport" content="width = device-width, initial-scale =1">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('style4.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('style3.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('style2.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('css/bootstrap.min.css'); ?>">
	<script src="<?php echo site_url('js/jquery.min.js'); ?>"></script>
	<script src="<?php echo site_url('js/bootstrap.min.js'); ?>"></script>

</head>

<body>
	<div class="container-fluid">
		<?php include 'nav-admin.php'; ?>
	</div>

	<div class="header" style="color: white">
		<h2>Add To Student List</h2>
	</div>
	<div>
		<form method="post">
			<div class="input-group">
				<label>Student ID</label>
				<input type="text" name="id">
			</div>
			<div class="input-group">
				<label>Last Name</label>
				<input type="text" name="ln">
			</div>
			<div class="input-group">
				<label>First Name</label>
				<input type="text" name="fn">
			</div>
			<div class="input-group">
				<label>Middle Name</label>
				<input type="text" name="mn">
			</div>
			<div class="input-group">
				<label>Course</label>
				<select name="cors">
					<?php
					// Example: classic SQL query (adjust table & field names to match yours)
					$query = "SELECT course_code, course_name FROM courses ORDER BY course_name ASC";
					$result = mysqli_query($con, $query);

					if ($result && mysqli_num_rows($result) > 0):
						while ($course = mysqli_fetch_assoc($result)):
					?>
							<option value="<?php echo $course['course_code']; ?>">
								<?php echo $course['course_name']; ?>
							</option>
					<?php
						endwhile;
					endif;
					?>
				</select>
			</div>
			<div class="input-group">
				<button type="submit" class="btn" name="addbtn">Add</button>
			</div>
			<a href="masterhome.php?list">Back</a>
			<div class="error_msg">
				<?php
				if (isset($_GET['addfailed'])) {
					die("This student already added!");
				}
				?>
			</div>
		</form>

		<?php

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

</body>

</html>