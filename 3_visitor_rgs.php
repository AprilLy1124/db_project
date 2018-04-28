<?php
session_start();


include('common.php');
include('dbinfo.php');

$link = mysqli_connect($host,$username,$password,$database) or die("Error " . mysqli_error($link));

$action = @$_POST['action'];
if ($action == "signup") {
  $email = $_POST['email'];
  $username = $_POST['uname'];
  $pw1 = $_POST['psw'];
  $pw2 = $_POST['psw-repeat'];
  $utype=2;
  $result = register($username, $email, $pw1, $pw2, $utype, $link);
  if ($result) {
    header('location: /1_login.php');
  }
}
?>
<html>
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
<title>AtlantFGO</title>

<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">


<!-- Site Title -->
<title>AtlantGFO</title>

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

<body>
      <div class="container">
<?php if (@$_SESSION['notification']): ?>
  <div class="alert alert-<?php echo $_SESSION['notification']['type'] ?>">

   <?php echo htmlentities($_SESSION['notification']['message']) ?>
  </div>
<?php $_SESSION['notification'] = false; endif; ?>
  </div>
  <header id="header" id="home">

    <div class="container">
      <div class="row align-items-center justify-content-between d-flex">
        <nav id="nav-menu-container">
          <ul class="nav-menu">
            <li class="menu-active"><a href="1_login.php">Home</a></li>
          </ul>
        </nav><!-- #nav-menu-container -->
      </div>
    </div>
  </header><!-- #header -->

  <!-- start banner Area -->
  <section class="banner-area relative" id="home">
    <div class="overlay overlay-bg"></div>
    <div class="container">
      <div class="row fullscreen d-flex align-items-center justify-content-center">
        <div class="banner-content col-lg-7 col-md-6 ">
          <h1 class="text-white text-uppercase">
            Atlanta Gardens, Farms and Orchards
          </h1>
          <p class="pt-20 pb-20 text-white">
            Search farm system in Atlanta!
          </p>
        </div>
        <div class="col-lg-5  col-md-6 header-right">
          <h4 class="text-white pb-30">New Visitor Register</h4>
            <div class="container">
              <form class="form" role="form" autocomplete="off" method="post">
              <label for="email"><b>Email*</b></label>
              <input class="form-control txt-field" type="email" placeholder="Enter Email" name="email" value="" pattern="[a-zA-Z0-9]+@+[a-zA-Z0-9]+\.[a-zA-Z0-9]" required>

              <label for="uname"><b>Username*</b></label>
              <input class="form-control txt-field" type="text" placeholder="Enter Username" name="uname" value="" required>

              <label for="psw"><b>Password*</b></label>
              <input class="form-control txt-field" type="password" placeholder="Enter Password" pattern=".{8,}" name="psw" value="" required>

              <label for="psw-repeat"><b>Confirm Password*</b></label>
              <input class="form-control txt-field" type="password" placeholder="Confirm Password" pattern=".{8,}" name="psw-repeat" value="" required>

              <label>
                <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
              </label>

                <button class="btn btn-default btn-lg btn-block text-center text-uppercase" type="submit" class="signupbtn" name="action" value="signup">Sign Up</button><br>
          </form>
              <a href="1_login.php" class="btn btn-default btn-gr btn-block text-center text-uppercase text-white">Cancel</a>
        </div>
        </div>
      </div>
    </div>
  </section>
<!-- End banner Area -->
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
