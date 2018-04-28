<?php
session_start();


include('common.php');
include('dbinfo.php');

$link = mysqli_connect($host,$username,$password,$database) or die("Error " . mysqli_error($link));
$username = name();

$getasql = "SELECT I_Name FROM ITEM WHERE IsApproved=1 AND Item_Type='ANIMAL'";
$getaresult = mysqli_query ($link, $getasql);

$fruitsql = "SELECT I_Name FROM ITEM WHERE IsApproved=1 AND Item_Type='FRUIT'";
$fruitresult = mysqli_query ($link, $fruitsql);
$flowersql = "SELECT I_Name FROM ITEM WHERE IsApproved=1 AND Item_Type='FLOWER'";
$flowerresult = mysqli_query ($link, $flowersql);
$nutsql = "SELECT I_Name FROM ITEM WHERE IsApproved=1 AND Item_Type='NUT'";
$nutresult = mysqli_query ($link, $nutsql);
$vegesql = "SELECT I_Name FROM ITEM WHERE IsApproved=1 AND Item_Type='VEGETABLE'";
$vegeresult = mysqli_query ($link, $vegesql);

$action = @$_POST['action'];
if ($action == "addp") {
  $pname = $_POST['property'];
  $paddr = $_POST['add'];
  $pcity = $_POST['city'];
  $pzip = $_POST['zip'];
  $psize = (float)($_POST['arces']);
  $ptype = $_POST['p_type_option'];
  $utype = 1;
  $isp = (int)($_POST['isp_option']);
  $isc = (int)($_POST['isc_option']);

  $sql = "SELECT * FROM PROPERTY WHERE Name='$pname'; ";
  $result = mysqli_query ($link, $sql);
  if (!mysqli_fetch_row($result)) {
    $sql = "INSERT INTO PROPERTY (Name, Size_Acres, St_Address, City, ZIP, IsPublic, IsComm, ".
    "User_Name, Admin_Name, Property_Type) VALUES('$pname', $psize, '$paddr', '$pcity', '$pzip',".
    " $isp, $isc, '$username', NULL, '$ptype');";
    $result = mysqli_query ($link, $sql);
    //get automatically assign property id
    $sql = "SELECT ID FROM PROPERTY WHERE Name='$pname';";
    $result = mysqli_query ($link, $sql);
    $pid = mysqli_fetch_row($result)[0];

    if ($ptype=="FARM") {
      $atype = $_POST['a_type_option'];
      $ctype = $_POST['gc_type_option'];
      $sql = "INSERT INTO PROPERTY_HAS_ITEM(P_ID, I_Name) VALUES($pid, '$atype');";
      mysqli_query ($link, $sql);
      $sql = "INSERT INTO PROPERTY_HAS_ITEM(P_ID, I_Name) VALUES($pid, '$ctype');";
      mysqli_query ($link, $sql);
    } elseif ($ptype == "GARDEN") {
      $ctype = $_POST['gc_type_option'];
      $sql = "INSERT INTO PROPERTY_HAS_ITEM(P_ID, I_Name) VALUES($pid, '$ctype');";
      mysqli_query ($link, $sql);
    } else {
      $ctype = $_POST['oc_type_option'];
      $sql = "INSERT INTO PROPERTY_HAS_ITEM(P_ID, I_Name) VALUES($pid, '$ctype');";
      mysqli_query ($link, $sql);
    }

    notify('Property '.$pname." added!", 1);
    header('location: /4_owner_db.php');


  } else {
    echo "Property exists!";
  }

}

if($action=="cancel") {
  header('location: /4_owner_db.php');
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
              <li class="menu-active"><a href="4_owner_db.php">Home</a></li>
              <li>/</li>
              <li><a href="7_owner_add_pro.php">Add Property</a></li>
              <li>/</li>
              <li><a href="5_view_other.php">View Other Properties</a></li>
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
      <div class="row d-flex align-items-center justify-content-center">
        <div class="col-lg-8  col-md-9 header-right">
          <div class="section-half">
            <h3 class="mb-30 text-center">Add New Property</h3>
            <p class= text-center>Please fill in this form to create a property.</p>

            <form method="post">
              <div class="row">
              <div class="col-md-6">
              <div class="single-defination">
                <label for="property"><b>Property Name*</b></label>
                <input class="form-control txt-field" type="text" placeholder="Property Name" name="property" value="" required>

                <label for="add"><b>Street Address*</b></label>
                <input class="form-control txt-field" type="text" placeholder="Street Address" name="add" value="" required>

                <label for="city"><b>City*</b></label>
                <input class="form-control txt-field" type="text" placeholder="City" name="city" value="" required>

                <label for="zip"><b>Zip*</b></label>
                <input class="form-control txt-field" type="text" pattern="[0-9]{5}" placeholder="Zipcode" name="zip" value="" required>

                <label for="acres"><b>Arces*</b></label>
                <input class="form-control txt-field" type="number" step="any" placeholder="Arces" name="arces" value="" required>
              </div>
            </div>

            <div class="col-md-6">
            <div class="single-defination">
                      <label for="pro_type"><b>Property Type*</b></label>
                      <select class="form-right txt-field" name="p_type_option">
                        <option value="FARM">Farm</option>
                        <option value="GARDEN">Garden</option>
                        <option value="ORCHARD">Orchard</option>
                      </select>

                      <label for="animal"><b>Animal*</b></label>
                <select name="a_type_option" class="form-right txt-field">
                  <?php while($atype = mysqli_fetch_row($getaresult)) {
                    ?>
                  <option value="<?php echo $atype[0]?>"> <?php echo $atype[0]?> </option>
                  <?php
                    }
                  ?>
                </select>

                <label for="fcrop"><b>Farm Crop*</b></label>
                <select name="fc_type_option" class="form-right txt-field">
        <?php while($fruittype = mysqli_fetch_row($fruitresult)) {
          ?>
        <option value="<?php echo $fruittype[0]?>"> <?php echo $fruittype[0]?> </option>
        <?php
          }
        ?>
        <?php while($flowertype = mysqli_fetch_row($flowerresult)) {
          ?>
        <option value="<?php echo $flowertype[0]?>"> <?php echo $flowertype[0]?> </option>
        <?php
          }
        ?>
        <?php while($nuttype = mysqli_fetch_row($nutresult)) {
          ?>
        <option value="<?php echo $nuttype[0]?>"> <?php echo $nuttype[0]?> </option>
        <?php
          }
        ?>
        <?php while($vegetype = mysqli_fetch_row($vegeresult)) {
          ?>
        <option value="<?php echo $vegetype[0]?>"> <?php echo $vegetype[0]?> </option>
        <?php
          }
        ?>
      </select>


      <label for="gcrop"><b>Garden Crop*</b></label>
      <select name="gc_type_option" class="form-right txt-field">

        <?php $flowerresult = mysqli_query ($link, $flowersql);
        while($flowertype = mysqli_fetch_row($flowerresult)) {
          ?>
        <option value="<?php echo $flowertype[0]?>"> <?php echo $flowertype[0]?> </option>
        <?php
          }
        ?>
       <?php $vegeresult = mysqli_query ($link, $vegesql);
       while($vegetype = mysqli_fetch_row($vegeresult)) {
          ?>
        <option value="<?php echo $vegetype[0]?>"> <?php echo $vegetype[0]?> </option>
        <?php
          }
        ?>
      </select>

      <label for="ocrop"><b>Orchard Crop*</b></label>
      <select name="oc_type_option" class="form-right txt-field">
        <?php $fruitresult = mysqli_query ($link, $fruitsql);
        while($fruittype = mysqli_fetch_row($fruitresult)) {
          ?>
        <option value="<?php echo $fruittype[0]?>"> <?php echo $fruittype[0]?> </option>
        <?php
          }
        ?>
        <?php $nutresult = mysqli_query ($link, $nutsql);
        while($nuttype = mysqli_fetch_row($nutresult)) {
          ?>
        <option value="<?php echo $nuttype[0]?>"> <?php echo $nuttype[0]?> </option>
        <?php
          }
        ?>

      </select>
    </div>
  </div>
  </div>
  <div class="row">
  <div class="col-md-6">
    <div class="single-defination">
            <label for="public"><b>Public*</b></label>
      <select name="isp_option" class="form-right txt-field">
        <option value="1">Yes</option>
        <option value="0">No</option>
      </select>
</div>
</div>
  <div class="col-md-6">
<div class="single-defination">
      <label for="commercial"><b>Commercial*</b></label>
      <select name="isc_option" class="form-right txt-field">
        <option value="1">Yes</option>
        <option value="0">No</option>
      </select>
    </div>
    </div>

  </div>          <br>
              <button class="btn btn-default btn-lg btn-block text-center text-uppercase text-white" type="submit" class="signupbtn" name="action" value="addp">Add Property</button><br>


        </form>

        <a href="4_owner_db.php" class="btn btn-default btn-gr btn-block text-center text-uppercase text-white">Back</a>



    </div>
  </div>
  </div>
  </div>
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
