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
    "SELECT * FROM requester WHERE student_ID='$user'"
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
                        $sql = "SELECT * FROM requester WHERE student_ID='$id'";
                        $qry = mysqli_query($con, $sql);

                        while ($tar = mysqli_fetch_array($qry)) {
                            $ln = $tar['student_lastname'];
                            $fn = $tar['student_firstname'];
                            $mn = $tar['student_middlename'];
                            $full = $ln . ", " . $fn . " " . $mn;
                            $idd = $tar['student_ID'];
                            $bday = $tar['birthday'];
                            $cnum = $tar['contactNo'];
                            $corss = $tar['student_course'];
                            $stats = $tar['status'];
                            $year = $tar['year_graduated_lastAttended'];
                        }

                        ?>

                        <div class="card">
                            <h4 class="card-header" style="text-align: center; font-weight: bold; color: #4989F4">
                                Student ID: <span style="font-size: 12pt; color: dimgray;"><?php echo ucwords($idd); ?></span>
                            </h4>
                            <h4 class="card-header" style="text-align: center; font-weight: bold; color: #4989F4">
                                Name: <span style="font-size: 12pt; color: dimgray;"><?php echo ucwords($full) ?></span>
                            </h4>
                            <h4 class="card-header" style="text-align: center; font-weight: bold; color: #4989F4">
                                Birth Date: <span style="font-size: 12pt; color: dimgray;"><?php echo ucwords($bday) ?></span>
                            </h4>
                            <h4 class="card-header" style="text-align: center; font-weight: bold; color: #4989F4">
                                Contact Number: <span style="font-size: 12pt; color: dimgray;"><?php echo ucwords($cnum) ?></span>
                            </h4>
                            <h4 class="card-header" style="text-align: center; font-weight: bold; color: #4989F4">
                                Course: <span style="font-size: 12pt; color: dimgray;"><?php echo ucwords($corss) ?></span>
                            </h4>
                            <h4 class="card-header" style="text-align: center; font-weight: bold; color: #4989F4">
                                Status: <span style="font-size: 12pt; color: dimgray;"><?php echo ucwords($stats) ?></span>
                            </h4>
                            <h4 class="card-header" style="text-align: center; font-weight: bold; color: #4989F4">
                                Year Graduated / Last Attended: <span style="font-size: 12pt; color: dimgray;"><?php echo ucwords($year) ?></span>
                            </h4>
                        </div>

                        </div>
                    </form>
                </td>
            </tr>
        </table>
    </center>

</body>

</html>