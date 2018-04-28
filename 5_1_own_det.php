<?php
session_start();


include('common.php');
include('dbinfo.php');

$link = mysqli_connect($host,$username,$password,$database) or die("Error " . mysqli_error($link));

$username = name();
$pname = $_SESSION['current_p'];

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

$sql2 = "SELECT ITEM.I_Name, Item_Type FROM ITEM, PROPERTY_HAS_ITEM WHERE ITEM.I_Name=PROPERTY_HAS_ITEM.I_Name".
" AND P_ID=$ID;"


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

<!--start detail-->
<div class="whole-wrap">
  <div class="container">
    <div class="row fullscreen d-flex align-items-center justify-content-center">
      <div class="col-lg-8  col-md-9 header-right">
    <div class="section-half">
      <h3 class="mb-30 text-center"><?php echo $pname ?></h3>
      <div class="row">
      <div class="col-md-8">
      <div class="single-defination">
      <h4>Name: <?php echo $pname ?></h4><br>
      <h4>Owner: <?php echo $username ?></h4><br>
      <h4>Owner Email: <?php echo $email ?></h4><br>
      <h4>Visits: <?php echo $visits ?></h4><br>
      <h4>Adress: <?php echo $addr ?></h4><br>
      <h4>City: <?php echo $city ?></h4><br>
      <h4>Zip: <?php echo $zip ?></h4><br>
</div>
</div>

      <div class="col-md-4">
      <div class="single-defination">
      <h4>Size(acres): <?php echo $Size ?></h4><br>
      <h4>Avg Rating: <?php echo $avg ?></h4><br>
      <h4>Type: <?php echo $ptype ?></h4><br>
      <h4>Public: <?php echo $isp ?></h4><br>
      <h4>Commercial: <?php echo $isc ?></h4><br>
      <h4>ID: <?php echo $ID ?></h4>
      <br>
    </div>
    </div>
    </div>
      <?php

        $sql2 = "SELECT ITEM.I_Name FROM ITEM, PROPERTY_HAS_ITEM WHERE ITEM.I_Name=PROPERTY_HAS_ITEM.I_Name".
" AND ITEM.Item_Type!='ANIMAL' AND P_ID=$ID;";
        $result2 = mysqli_query($link, $sql2);
        $ctype = mysqli_fetch_row($result2);
        $string =  "<h4>Crops: ".$ctype[0];
        while ($ctype = mysqli_fetch_row($result2)) {
         $string =  $string.", ".$ctype[0];
        }
        $string = $string."</h4>";
        echo $string;

        if ($ptype=="FARM") {
          $sql2 = "SELECT ITEM.I_Name FROM ITEM, PROPERTY_HAS_ITEM WHERE ITEM.I_Name=PROPERTY_HAS_ITEM.I_Name".
" AND ITEM.Item_Type='ANIMAL' AND P_ID=$ID;";
        $result2 = mysqli_query($link, $sql2);
        $atype = mysqli_fetch_row($result2);
        $string =  "<h4>Animals: ".$atype[0];
        while ($atype = mysqli_fetch_row($result2)) {
          $string.", ".$atype[0];
        }
        $string."</h4>";
        echo $string;
        }
?>
<br><br>
      <a href="5_view_other.php" class="btn btn-default btn-lg btn-block text-center text-uppercase text-white">Back</a>
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
