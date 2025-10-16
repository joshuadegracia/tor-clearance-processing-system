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
    "SELECT * FROM admin WHERE admin_ID='$user'"
);
while ($rows = mysqli_fetch_array($row)) {
    $name = $rows['admin_firstname'];
    $id = $rows['admin_ID'];
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
                <li><a href="info.php" data-toggle="tooltip" title="Account Info"><span class="glyphicon glyphicon-user"></span> <?php echo ucwords($name) ?></a></li>
                <li><a href="update.php" data-toggle="tooltip" title="Change Password"><span style="margin-left: -30px" class="glyphicon glyphicon-cog"></span></a></li>
                <li><a href="?out"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
        </nav>
    </div>

    <?php
    if (isset($_GET['out'])) {
        session_unset();
        session_destroy();

        header("location: adminlogin.php");
    }
    ?>

    <center>
        <table>
            <caption style="margin-top: 20px">Account Info</caption>
            <tr>
                <td>
                    <form action="" method="post">

                        <?php
                        $sql = "SELECT * FROM admin WHERE admin_ID='$id'";
                        $qry = mysqli_query($con, $sql);

                        while ($tar = mysqli_fetch_array($qry)) {
                            $ln = $tar['admin_lastname'];
                            $fn = $tar['admin_firstname'];
                            $mn = $tar['admin_middlename'];
                            $full = $ln . ", " . $fn . " " . $mn;
                            $idd = $tar['admin_ID'];
                            $dep = $tar['admin_department'];
                            $role = $tar['admin_role'];
                        }

                        ?>

                        <div class="card">
                            <h4 class="card-header" style="text-align: center; font-weight: bold; color: #4989F4">
                                Admin ID: <span style="font-size: 12pt; color: dimgray;"><?php echo ucwords($idd); ?></span>
                            </h4>
                            <h4 class="card-header" style="text-align: center; font-weight: bold; color: #4989F4">
                                Name: <span style="font-size: 12pt; color: dimgray;"><?php echo ucwords($full) ?></span>
                            </h4>
                            <h4 class="card-header" style="text-align: center; font-weight: bold; color: #4989F4">
                                Department: <span style="font-size: 12pt; color: dimgray;"><?php echo ucwords($dep) ?></span>
                            </h4>
                            <h4 class="card-header" style="text-align: center; font-weight: bold; color: #4989F4">
                                Role: <span style="font-size: 12pt; color: dimgray;"><?php echo ucwords($role) ?></span>
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