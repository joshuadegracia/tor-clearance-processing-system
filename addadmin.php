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
	<title>Add Admin Account</title>
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
	<div class="header">
		<h2 style="color: white; ">Add Admin Account</h2>
	</div>
	<div>
		<form method="post">
			<div class="form-group">
				<label for="aid">Admin ID</label>
				<input type="number" class="form-control" id="aid" name="aid" required>
			</div>

			<div class="form-group">
				<label for="last">Last Name</label>
				<input type="text" class="form-control" id="last" name="last" required>
			</div>

			<div class="form-group">
				<label for="first">First Name</label>
				<input type="text" class="form-control" id="first" name="first" required>
			</div>

			<div class="form-group">
				<label for="mid">Middle Name</label>
				<input type="text" class="form-control" id="mid" name="mid">
			</div>

			<div class="form-group">
				<label for="dep">Department</label>
				<select class="form-control" id="dep" name="dep" required>
					<option value="Program Chair Department">Program Chair Department</option>
					<option value="Library">Library</option>
					<option value="SPS/Guidance">SPS/Guidance</option>
					<option value="Finance">Finance</option>
				</select>
			</div>

			<div class="form-group">
				<label for="role">Role</label>
				<select class="form-control" id="role" name="role" required>
					<option value="Property Custodian">Property Custodian</option>
					<option value="Librarian">Librarian</option>
					<option value="Guidance Councilor">Guidance Councilor</option>
					<option value="Finance Officer">Finance Officer</option>
				</select>
			</div>

			<div class="form-group">
				<label for="pass">Password</label>
				<input type="password" class="form-control" id="pass" name="pass" required>
			</div>

			<div class="form-group">
				<label for="pass2">Confirm Password</label>
				<input type="password" class="form-control" id="pass2" name="pass2" required>
			</div>

			<div class="form-group text-center">
				<button type="submit" class="btn btn-success" name="regbtn" style="background-color:#158A43; color:bisque;">
					Add
				</button>
			</div>

			<div class="text-center" style="margin-bottom:10px;">
				<a href="<?php echo site_url('masterhome.php?dep'); ?>">Back</a>
			</div>

			<div class="error_msg text-center" style="margin-top:10px; color:red;">
				<?php
				if (isset($_GET['failed'])) {
					echo "The two password do not match!";
				}
				if (isset($_GET['success'])) {
					echo "<span style='color:green;'>Successfully Added!</span>";
				}
				if (isset($_GET['exist'])) {
					echo "Already have an account!";
				}
				?>
			</div>
		</form>
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
			// --- ADDED: check for existing admin_ID to prevent duplicate primary key error ---
			$aid_esc = mysqli_real_escape_string($con, $aid);

			$check_admin = mysqli_query($con, "SELECT admin_ID FROM admin WHERE admin_ID='$aid_esc' LIMIT 1");
			if ($check_admin && mysqli_num_rows($check_admin) > 0) {
				// admin ID already exists in admin table
				header("location: ?exist");
				exit;
			}

			$check_accounts = mysqli_query($con, "SELECT admin_ID FROM `accounts` WHERE admin_ID='$aid_esc' LIMIT 1");
			if ($check_accounts && mysqli_num_rows($check_accounts) > 0) {
				// admin ID already exists in accounts table
				header("location: ?exist");
				exit;
			}
			// --- END ADDED BLOCK ---

			$pass = md5($pass);
			$sql2 = "INSERT INTO `admin` (admin_ID, admin_lastname, admin_firstname, admin_middlename, admin_department, admin_role) 
		 		VALUES ('$aid','$lname', '$fname', '$mname', '$dep', '$role')";
			$qry2 = mysqli_query($con, $sql2);

			$sql3 = "INSERT INTO `accounts` (`type`, `password`, `admin_ID`, `student_ID`) 
		 		VALUES ('admin','$pass', '$aid', 0)";
			$qry3 = mysqli_query($con, $sql3);
			header("location: ?success");
			exit;
		} else {
			header("location: ?failed");
			exit;
		}
	}
	?>
</body>

</html>