<?php
session_start();


include('common.php');
include('dbinfo.php');

$link = mysqli_connect($host,$username,$password,$database) or die("Error " . mysqli_error($link));



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
if ($action == "signup") {
  $email = $_POST['email'];
  $username = $_POST['uname'];
  $pw1 = $_POST['psw'];
  $pw2 = $_POST['psw-repeat'];
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
     if (register($username, $email, $pw1, $pw2, $utype, $link)) {
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

      echo "Owner: ".$username." created! Please login";
      header('location: /1_login.php');
      }} else {
    echo "Property exists!";
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
<div class="whole-wrap">
    <div class="container">
      <div class="row fullscreen d-flex align-items-center justify-content-center">
        <div class="col-lg-8  col-md-9 header-right">
          <h4 class="text-white pb-30">New Owner Registration</h4>
          <p class="text-white">Please fill in this form to create an account.</p>
          <form method="post">
            <div class="row">
            <div class="col-md-6">
            <div class="single-defination">
      <label for="email"><b>Email*</b></label>
      <input class="form-control txt-field" type="email" placeholder="Email" name="email" value="" pattern="[a-zA-Z0-9]+@+[a-zA-Z0-9]+\.[a-zA-Z0-9]" required>

      <label for="uname"><b>Username*</b></label>
      <input class="form-control txt-field" type="text" placeholder="Username" name="uname" value="" required>

      <label for="psw"><b>Password*</b></label>
      <input class="form-control txt-field" type="password" placeholder="Password" name="psw" value="" pattern="{8,}" title="Must contain at least 8 or more characters" required>

      <label for="psw-repeat"><b>Repeat Password*</b></label>
      <input class="form-control txt-field" type="password" placeholder="Confirm Password" pattern=".{8,}" name="psw-repeat" value="" required>

      <label for="property"><b>Property Name*</b></label>
      <input class="form-control txt-field" type="text" placeholder="Property Name" name="property" value="" required>

      <label for="add"><b>Street Address*</b></label>
      <input class="form-control txt-field" type="text" placeholder="Street Address" name="add" value="" required>

      <label for="city"><b>City*</b></label>
      <input class="form-control txt-field" type="text" placeholder="City" name="city" value="" required>

      <label for="zip"><b>Zip*</b></label>
      <input class="form-control txt-field" type="text" placeholder="Zipcode" name="zip" value="" required>
    </div>
    </div>

    <div class="col-md-6">
    <div class="single-defination">

      <label for="acres"><b>Arces*</b></label>
      <input class="form-control txt-field" type="number" step="any" placeholder="Arces" name="arces" value="" required>

      <label for="pro_type"><b>Property Type*</b></label>
      <select class="form-right txt-field" name="p_type_option">
        <option value="FARM">Farm</option>
        <option value="GARDEN">Garden</option>
        <option value="ORCHARD">Orchard</option>
      </select>

      <label for="animal"><b>Animal*</b></label>
      <select class="form-right txt-field" name="a_type_option">
        <?php while($atype = mysqli_fetch_row($getaresult)) {
          ?>
        <option value="<?php echo $atype[0]?>"> <?php echo $atype[0]?> </option>
        <?php
          }
        ?>
      </select>

      <label for="fcrop"><b>Farm Crop*</b></label>
      <select class="form-right txt-field" name="fc_type_option">
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
      <select class="form-right txt-field" name="gc_type_option">

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
      <select class="form-right txt-field" name="oc_type_option">
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

      <label for="public"><b>Public*</b></label>
      <select class="form-right txt-field" name="isp_option">
        <option value="1">Yes</option>
        <option value="0">No</option>
      </select>

      <label for="commercial"><b>Commercial*</b></label>
      <select class="form-right txt-field" name="isc_option">
        <option value="1">Yes</option>
        <option value="0">No</option>
      </select>
    </div>
  </div>
</div>
      <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
      </label>

        <button type="submit" name = "action" value="signup" class="btn btn-default btn-lg btn-block text-center text-uppercase">Sign Up</button>
        </form>
        <a href="1_login.php" class="btn btn-default btn-gr btn-block text-center text-uppercase text-white">Cancel</a>

      </div>
    </div>
  </div>
  </div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
