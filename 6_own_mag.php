<?php
session_start();


include('common.php');
include('dbinfo.php');

$link = mysqli_connect($host,$username,$password,$database) or die("Error " . mysqli_error($link));

$uname = name();
$pname = $_SESSION['current_manage'];
$utype = usertype();
if ($utype==0) {
  $con = $_SESSION['confirm'];
}



$sql = "SELECT Name, Username, Email, ID, Size_Acres,St_Address,City,ZIP,IsComm, IsPublic, Property_Type,".
" IFNULL(COUNT(Rating),0) AS Visits, AVG(Rating) AS Avg_Rating FROM(PROPERTY LEFT JOIN VISIT".
" ON ID=P_ID LEFT JOIN USER ON Username=User_Name) WHERE Name='$pname';";
$result = mysqli_query ($link, $sql);
$pdata =mysqli_fetch_row($result);
$username = $pdata[1];
$email = $pdata[2];
$visits = $pdata[11];
$addr = $pdata[5];
$city = $pdata[6];
$zip = $pdata[7];
$Size = $pdata[4];
$avg = $pdata[12];
$ptype = $pdata[10];
if ($pdata[9] == '1') $isp = 'True';
else $isp = 'False';
if ($pdata[8] == '1') $isc = 'True';
else $isc = 'False';
$ID = $pdata[3];


$carray = array();
$selectanimal = "SELECT DISTINCT ITEM.I_Name FROM ITEM, PROPERTY_HAS_ITEM WHERE IsApproved=1 AND ITEM.I_Name=PROPERTY_HAS_ITEM.I_Name".
" AND P_ID=$ID AND Item_Type='ANIMAL';";
$selectflower = "SELECT DISTINCT ITEM.I_Name FROM ITEM, PROPERTY_HAS_ITEM WHERE IsApproved=1 AND ITEM.I_Name=PROPERTY_HAS_ITEM.I_Name".
" AND P_ID=$ID AND Item_Type='FLOWER';";
$selectvege = "SELECT DISTINCT ITEM.I_Name FROM ITEM, PROPERTY_HAS_ITEM WHERE IsApproved=1 AND ITEM.I_Name=PROPERTY_HAS_ITEM.I_Name".
" AND P_ID=$ID AND Item_Type='VEGETABLE';";
$selectfru = "SELECT DISTINCT ITEM.I_Name FROM ITEM, PROPERTY_HAS_ITEM WHERE IsApproved=1 AND ITEM.I_Name=PROPERTY_HAS_ITEM.I_Name".
" AND P_ID=$ID AND Item_Type='FRUIT';";
$selectnut = "SELECT DISTINCT ITEM.I_Name FROM ITEM, PROPERTY_HAS_ITEM WHERE IsApproved=1 AND ITEM.I_Name=PROPERTY_HAS_ITEM.I_Name".
" AND P_ID=$ID AND Item_Type='NUT';";
if ($ptype == "GARDEN") {
  $existflw = mysqli_query($link, $selectflower);
  while ($flwresult = mysqli_fetch_row($existflw) ) {
    $carray[] = $flwresult[0];
  }
  $existvege = mysqli_query($link, $selectvege);
  while ($vegeresult = mysqli_fetch_row($existvege) ) {
    $carray[] = $vegeresult[0];
  }
} elseif ($ptype=="ORCHARD") {
  $existfru = mysqli_query($link, $selectfru);
  while ($fruresult = mysqli_fetch_row($existfru) ) {
    $carray[] = $fruresult[0];
  }
  $existnut = mysqli_query($link, $selectnut);
  while ($nutresult = mysqli_fetch_row($existnut) ) {
    $carray[] = $nutresult[0];
  }
}  else {
    $existflw = mysqli_query($link, $selectflower);
  while ($flwresult = mysqli_fetch_row($existflw) ) {
    $carray[] = $flwresult[0];
  }
  $existvege = mysqli_query($link, $selectvege);
  while ($vegeresult = mysqli_fetch_row($existvege) ) {
    $carray[] = $vegeresult[0];
  }
  $existfru = mysqli_query($link, $selectfru);
  while ($fruresult = mysqli_fetch_row($existfru) ) {
    $carray[] = $fruresult[0];
  }
  $existnut = mysqli_query($link, $selectnut);
  while ($nutresult = mysqli_fetch_row($existnut) ) {
    $carray[] = $nutresult[0];
  }

  $existanimal = mysqli_query($link, $selectanimal);
  $aarray = array();
  while ($animalresult = mysqli_fetch_row($existanimal) ) {
    $aarray[] = $animalresult[0];
  }

}

$ncarray = array();
$nselectanimal = "SELECT DISTINCT ITEM.I_Name FROM ITEM, PROPERTY_HAS_ITEM WHERE IsApproved=1 ".
" AND Item_Type='ANIMAL';";
$nselectflower = "SELECT DISTINCT ITEM.I_Name FROM ITEM, PROPERTY_HAS_ITEM WHERE IsApproved=1 ".
" AND Item_Type='FLOWER';";
$nselectvege = "SELECT DISTINCT ITEM.I_Name FROM ITEM, PROPERTY_HAS_ITEM WHERE IsApproved=1 ".
" AND Item_Type='VEGETABLE';";
$nselectfru = "SELECT DISTINCT ITEM.I_Name FROM ITEM, PROPERTY_HAS_ITEM WHERE IsApproved=1 ".
" AND Item_Type='FRUIT';";
$nselectnut = "SELECT DISTINCT ITEM.I_Name FROM ITEM, PROPERTY_HAS_ITEM WHERE IsApproved=1 ".
" AND Item_Type='NUT';";
if ($ptype == "GARDEN") {
  $nexistflw = mysqli_query($link, $nselectflower);
  while ($nflwresult = mysqli_fetch_row($nexistflw) ) {
    $ncarray[] = $nflwresult[0];
  }
  $nexistvege = mysqli_query($link, $nselectvege);
  while ($nvegeresult = mysqli_fetch_row($nexistvege) ) {
    $ncarray[] = $nvegeresult[0];
  }
} elseif ($ptype=="ORCHARD") {
  $nexistfru = mysqli_query($link, $nselectfru);
  while ($nfruresult = mysqli_fetch_row($nexistfru) ) {
    $ncarray[] = $nfruresult[0];
  }
  $nexistnut = mysqli_query($link, $nselectnut);
  while ($nnutresult = mysqli_fetch_row($nexistnut) ) {
    $ncarray[] = $nnutresult[0];
  }
}  else {
    $nexistflw = mysqli_query($link, $nselectflower);
  while ($nflwresult = mysqli_fetch_row($nexistflw) ) {
    $ncarray[] = $nflwresult[0];
  }
  $nexistvege = mysqli_query($link, $nselectvege);
  while ($nvegeresult = mysqli_fetch_row($nexistvege) ) {
    $ncarray[] = $nvegeresult[0];
  }
  $nexistfru = mysqli_query($link, $nselectfru);
  while ($nfruresult = mysqli_fetch_row($nexistfru) ) {
    $ncarray[] = $nfruresult[0];
  }
  $nexistnut = mysqli_query($link, $nselectnut);
  while ($nnutresult = mysqli_fetch_row($nexistnut) ) {
    $ncarray[] = $nnutresult[0];
  }
  $nexistanimal = mysqli_query($link, $nselectanimal);
  $naarray = array();
  while ($nanimalresult = mysqli_fetch_row($nexistanimal) ) {
    $naarray[] = $nanimalresult[0];
  }

}

if ($_SESSION['timer']==0) {
  //$new_carray=$carray;
  $_SESSION['new_carray']=$carray;
}
if ($ptype=="FARM" && $_SESSION['timer2']==0) {
  //$new_carray=$carray;
  $_SESSION['new_aarray']=$aarray;
}

//store not containing array
$noc = array();
foreach ($ncarray as $selected) {
  if (!in_array($selected, $carray)) {
    $noc[]=$selected;
  }
}

$action = @$_POST['action'];

if ($action == 'add_crop') {
  $sc=  $_POST['c_type_option'];
  $ind = array_search($sc,$ncarray);
  if (!in_array($sc, $_SESSION['new_carray'])) {
  array_push($_SESSION['new_carray'], $sc);
  }
}

if ($action == 'add_animal') {
  $sa=  $_POST['a_type_option'];
  $ind = array_search($sa,$naarray);
  if (!in_array($sa, $_SESSION['new_aarray'])) {
  array_push($_SESSION['new_aarray'], $sa);
  }
}

if ($action == 'unsave') {
  $_SESSION['timer']=0;
  $_SESSION['timer2']=0;

  if ($utype ==1) header('location: /4_owner_db.php');
      elseif ($con==true) header('location: /11_view_cof_pro.php');
      else header('location: /9_view_uncof_pro.php');
}

if ($action =="delete") {
  $sql6 = "DELETE FROM PROPERTY WHERE ID=$ID";
  $result6 = mysqli_query($link,$sql6);
  notify("Property deleted!");

  if ($utype ==1) header('location: /4_owner_db.php');
      elseif ($con==true) header('location: /11_view_cof_pro.php');
      else header('location: /9_view_uncof_pro.php');
}


if ($action =="request") {
 $request_type = $_POST['r_crop'];
 $request_name = $_POST['r_name'];
 $sql7 = "SELECT I_Name FROM ITEM WHERE I_Name='$request_name'";
 $result7 = mysqli_query($link, $sql7);
 if (mysqli_fetch_row($result7)) {
  notify("This item is pending or already approved!");
 } else {
  $sql7 = "INSERT INTO ITEM(I_Name, IsApproved, Item_Type) VALUES('$request_name', 0, '$request_type');";
  $result7 = mysqli_query($link,$sql7);
  notify("Request sent!");
 }
}

if ($action == 'save') {
  if (!isset($_POST['choose_crop'])) {
    notify('At least one crop needs to be selected!', -1);
  } elseif ($ptype=="FARM" && !isset($_POST['choose_animal'] )) {
    notify('At least one crop and one animal needs to be selected!', -1);


  } else {
    //regular info storage
    $pname2 = $_POST['pname'];
    $addr = $_POST['addr'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $Size = (float)($_POST['Size']);
    $isp = (int)($_POST['getp']);
    $isc = (int)($_POST['getc']);

    $sql4 = "SELECT * FROM PROPERTY WHERE Name='$pname2';";
    $result4 = mysqli_query($link,$sql4);
    if ($pname2!=$pname && mysqli_fetch_row($result4)) {
      notify("Property name exists!", -1);
    } else {
      if ($utype==1) $sql5 = "UPDATE PROPERTY SET Name='$pname2', St_Address='$addr', City='$city',ZIP='$zip',".
      " Size_Acres='$Size', IsPublic='$isp', IsComm='$isc', Admin_Name=NULL WHERE ID=$ID;";
      elseif ($utype==0) $sql5 = "UPDATE PROPERTY SET Name='$pname2', St_Address='$addr', City='$city',ZIP='$zip',".
      " Size_Acres='$Size', IsPublic='$isp', IsComm='$isc', Admin_Name='$uname' WHERE ID=$ID;";
      mysqli_query($link,$sql5);

      foreach ($_POST['choose_crop'] as $selected) {
        if (!in_array($selected, $carray)) {
          $sql3 = "INSERT INTO PROPERTY_HAS_ITEM(P_ID, I_Name) VALUES($ID, '$selected');";
        $result3 = mysqli_query($link,$sql3);
        }
      }
      foreach ($carray as $selected) {
        if (!in_array($selected, $_POST['choose_crop'])) {
          $sql4 = "DELETE FROM PROPERTY_HAS_ITEM WHERE P_ID=$ID AND I_Name='$selected';";
        $result4 = mysqli_query($link,$sql4);
        }
      }

      if ($ptype=="FARM") {
        foreach ($_POST['choose_animal'] as $selected) {
        if (!in_array($selected, $aarray)) {
          $sql3 = "INSERT INTO PROPERTY_HAS_ITEM(P_ID, I_Name) VALUES($ID, '$selected');";
        $result3 = mysqli_query($link,$sql3);
        }
      }
      foreach ($aarray as $selected) {
        if (!in_array($selected, $_POST['choose_animal'])) {
          $sql4 = "DELETE FROM PROPERTY_HAS_ITEM WHERE P_ID=$ID AND I_Name='$selected';";
        $result4 = mysqli_query($link,$sql4);
        }
      }

      }

      unset($_SESSION['new_carray']);
      unset($_SESSION['new_aarray']);
      if ($utype ==1) header('location: /4_owner_db.php');
      elseif ($con==true) header('location: /11_view_cof_pro.php');
      else header('location: /9_view_uncof_pro.php');
      notify('Property updated!', 1);
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
          Welcome!  <br> <?php echo $uname ?>
        </h1>
      </div>
    </div>
  </div>
</section><!-- End banner Area -->
<div class="container">
<?php if (@$_SESSION['notification']): ?>
  <div class="alert alert-<?php echo $_SESSION['notification']['type'] ?>">

   <?php echo htmlentities($_SESSION['notification']['message']) ?>
  </div>
<?php $_SESSION['notification'] = false; endif; ?>
  </div>
<!--start detail-->

<div class="whole-wrap">
  <div class="container">
    <div class="row d-flex align-items-center justify-content-center">
      <div class="col-lg-8  col-md-9 header-right">
        <div class="section-half">
          <h3 class="mb-30 text-center">Manage <?php echo $pname ?></h3>
          <form method="post">

            <div class="row">
            <div class="col-md-6">
            <div class="single-defination">
          <h4>Name: </h4>
          <input class="form-control txt-field" type="text" value="<?php echo $pname ?>" name="pname" required>

          <h4>Adress: </h4>
          <input class="form-control txt-field" type="text" value="<?php echo $addr ?>" name="addr" required>

          <h4>City: </h4>
          <input class="form-control txt-field" type="text" value="<?php echo $city ?>" name="city" required>

          <h4>Zip: </h4>
          <input class="form-control txt-field" type="text" pattern="[0-9]{5}" value="<?php echo $zip ?>" name="zip" required title="5 digits">

          <h4>Size(acres): </h4>
          <input class="form-control txt-field" type="number" step="any" value="<?php echo $Size ?>" name="Size"  required>

          <h4>Type: <?php echo $ptype ?></h4>
          <br>
          <h4>ID: <?php echo $ID ?></h4>
        </div>
        </div>
          <div class="col-md-6">
          <div class="single-defination">
          <h4>Public: </h4>
          <select class="form-right txt-field" name="getp">
            <option value="1" <?php if ($isp=="True") echo "selected=\"selected\""; ?>>True</option>
            <option value="0" <?php if ($isp=="False") echo "selected=\"selected\""; ?>>False</option>
          </select>

          <h4>Commercial: </h4>
          <select class="form-right txt-field" name="getc">
            <option value="1" <?php if ($isc=="True") echo "selected=\"selected\""; ?>  >True</option>
            <option value="0" <?php if ($isc=="False") echo "selected=\"selected\""; ?>  >False</option>
          </select>





          <div>
              <h4>Add New Crop:</h4>

              <select class="form-right txt-field" name="c_type_option" >
                <?php

                  $len = count($ncarray);
                  for ($i=0; $i<$len; $i++) { ?>
                    <option value="<?php echo $ncarray[$i]?>"> <?php echo $ncarray[$i]?> </option>
            <?php } ?>

              </select>
            </br>
              <button class="btn btn-default btn-lg btn-block text-center text-uppercase" type="submit" name="action" value="add_crop">Add New Crops</button>

              <?php if ($ptype == "FARM") { ?>
                <br>
              <h4>Add New Animal:</h4>
                <select class="form-right txt-field" name="a_type_option" >
                  <?php
                  $len = count($naarray);
                  for ($i=0; $i<$len; $i++) { ?>
                <option value="<?php echo $naarray[$i]?>" > <?php echo $naarray[$i]?> </option>
                  <?php } ?>
                </select>
                <button class="btn btn-default btn-lg btn-block text-center text-uppercase" type="submit" name="action" value="add_animal">Add New Animals</button><br><br>
                  <?php } ?>



          </div>


          <h4>Existing crops: </h4>
          <?php
          $len2 = count($_SESSION['new_carray']);
          for ($i=0; $i<$len2; $i++) {
            $element = $_SESSION['new_carray'][$i]; ?>
            <input type="checkbox" name="choose_crop[]" value="<?php echo $element ?>" checked ><?php echo $element?><br>
          <?php }
  if ($_SESSION['timer']==0) $_SESSION['timer']=1;
            ?>

          <?php if ($ptype == "FARM") { ?>
          <h4>Existing animals: </h4>
          <?php
          $len2 = count($_SESSION['new_aarray']);
          for ($i=0; $i<$len2; $i++) {
            $element = $_SESSION['new_aarray'][$i]; ?>
            <input type="checkbox" name="choose_animal[]" value="<?php echo $element ?>" checked ><?php echo $element?><br>
          <?php }
            if ($_SESSION['timer2']==0) $_SESSION['timer2']=1;
            } ?>

          </div>
        </div>
      </div>
      <br>
          <button class="btn btn-default btn-lg btn-block text-center text-uppercase" type="submit" name="action" value="save">Save Changes</button>


          <button class="btn btn-default btn-gr btn-block text-center text-uppercase" type="submit" name="action" value="unsave">Don't Save</button>
          <button class="btn btn-default btn-gr btn-block text-center text-uppercase" type="submit" name="action" value="delete">Delete Property</button>
</form>

<?php if ($utype==1) {?>
<form method="post">

              <br>
              <h4>Request crop approval</h4>
              <div class="row">
              <select class="form-right txt-field col-lg-5" name="r_crop">
                <?php
                if ($ptype=="GARDEN") {
                 echo "<option selected=\"selected\" value=\"VEGETABLE\">vegetable</option>";
                 echo "<option value=\"FLOWER\">flower</option>";}
                
                if ($ptype == "ORCHARD") {
                echo "<option value=\"FRUIT\" selected=\"selected\">fruit</option>";
                echo "<option value=\"NUT\">nut</option>"; }
                
                if ($ptype == "FARM") {
                echo "<option selected=\"selected\" value=\"VEGETABLE\">vegetable</option>";
                echo "<option value=\"FRUIT\">fruit</option>";
               echo "<option value=\"NUT\">nut</option>";
               echo "<option value=\"FLOWER\">flower</option>";
               echo "<option value=\"ANIMAL\">animal</option>";
                }?>
              </select>
              <div class="col-lg-1"><br>
              </div>
              <input class="form-control txt-field col-lg-6" type="text" placeholder="Enter new item" name="r_name" value="" required>
              <button class="btn btn-default btn-lg btn-block text-center text-uppercase" type="submit" name="action" value="request">Submit Request</button> </br>
            </div>
          </form>

    <?php     } ?>
        </div>
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
