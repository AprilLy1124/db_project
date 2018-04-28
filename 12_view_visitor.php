<?php
session_start();


include('common.php');
include('dbinfo.php');

$link = mysqli_connect($host,$username,$password,$database) or die("Error " . mysqli_error($link));

$username = name();

//default sort setting
$column1 = 'Username';
$order = 'ASC';

$sql = "SELECT Email, Username, IFNULL(COUNT(Rating),0) AS Logged_visits from USER LEFT JOIN VISIT".
" ON Username=U_ID WHERE User_type=2 GROUP BY Username;";


$newsql = $sql;

$action = @$_POST['action'];
if ($action=='search') {
  $column2 = $_POST['tskoption'];
  $keyword = $_POST['search2'];
  if ( $keyword!=""){

    $newsql = "SELECT Email, Username, IFNULL(COUNT(Rating),0) AS Logged_visits from USER LEFT JOIN VISIT".
  " ON Username=U_ID WHERE USER.User_type=2 AND $column2 LIKE '%$keyword%' GROUP BY Username ORDER BY $column1 $order;";
  }
}

if ($action == 'sort') {
  $column1 =$_POST['sort_type'];
  $order = $_POST['sort_order'];
  $newsql = "SELECT Email, Username, IFNULL(COUNT(Rating),0) AS Logged_visits from USER LEFT JOIN VISIT".
  " ON Username=U_ID WHERE User_type=2 GROUP BY Username ORDER BY $column1 $order;";
}

if ($action == "del_vis") {
  if (isset($_POST['choose_visitor'])) {
    foreach($_POST['choose_visitor'] as $selected) {
      $sql2 = "DELETE FROM USER WHERE Username='$selected';";
      mysqli_query($link, $sql2);

    }
    notify("Visitor deleted!");
  }
}

if ($action == "del_own") {
  if (isset($_POST['choose_visitor'])) {
    foreach($_POST['choose_visitor'] as $selected) {
      $sql2 = "DELETE FROM VISIT WHERE U_ID='$selected';";
      mysqli_query($link, $sql2);

    }
    notify("Log deleted!");
  }
}

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
  </section>
  <!-- End banner Area -->
  <!--table start-->
  <div class="whole-wrap">
    <div class="container">
      <div class="section-top-border">
        <form class="example" method="post">

          <div class="row">
            <div class="col-md-3">
            <div class="single-defination">
                <button class="genric-btn primary radius" type="submit" name="action" value="del_vis"> Delete Visitor Account </button>
            </div>
            </div>

            <div class="col-md-2.5">
            <div class="single-defination">
                <button class="genric-btn primary radius" type="submit" name="action" value="del_own"> Delete Logged History </button>

            </div>
            </div>

          <div class="col-md-3">
          <div class="single-defination">
              <div>
                <select class="genric-btn default height radius" name = "tskoption">
                  <option selected="selected" value="Username">Username</option>
                  <option  value="Email">Email</option>
                </select>

                <input class="kuang_l" type="text" placeholder="Search.." name="search2" value="">
                <button class="default-btn" type="submit" name="action" value="search">→</button>
              </div>
            </div>
            </div>
            <div class="col-md-3">
            <div class="single-defination">
                <select class="genric-btn default height radius" name = "sort_type">
                  <option selected="selected" value="Username">Visit</option>
                  <option  value="Email">Email</option>
                  <option  value="Logged_visits">Logged Visits</option>
                </select>

                <select class="genric-btn default height radius" name = "sort_order">
                  <option selected="selected" value="ASC">Ascending</option>
                  <option  value="DESC">Descending</option>
                </select>

              <button class="genric-btn primary radius" type="submit" name="action" value="sort">Sort</button>
          </div>
          </div>

          <div class="col-md-1">
          <div class="single-defination">
              <a href="12_view_visitor.php" class="genric-btn primary radius" float='left'>↻</a>
          </div>
          </div>
          <br><br><br><br>
          </div>


<h3 class="mb-30 text-center">All Visitors in System</h3>

<div class="progress-table-wrap">
  <div class="progress-table">
    <div class="table-head">
      <div class="percentage">Username</div>
      <div class="percentage">Email</div>
      <div class="percentage">Logged visits</div>
    </div>

      <?php
      if ($sql != $newsql) {$sql = $newsql; }
      $result = mysqli_query($link, $sql);

      while ($visitor_data = mysqli_fetch_row($result)) {
        $name = $visitor_data[1];
        $email = $visitor_data[0];
        $visits = $visitor_data[2]; ?>
      <div class="table-row">
      <tr>
        <div class="percentage"> <input type="checkbox" name="choose_visitor[]" value="<?php echo $name ?>"><?php echo $name ?></div>
        <div class="percentage"><?php echo $email ?></div>
        <div class="percentage"><?php echo $visits ?></div>
      </tr>
      </div>

      <?php } ?>
    </form>
    <br><br><br>
    <a href="8_admin_db.php" class="genric-btn primary radius">Back</a>
</div>
</div>
</div>


<!--table finish-->
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
