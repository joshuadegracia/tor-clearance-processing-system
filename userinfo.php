<?php
session_start();

include 'config.php';

$con = get_db_connection();

$user = $_SESSION['user'];
$pass = $_SESSION['pass'];

if (!isset($user) && !isset($pass)) {
    header("location:login.php?authenticationrequired");
}

$row = mysqli_query(
    $con,
    "SELECT * FROM `requester` WHERE student_ID='$user'"
);
while ($rows = mysqli_fetch_array($row)) {
    $rdate = $rows['date'];
    $id = $rows['student_ID'];
    $last = $rows['student_lastname'];
    $name = $rows['student_firstname'];
    $mid = $rows['student_middlename'];
    $cors = $rows['student_course'];
    $num = $rows['contactNo'];
    $full = $last . ", " . $name . " " . $mid;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Account Info</title>
    <meta name="viewport" content="width = device-width, initial-scale =1">
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('style4.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('table.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('css/font-awesome.min.css'); ?>">
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
    if (isset($_POST['home'])) {
        header("location: home.php");
    }
    ?>

    <?php
    if (isset($_POST['stat'])) {
        header("location: status.php");
    }
    ?>

    <?php
    if (isset($_POST['history'])) {
        header("location: history.php");
    }
    ?>

    <center>
        <table>
            <caption style="margin-top: 20px">Account Info</caption>
            <tr>
                <td>
                    <form action="" method="post">
                        <?php
                        $sql = "SELECT * FROM `requester` WHERE student_ID= '".$id."' ";
                        $qry = mysqli_query($con, $sql);

                        // initialize to avoid undefined variable notices
                        $ln = $fn = $mn = $full = $idd = $bday = $cnum = $corss = $stats = $year = '';

                        while ($tar = mysqli_fetch_array($qry)) {
                            $ln   = $tar['student_lastname'];
                            $fn   = $tar['student_firstname'];
                            $mn   = $tar['student_middlename'];
                            $full = $ln . ", " . $fn . " " . $mn;
                            $idd  = $tar['student_ID'];
                            $bday = $tar['birthday'];
                            $cnum = $tar['contactNo'];
                            $corss = $tar['student_course'];
                            $stats = $tar['status'];
                            $year  = $tar['year_graduated_lastAttended'];
                        }
                        ?>
                        <div class="panel panel-default" style="max-width:700px; margin:20px auto;">
                            <div class="panel-heading text-center" style="background:transparent; border-bottom:0;">
                                <h4 style="font-weight:bold; color:#4989F4; margin:6px 0;">
                                    Student ID: <span style="font-size:12pt; color:dimgray;"><?php echo htmlspecialchars(ucwords($idd)); ?></span>
                                </h4>
                            </div>

                            <ul class="list-group">
                                <li class="list-group-item text-center">
                                    <strong style="color:#4989F4">Name:</strong>
                                    <div style="color:dimgray; font-size:12pt;"><?php echo htmlspecialchars(ucwords($full)); ?></div>
                                </li>

                                <li class="list-group-item text-center">
                                    <strong style="color:#4989F4">Birth Date:</strong>
                                    <div style="color:dimgray; font-size:12pt;"><?php echo htmlspecialchars(ucwords($bday)); ?></div>
                                </li>

                                <li class="list-group-item text-center">
                                    <strong style="color:#4989F4">Contact Number:</strong>
                                    <div style="color:dimgray; font-size:12pt;"><?php echo htmlspecialchars(ucwords($cnum)); ?></div>
                                </li>

                                <li class="list-group-item text-center">
                                    <strong style="color:#4989F4">Course:</strong>
                                    <div style="color:dimgray; font-size:12pt;"><?php echo htmlspecialchars(ucwords($corss)); ?></div>
                                </li>

                                <li class="list-group-item text-center">
                                    <strong style="color:#4989F4">Status:</strong>
                                    <div style="color:dimgray; font-size:12pt;"><?php echo htmlspecialchars(ucwords($stats)); ?></div>
                                </li>

                                <li class="list-group-item text-center">
                                    <strong style="color:#4989F4">Year Graduated / Last Attended:</strong>
                                    <div style="color:dimgray; font-size:12pt;"><?php echo htmlspecialchars(ucwords($year)); ?></div>
                                </li>
                            </ul>
                        </div>
                    </form>

                </td>
            </tr>
        </table>
    </center>

</body>

</html>