<?php
  session_start();
  include 'config.php';
?>
<!DOCTYPE html>
<html>

<head>
  <title>Register</title>
  <meta name="viewport" content="width=device-width, initial-scale =1">
  <link rel="stylesheet" type="text/css" href="<?php echo site_url('style4.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo site_url('style3.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo site_url('style2.css'); ?>">
  <link rel="stylesheet" href="<?php echo site_url('css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo site_url('css/font-awesome.min.css'); ?>">
  <script src="<?php echo site_url('js/jquery.min.js'); ?>"></script>
  <script src="<?php echo site_url('js/bootstrap.min.js'); ?>"></script>
  <!-- Favicon -->
  <link href="<?php echo site_url('img/logo.jpg'); ?>" rel="shortcut icon" type="image/vnd.microsoft.icon" />
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Verdana, sans-serif;
    }

    .mySlides {
      display: none;
    }

    img {
      vertical-align: middle;
    }

    .slideshow-container {
      max-width: 1000px;
      position: relative;
      margin: auto;
      margin-top: 30px;
    }

    .dot {
      height: 15px;
      width: 15px;
      margin: 0 2px;
      background-color: #bbb;
      border-radius: 50%;
      display: inline-block;
      transition: background-color 0.8s ease;
    }

    .active {
      background-color: #717171;
    }

    .fade {
      -webkit-animation-name: fade;
      -webkit-animation-duration: 1.5s;
      animation-name: fade;
      animation-duration: 1.5s;
    }

    @-webkit-keyframes fade {
      from {
        opacity: .4
      }

      to {
        opacity: 1
      }
    }

    @keyframes fade {
      from {
        opacity: .4
      }

      to {
        opacity: 1
      }
    }

    @media only screen and (max-width: 300px) {
      .text {
        font-size: 11px
      }
    }

    .column {
      float: left;
      width: 50%;
      padding: 20px;
      height: 220px;
    }

    .row:after {
      content: "";
      display: table;
      clear: both;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <nav class="navbar navbar-inverse navbar-static-top">
      <div class="navbar-header">
        <a class="navbar-left"><img src="<?php echo site_url('img/logo.jpg'); ?>" style="width: 50px; height: 40px; margin-top: 5px; margin-left: -15px; margin-right: -15px"></a>
        <a class="navbar-brand" href="<?php echo $_SERVER['PHP_SELF']; ?>?sid=<?php echo session_id(); ?>" style="color: white">&nbsp; SPCF Online TOR Request System</a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="register.php"><span class="glyphicon glyphicon-edit"></span> Register</a></li>
        <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </nav>
  </div>

  <div class="slideshow-container">

    <div class="mySlides fade">
      <img src="<?php echo site_url('img/bg1.jpg'); ?>" style="width:100%">
    </div>

    <div class="mySlides fade">
      <img src="<?php echo site_url('img/bg5.jpg'); ?>" style="width:100%">
    </div>

  </div>
  <br>

  <div style="text-align:center">
    <span class="dot"></span>
    <span class="dot"></span>
  </div>

  <script>
    var slideIndex = 0;
    showSlides();

    function showSlides() {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("dot");
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      slideIndex++;
      if (slideIndex > slides.length) {
        slideIndex = 1
      }
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex - 1].style.display = "block";
      dots[slideIndex - 1].className += " active";
      setTimeout(showSlides, 1000); // Change image every 2 seconds
    }
  </script>

  <div class="row">
    <div class="column" style=" text-align: center;">
      <h2 style="font-weight: bold;">SPCF Vision</h2>
      <p style="font-size: 12pt; padding: 10px">SPCFI is visualized as a core of distinction in the operation and production of talented, knowledgeable, and expert graduates in the region, in the Philippines.</p>
      <div>
        <p style="text-align: center; font-size: 13pt; font-weight: bold;">Tel No. 044 - 463 - 0863 | Fax No. 044 - 463 - 7738</p>
      </div>
    </div>
    <div class="column" style=" text-align: center; ">
      <h2 style="font-weight: bold;">SPCF Mission</h2>
      <p style="font-size: 12pt; padding: 10px">To produce educationally, vocationally and technologically trained graduates who will be economically productive, self-sufficient, responsible and disciplined citizens of the Philippines.</p>
      <div>
        <p style="text-align: center; font-size: 13pt"><span class="glyphicon glyphicon-envelope"></span> SPCFinc@gmail.com | : <span class="glyphicon glyphicon-thumbs-up"></span> https://www.facebook.com/spcfpaniqui</p>
      </div>
    </div>
  </div>
</body>

</html>