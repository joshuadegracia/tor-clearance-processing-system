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
    <title>History</title>
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
    if (isset($_GET['out'])) {
        session_unset();
        session_destroy();

        header("location: login.php");
    }
    ?>
    <center>
        <table>
            <caption style="margin-top: 20px">Request History</caption>
            <tr>
                <td>
                    <form action="" method="post">

                        <?php
                        if (isset($_GET['page']) == "") {
                            $_GET['page'] = 1;
                        }
                        $pageNo = $_GET['page'];
                        $pageNoIndex = ($pageNo * 3) - 3;

                        $sql = "SELECT * FROM requester WHERE student_ID='$id' order by date desc limit $pageNoIndex,3";
                        $qry = mysqli_query($con, $sql);

                        while ($tar = mysqli_fetch_array($qry)) {
                            $ln = $tar['student_lastname'];
                            $fn = $tar['student_firstname'];
                            $mn = $tar['student_middlename'];
                            $full = $ln . ", " . $fn . " " . $mn;

                        ?>

                            <div class="card">
                                <h4 class="card-header" style="text-align: center; font-weight: bold; color: red">
                                    Request Date: <span style="font-size: 12pt; color: dimgray;"><?php echo $tar['date']; ?></span>
                                </h4>
                                <h4 class="card-header" style="text-align: center;font-weight: bold;">
                                    Student ID: <span style="font-size: 12pt; color: dimgray;"><?php echo $tar['student_ID']; ?></span>
                                </h4>
                                <h4 class="card-header" style="text-align: center;  font-weight: bold;">
                                    Name: <span style="font-size: 12pt; color: dimgray;"><?php echo ucwords($full) ?></span>
                                </h4>
                                <h4 class="card-header" style="text-align: center;  font-weight: bold;">
                                    Course: <span style="font-size: 12pt; color: dimgray;"><?php echo $tar['student_course']; ?></span>
                                </h4>
                                <h4 class="card-header" style="text-align: center;  font-weight: bold;">
                                    Contact Number: <span style="font-size: 12pt; color: dimgray;"><?php echo $tar['contactNo']; ?></span>
                                </h4>
                                <br>
                            </div>




                        <?php
                        }
                        $select_row = mysqli_query($con, "SELECT * FROM requester WHERE student_ID='$id'");
                        $rows = mysqli_num_rows($select_row);
                        $rowData = ceil($rows / 3);
                        echo "Page: ";
                        for ($initial = 1; $initial <= $rowData; $initial++) {
                            echo "<a href='history.php?page=$initial'>" . $initial . "</a>" . " ";
                        }
                        ?>


                        </div>
                    </form>
                </td>
            </tr>
        </table>
    </center>

</body>

</html>