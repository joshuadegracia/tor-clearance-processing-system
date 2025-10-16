<?php
session_start();

include 'config.php';

$con = get_db_connection();

$sid = $_SESSION['user'];
$pass = $_SESSION['pass'];

if (!isset($sid) && !isset($pass)) {
	header("location:login.php?authenticationrequired");
}

$row = mysqli_query(
	$con,
	"SELECT * FROM requester WHERE student_ID='$sid'"
);
while ($rows = mysqli_fetch_array($row)) {
	$rdate = $rows['date'];
	$id = $rows['student_ID'];
	$last = $rows['student_lastname'];
	$name = $rows['student_firstname'];
	$mid = $rows['student_middlename'];
	$cors = $rows['student_course'];
	$num = $rows['contactNo'];
	$bday = $rows['birthday'];
	$stats = $rows['status'];
	$yr = $rows['year_graduated_lastAttended'];
	$full = $last . ", " . $name . " " . $mid;
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Homepage</title>
	<meta name="viewport" content="width = device-width, initial-scale =1">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('style4.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('table.css'); ?>">
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
	<form method="post">
		<button class="tablink" style="color: white; margin-top: -20px; width: 35%" name="home">Home</button>
		<button class="tablink" style="color: white; margin-top: -20px; width: 35%" name="stat">Status</button>
		<button class="tablink" style="color: white; margin-top: -20px; width: 30%" name="history">History</button>
	</form>

	<?php
	if (isset($_POST['stat'])) {
		header("location: status.php?sid=" . session_id());
	}
	?>

	<?php
	if (isset($_POST['history'])) {
		header("location: history.php?sid=" . session_id());
	}
	?>

	<?php
	if (isset($_GET['out'])) {
		session_unset();
		session_destroy();

		header("location: login.php?sid=" . session_id());
	}
	?>

	<center>
		<table>
			<caption style="margin-top: 20px;">Homepage</caption>
			<tr>
				<td>

					<form method='post'>

						<div class='input-group'>
							<label style='font-size: 20pt; text-align: center'>
								St. Paul College Foundation Transcript Of Records Request System
							</label>
							<div class="error_msg" style="font-family: arial; color: red; font-size: 12px; text-align: center; font-weight: bold;">
								<?php
								if (isset($_GET['success'])) {
									die("<label style='font-size: 17pt; color: blue; text-align: center'> Thank you for using our system! :) </label><br><br> Your request has been received. Just wait the SMS notification.");
								}
								?>
							</div>
							<label style='font-size: 15pt; color: blue; margin-top: 20px'>
								<img src="./img/bg6.jpg" height="100%" width="100%">
							</label><br>


							<label style='font-size: 10pt; color: dimgray; margin-top: 30px; text-align: center'>
								Click the button below if you want to request again.
							</label><br>
							<label style='font-size: 10pt; color: tomato; text-align: center;'>
								You have 12 attempts to request.
							</label>
						</div>
						<center>
							<button id="my_button" name="again" style="background-color: #4CAF50; color: white; font-family: verdana; font-weight: bold; border: none; border-radius: 3px 3px 3px 3px; height: 40px; width: 150px; margin-top:">Request Again</button>
						</center>

					</form>
				</td>
			</tr>
		</table>
	</center>

	<?php
	if (isset($_POST['again'])) {
		$query = "SELECT * FROM requester WHERE student_ID = '$id'";

		$result1 = mysqli_query($con, $query) or die(mysqli_error($con));

		if (mysqli_num_rows($result1) > 11) {
			echo "<script>
           						$('#my_button').on('click', function(){
                				alert('You have reached the request limit. Sorry but you are not able to request again. THANK YOU!');
                				$('#my_button').attr('disabled', true);
            					});
        					</script>";
		} else {
			$sql = "INSERT INTO requester (date, student_ID, student_lastname, student_firstname, student_middlename, birthday, contactNo, student_course, status, year_graduated_lastAttended, student_visibility)
						VALUES (NOW(), '$id', '$last', '$name', '$mid', '$bday', '$num', '$cors', '$stats', '$yr', '1')";
			$qry = mysqli_query($con, $sql);
			header("location: home.php?success");
		}
	}

	?>

</body>

</html>