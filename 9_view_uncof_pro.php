<?php
session_start();


include('common.php');
include('dbinfo.php');

$link = mysqli_connect($host,$username,$password,$database) or die("Error " . mysqli_error($link));

$username = name();

//default sort setting
$column1 = 'Name';
$order = 'ASC';
$_SESSION['timer']=0;
$_SESSION['timer2']=0;
$_SESSION['confirm']=false;


$sql = "SELECT Name, ID, Size_Acres, St_Address, City, ZIP, IsPublic, IsComm,Property_Type,".
" User_Name FROM PROPERTY WHERE Admin_Name IS NULL ORDER BY $column1 $order;";

$newsql = $sql;

$action = @$_POST['action'];
if ($action == 'search') {
  $column2 = $_POST['tskoption'];
  $keyword = $_POST['search2'];
  if ( $keyword!=""){

    $newsql = "SELECT Name, ID, Size_Acres, St_Address, City, ZIP, IsPublic, IsComm,Property_Type,".
" User_Name FROM PROPERTY WHERE Admin_Name IS NULL AND $column2 LIKE '%$keyword%' ORDER BY $column1 $order;";
  }
}

if ($action == 'manage') {
  if (isset($_POST['proname'])) {

    $c = count($_POST['proname']);
    if ($c >1) { notify("Cannot manage multiple properties at the same time!", -1);}
    else {
    $pname = $_POST['proname'][0];
    $_SESSION['current_manage']= $pname;
    header('location: /6_own_mag.php');
  }
  }

 }

if ($action == 'sort') {
  $column1 = $_POST['sort_type'];
  $order = $_POST['sort_order'];
  $newsql = "SELECT Name, ID, Size_Acres, St_Address, City, ZIP, IsPublic, IsComm,Property_Type,".
" User_Name FROM PROPERTY WHERE Admin_Name IS NULL ORDER BY $column1 $order;";
}

if ($action == 'search2') {
  if ($_POST['minsearch']=="" && $_POST['maxsearch']=="") {
    notify("Please claim a range!",-1);
  } else {
    $column3 = $_POST['tskoption2'];
    $newsql = "SELECT Name, ID, Size_Acres, St_Address, City, ZIP, IsPublic, IsComm,Property_Type, ".
    "User_Name FROM PROPERTY WHERE Admin_Name IS NULL GROUP BY ID HAVING ";
    if ($_POST['minsearch']!="") {
      $minvalue = (float)($_POST['minsearch']);
      $newsql = $newsql." $column3 >= $minvalue ";
  }
  if ($_POST['maxsearch']!="") {
    if ($_POST['minsearch']!="") {
      $newsql = $newsql." AND ";
    }
      $maxvalue = (float)($_POST['maxsearch']);
      $newsql = $newsql." $column3 <= $maxvalue";
  }
    $newsql = $newsql.";";
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
        <div class="container">
  <?php if (@$_SESSION['notification']): ?>
    <div class="alert alert-<?php echo $_SESSION['notification']['type'] ?>">

     <?php echo htmlentities($_SESSION['notification']['message']) ?>
    </div>
  <?php $_SESSION['notification'] = false; endif; ?>
    </div>
  <!--table start-->
  <div class="whole-wrap">
    <div class="container">
      <div class="section-top-border">
        <form class="example" method="post">

          <div class="row">
          <div class="col-md-2">
          <div class="single-defination">

              <button class="genric-btn primary radius" type="submit" name="action" value="manage">Manage</button>

          </div>
          </div>

          <div class="col-md-3">
          <div class="single-defination">
              <div>
                <select class="genric-btn default height radius" name = "tskoption">
                  <option selected="selected" value="Name">Name</option>
                  <option  value="St_Address">Address</option>
                  <option  value="City">City</option>
                  <option  value="ZIP">ZIP</option>
                  <option  value="Property_Type">Property type</option>
                </select>

                <input class="kuang_l" type="text" placeholder="Search.." name="search2" value="">
                <button class="default-btn" type="submit" name="action" value="search">→</button>
              </div>
            </div>
            </div>

            <div class="col-md-3">
            <div class="single-defination">
                <div>
                <select class="genric-btn default height radius" name = "tskoption2">
                  <option  selected="selected" value="Size_Acres">Size</option>
                </select>

                <input class="kuang" type="number" step="any" placeholder="Min" name="minsearch" value="">
                <input class="kuang" type="number" step="any" placeholder="Max" name="maxsearch" value="">
                <button class="default-btn" type="submit" name="action" value="search2">→</button>
              </div>
          </div>
          </div>
          <div class="col-md-3">
          <div class="single-defination">

                <select class="genric-btn default height radius" name = "sort_type">
                  <option selected="selected" value="Name">Name</option>
                  <option  value="Size_Acres">Size</option>
                  <option  value="User_Name">Owner</option>
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
            <div>
              <a href="9_view_uncof_pro.php" class="genric-btn primary radius" float='left'>↻</a>
            </div>
          </div>
          </div>
          <br><br><br><br>
          </div>



<h3 class="mb-30 text-center">Unconfirmed Properties</h3>
<div class="progress-table-wrap">
  <div class="progress-table">
    <div class="table-head">
      <div class="country">Name</div>
      <div class="serial">Address</div>
      <div class="serial">City</div>
      <div class="serial">Zip</div>
      <div class="serial">Size</div>
      <div class="serial">Type</div>
      <div class="serial">Public</div>
      <div class="serial">Commercial</div>
      <div class="serial">ID</div>
      <div class="serial">Owner</div>
    </div>



<?php
if ($sql != $newsql) {$sql = $newsql; }

if ($result = mysqli_query($link, $sql)) {
  while ($property_data = mysqli_fetch_row($result)) {
    $Name = $property_data[0];
    $ID = $property_data[1];
    $Size = $property_data[2];
    $addr = $property_data[3];
    $city = $property_data[4];
    $zip = $property_data[5];
    if ($property_data[6] == '1') {$isp = 'True';}
    else {$isp = 'False';}
    if ($property_data[7] == '1') {$isc = 'True';}
    else {$isc = 'False';}
    $ptype = $property_data[8];
    $uname = $property_data[9];
    ?>
    <div class="table-row">
      <tr>
      <div class="country"><input type="checkbox" name="proname[]" value="<?php echo $Name ?>"><?php echo $Name ?></div>
      <div class="serial"><?php echo $addr ?></div>
      <div class="serial"><?php echo $city ?></div>
      <div class="serial"><?php echo $zip ?></div>
      <div class="serial"><?php echo $Size ?></div>
      <div class="serial"><?php echo $ptype ?></div>
      <div class="serial"><?php echo $isp ?></div>
      <div class="serial"><?php echo $isc ?></div>
      <div class="serial"><?php echo $ID ?></div>
      <div class="serial"><?php echo $uname ?></div>
    </tr>
    </div>
<?php
}}

?>

</div>
</div>
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
