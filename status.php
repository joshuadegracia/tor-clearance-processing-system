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
    <title>Status</title>
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
        <button class="tablink" style="color: white; margin-top: -20px; width:30%" name="history">History</button>
    </form>

    <?php
    if (isset($_POST['home'])) {
        header("location: home.php");
    }
    ?>

    <?php
    if (isset($_POST['history'])) {
        header("location: history.php");
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
            <caption style="margin-top: 20px">Clearance Status</caption>
            <tr>
                <div class='input-group'>
                    <th style='text-align: center'>
                        <label style='font-size: 25pt; color:tomato'>Department</label>
                    </th>
                </div>
            </tr>
        </table>
        <table border="solid">
            <tbody>
                <tr>
                    <td style='text-align: center'>
                        <label style='font-size: 12pt; color: blue'>Program Chair Department</label>
                    </td>


                    <td style='text-align: center'>
                        <label style='font-size: 12pt; color: blue'>Library</label>
                    </td>


                    <td style='text-align: center'>
                        <label style='font-size: 12pt; color: blue'>SPS/Guidance</label>
                    </td>


                    <td style='text-align: center'>
                        <label style='font-size: 12pt; color: blue'>Finance</label>
                    </td>


                </tr>
            </tbody>
        </table>


        <table border="solid">
            <tbody>
                <td style='text-align: center'>

                    <?php
                    $row9 = mysqli_query($con, "SELECT * FROM `department` WHERE department_name='Program Chair Department' ");
                    while ($rows9 = mysqli_fetch_array($row9)) {

                        $did = $rows9['departmentID'];

                        // $row11 = mysqli_query($con, "SELECT * FROM `blacklist` WHERE student_ID='$id' AND departmentID='$did'");
                        // $rows11 = mysqli_fetch_array($row11, MYSQLI_ASSOC);

                        $row10 = mysqli_query($con, "SELECT * FROM `clearance` WHERE student_ID='$id' AND departmentID='$did'");
                        while ($rows10 = mysqli_fetch_array($row10)) {
                            if ($rows10['clearance_status'] == "Clear") {
                                echo "<span class='glyphicon glyphicon-ok' style= 'font-size: 20pt; padding: 10px; color: limegreen'>";
                                echo "</span>";
                            }
                            if ($rows10['clearance_status'] == "Not Clear") {
                                echo "<span class='glyphicon glyphicon-remove' style= 'font-size: 20pt; padding: 10px; color: tomato'>";
                                echo "</span>";
                            }
                        }

                        /*
                        $row11 = mysqli_query($con, "SELECT * FROM `blacklist` WHERE student_ID='$id' AND departmentID='$did'");

                        if ($row11 && mysqli_num_rows($row11) > 0) {
                            while ($rows11 = mysqli_fetch_array($row11, MYSQLI_ASSOC)) {
                                echo $rows11['remark']; // ✅ fixed: use $rows11, not $row11
                            }
                        } else {
                            echo "";
                        }
                            */
                    }
                    ?>

                </td>

                <td style='text-align: center'>
                    <?php
                    $row1 = mysqli_query(
                        $con,
                        "SELECT * FROM department WHERE department_name='Library' "
                    );
                    while ($rows1 = mysqli_fetch_array($row1)) {
                        $did = $rows1['departmentID'];

                        $row3 = mysqli_query(
                            $con,
                            "SELECT * FROM clearance WHERE student_ID='$id' AND departmentID='$did'"
                        );
                        while ($rows3 = mysqli_fetch_array($row3)) {
                            if ($rows3['clearance_status'] == "Clear") {
                                echo "<span class='glyphicon glyphicon-ok' style= 'font-size: 20pt; padding: 10px; color: limegreen'>";
                                echo "</span>";
                            }
                            if ($rows3['clearance_status'] == "Not Clear") {
                                echo "<span class='glyphicon glyphicon-remove' style= 'font-size: 20pt; padding: 10px; color: tomato'>";
                                echo "</span>";
                            }
                        }
                    }
                    ?>
                </td>

                <td style='text-align: center'>
                    <?php
                    $row4 = mysqli_query(
                        $con,
                        "SELECT * FROM department WHERE department_name='SPS/Guidance' "
                    );
                    while ($rows4 = mysqli_fetch_array($row4)) {
                        $did = $rows4['departmentID'];

                        $row5 = mysqli_query(
                            $con,
                            "SELECT * FROM clearance WHERE student_ID='$id' AND departmentID='$did'"
                        );
                        while ($rows5 = mysqli_fetch_array($row5)) {
                            if ($rows5['clearance_status'] == "Clear") {
                                echo "<span class='glyphicon glyphicon-ok' style= 'font-size: 20pt; padding: 10px; color: limegreen'>";
                                echo "</span>";
                            }
                            if ($rows5['clearance_status'] == "Not Clear") {
                                echo "<span class='glyphicon glyphicon-remove' style= 'font-size: 20pt; padding: 10px; color: tomato'>";
                                echo "</span>";
                            }
                        }
                    }
                    ?>
                </td>

                <td style='text-align: center'>
                    <?php
                    $row6 = mysqli_query(
                        $con,
                        "SELECT * FROM department WHERE department_name='Finance' "
                    );
                    while ($rows6 = mysqli_fetch_array($row6)) {
                        $did = $rows6['departmentID'];

                        $row7 = mysqli_query(
                            $con,
                            "SELECT * FROM clearance WHERE student_ID='$id' AND departmentID='$did'"
                        );
                        while ($rows7 = mysqli_fetch_array($row7)) {
                            if ($rows7['clearance_status'] == "Clear") {
                                echo "<span class='glyphicon glyphicon-ok' style= 'font-size: 20pt; padding: 10px; color: limegreen'>";
                                echo "</span>";
                            }
                            if ($rows7['clearance_status'] == "Not Clear") {
                                echo "<span class='glyphicon glyphicon-remove' style= 'font-size: 20pt; padding: 10px; color: tomato'>";
                                echo "</span>";
                            }
                        }
                    }
                    ?>
                </td>


                </tr>

            </tbody>
        </table>
    </center>
</body>

</html>