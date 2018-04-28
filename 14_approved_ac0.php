<?php
session_start();


include('common.php');
include('dbinfo.php');

$link = mysqli_connect($host,$username,$password,$database) or die("Error " . mysqli_error($link));

$username = name();

$column1 = 'I_Name';
$order = 'ASC';

$sql = "SELECT I_Name, Item_Type FROM ITEM WHERE IsApproved=1;";

$newsql = $sql;

$action = @$_POST['action'];
if ($action == 'search') {
  $column2 = $_POST['tskoption'];
  $keyword = $_POST['search2'];
  if ( $keyword!=""){

    $newsql = "SELECT I_Name, Item_Type FROM ITEM WHERE IsApproved=1 AND $column2 LIKE '%$keyword%';";
  }
}

if ($action == 'sort') {
  $column1 = $_POST['sort_type'];
  $order = $_POST['sort_order'];
  $newsql = "SELECT I_Name, Item_Type FROM ITEM WHERE IsApproved=1 ORDER BY $column1 $order;";
}

if ($action == 'add') {
  $type = $_POST['tskoption2'];
  $name = $_POST['add'];
  $sql2 = "SELECT * FROM ITEM WHERE I_Name='$name';";
  $result2 = mysqli_query($link, $sql2);
  if (mysqli_fetch_row($result2)) notify("Item exists or is pending!",-1);
  else {
    $sql2 = "INSERT INTO ITEM(I_Name, IsApproved, Item_Type) VALUES('$name', 1, '$type');";
    mysqli_query($link,$sql2);
    notify("Item added!",1);
  }
}

if ($action == 'del_item') {
  if (isset($_POST['item_name'])) {
    foreach ($_POST['item_name'] as $selected) {
      $sql3 = "DELETE FROM ITEM WHERE I_Name='$selected';";
      mysqli_query($link,$sql3);
    }
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
<h3 class="mb-30 text-center">Approved Animals/Crops</h3>

<div class="progress-table-wrap">
  <div class="progress-table">
    <div class="table-head">
      <div class="half">Name</div>
      <div class="half">Type</div>
    </div>
        <form class="example" method="post">


<?php
if ($sql != $newsql) {$sql = $newsql; }
$result = mysqli_query($link, $sql);

while ($item = mysqli_fetch_row($result)) {
    $i_name = $item[0];
    $i_type=$item[1];
  ?>
    <div class="table-row">
      <tr>
        <div class="half"><input type="checkbox" name="item_name[]" value="<?php echo $i_name ?>" ><?php echo $i_name ?></div>
        <div class="half"><?php echo $i_type ?></div>
      </tr>
    </div>
<?php } ?>
</div>
</div>

      <div class="col-md-4">
      <div class="single-defination">
          <div>
            <select class="genric-btn default" name = "tskoption">
              <option selected="selected" value="I_Name">Name</option>
              <option  value="Item_Type">Type</option>
            </select>
          </div>
          <div>
            <input type="text" placeholder="Search.." name="search2" value="">
            <button class="genric-btn default" type="submit" name="action" value="search">Search Property</button>
          </div>
      </div>
      </div>

      <div class="col-md-4">
      <div class="single-defination">
          <div>
            <select class="genric-btn default" name = "sort_type">
              <option selected="selected" value="I_Name">Name</option>
              <option  value="Item_Type">Type</option>
            </select>
          </div>
          <div>
            <select class="genric-btn default" name = "sort_order">
              <option selected="selected" value="ASC">Ascending</option>
              <option  value="DESC">Descending</option>
            </select>
          </div>
          <button class="genric-btn default" type="submit" name="action" value="sort"> Sort </button>
      </div>
      </div>

      <div class="col-md-4">
      <div class="single-defination">
          <div>
            <select class="genric-btn default" name = "tskoption2">
              <option selected="selected" value="FRUIT">Fruit</option>
              <option  value="FLOWER">Flower</option>
              <option  value="VEGETABLE">Vegetable</option>
              <option  value="NUT">Nut</option>
              <option  value="ANIMAL">Animal</option>
            </select>
          </div>
          <div>
            <input type="text" placeholder="Add.." name="add" value="">
            <button class="genric-btn default" type="submit" name="action" value="add">Add Item</button>
          </div>
      </div>
      </div>

      <div class="col-md-4">
      <div class="single-defination">

          <button class="genric-btn default" type="submit" name="action" value="del_item"> Delete Select </button>
        </form>
      </div>
      </div>

      <div class="col-md-4">
      <div class="single-defination">

        <a href="8_admin_db.php" class="genric-btn default">Back</a>

      </div>
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
