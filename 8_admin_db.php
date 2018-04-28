<?php
session_start();


include('common.php');
include('dbinfo.php');

$link = mysqli_connect($host,$username,$password,$database) or die("Error " . mysqli_error($link));

$username = name();

?>
<html>
<head>
  <!-- Mobile Specific Meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Favicon-->
  <link rel="shortcut icon" href="img/elements/fav.png">
  <!-- Author Meta -->
  <meta name="author" content="colorlib">
  <!-- Meta Description -->
  <meta name="description" content="">
  <!-- Meta Keyword -->
  <meta name="keywords" content="">
  <!-- meta character set -->
  <meta charset="UTF-8">
  <!-- Site Title -->
  <title>AtlantGFO</title>

  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">

    <!--
    CSS
    ============================================= -->
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <!-- start header Area -->
    <header id="header" id="home">
      <div class="container">
        <div class="row align-items-center justify-content-between d-flex">
          <nav id="nav-menu-container">
            <ul class="nav-menu">
              <li class="menu-active"><a href="8_admin_db.php">Home</a></li>
              <li>/</li>
              <li><a href="12_view_visitor.php">Visitors List</a></li>
              <li>/</li>
              <li><a href="13_view_owner.php">Owners List</a></li>
              <li>/</li>
              <li class="menu-has-children"><a href="">Property</a>
                <ul>
                  <li><a href="11_view_cof_pro.php">Confirmed Properties</a></li>
                  <li><a href="9_view_uncof_pro.php">Unconfirmed Properties</a></li>
                </ul>
              </li>
              <li>/</li>
              <li class="menu-has-children"><a href="">Animal& Crops</a>
                <ul>
                  <li><a href="14_approved_ac.php">Approved Animals/Crops</a></li>
                  <li><a href="15_pending_ac.php">Pending Animals/Crops</a></li>
                </ul>
              </li>
              <li>/</li>
              <li><a href="?logout">Log Out</a></li>
            </ul>
          </nav><!-- #nav-menu-container -->
        </div>
      </div>
    </header><!-- #header -->

  <!-- start banner Area -->
  <section class="banner-area relative" id="home">
    <div class="overlay overlay-bg"></div><!--overlay-bg change the blcak cover-->
    <div class="container">
      <div class="row d-flex align-items-center justify-content-center">
        <div class="about-content col-lg-12">
          <h1 class="text-white">
            Welcome!  <br> <?php echo $username ?>
          </h1>
        </div>
      </div>
    </div>
  </section><!-- End banner Area -->

  <div class="whole-wrap">
    <div class="container">
      <div class="row fullscreen d-flex align-items-center justify-content-center">
        <div class="col-lg-5  col-md-6 header-right">
          <div class="section-half">


        <a href="12_view_visitor.php" class="btn btn-default btn-lg btn-block text-center text-uppercase text-white">View Visitors List</a><br>
        <a href="13_view_owner.php" class="btn btn-default btn-lg btn-block text-center text-uppercase text-white">View Owners List</a><br>
        <a href="11_view_cof_pro.php" class="btn btn-default btn-lg btn-block text-center text-uppercase text-white">View Confirmed Properties</a><br>
        <a href="9_view_uncof_pro.php" class="btn btn-default btn-lg btn-block text-center text-uppercase text-white">View Unconfirmed Properties</a><br>
        <a href="14_approved_ac.php" class="btn btn-default btn-lg btn-block text-center text-uppercase text-white">View Approved Animals and Crops</a><br>
        <a href="15_pending_ac.php" class="btn btn-default btn-lg btn-block text-center text-uppercase text-white">View Pending Animals and Crops</a><br>
        <a href="?logout" class="btn btn-default btn-lg btn-block text-center text-uppercase text-white">Log out</a>

      </div>

    </div>
  </div>
  </div>
  </div>

  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  </p>
  </div>
  </div>
  </footer>
  <!-- End footer Area -->

  <script src="js/vendor/jquery-2.2.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="js/vendor/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="js/easing.min.js"></script>
  <script src="js/hoverIntent.js"></script>
  <script src="js/superfish.min.js"></script>
  <script src="js/jquery.ajaxchimp.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.sticky.js"></script>
  <script src="js/jquery.nice-select.min.js"></script>
  <script src="js/waypoints.min.js"></script>
  <script src="js/jquery.counterup.min.js"></script>
  <script src="js/parallax.min.js"></script>
  <script src="js/mail-script.js"></script>
  <script src="js/main.js"></script>

</body>
</html>
