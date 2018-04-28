<?php
session_start();


include('common.php');
include('dbinfo.php');

$link = mysqli_connect($host,$username,$password,$database) or die("Error " . mysqli_error($link));

$uname = name();
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
" AND P_ID=$ID;";


$sql4 = "SELECT * FROM VISIT WHERE U_ID='$uname' AND P_ID=$ID;";
if (mysqli_fetch_row(mysqli_query($link,$sql4))) $rated=true;
else $rated=false;

$action = @$_POST['action'];


if ($action =="rate") {
    $rate = (int)($_POST['rate']);
    $date = date("Y-m-d h:i:s");
    $sql3 = "INSERT INTO VISIT(U_ID, P_ID, Date ,Rating) VALUES('$uname', $ID, '$date', $rate);";
    $result3 = mysqli_query($link,$sql3);
    $rated = true;
    notify("Thanks for your rating!",1);
}

if ($action == "unrate") {
  $sql3 = "DELETE FROM VISIT WHERE U_ID='$uname' AND P_ID= $ID;";
  mysqli_query($link, $sql3);
  $rated=false;
  notify("Successfully unlogged!",1);

}

if ($action == "back") {

  if ($_SESSION['ent']==16) {
    unset($_SESSION['ent']);
    header('location: /16_visitor_db.php');
  }
  else {
    unset($_SESSION['ent']);
    header('location: /18_vis_history.php');
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
            <li class="menu-active"><a href="16_visitor_db.php">Home</a></li>
            <li>/</li>
            <li><a href="18_vis_history.php">Visit History</a></li>
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
      <h3 class="mb-30"><?php echo $pname ?></h3>

      <div class="row">
      <div class="col-md-6">
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
      <div class="col-md-6">
      <div class="single-defination">
      <h4>Size(acres): <?php echo $Size ?></h4><br>
      <h4>Avg Rating: <?php echo $avg ?></h4><br>
      <h4>Type: <?php echo $ptype ?></h4><br>
      <h4>Public: <?php echo $isp ?></h4><br>
      <h4>Commercial: <?php echo $isc ?></h4><br>
      <h4>ID: <?php echo $ID ?></h4><br>
</div>
</div>
</div>
      <br>

      <?php

        $sql2 = "SELECT ITEM.I_Name FROM ITEM, PROPERTY_HAS_ITEM WHERE ITEM.I_Name=PROPERTY_HAS_ITEM.I_Name".
" AND ITEM.Item_Type!='ANIMAL' AND P_ID=$ID;";
        $result2 = mysqli_query($link, $sql2);
        $ctype = mysqli_fetch_row($result2);
        $string = $string =  "<h4>Crops: ".$ctype[0];
        while ($ctype = mysqli_fetch_row($result2)) {
          $string = $string.", ".$ctype[0];
        }
        $string = $string."</h4>";
        echo $string;
"<br>";
        if ($ptype=="FARM") {
          $sql2 = "SELECT ITEM.I_Name FROM ITEM, PROPERTY_HAS_ITEM WHERE ITEM.I_Name=PROPERTY_HAS_ITEM.I_Name".
" AND ITEM.Item_Type='ANIMAL' AND P_ID=$ID;";
        $result2 = mysqli_query($link, $sql2);
        $atype = mysqli_fetch_row($result2);
        $string =  "<h4>Animals: ".$atype[0];
        while ($atype = mysqli_fetch_row($result2)) {
          $string =  $string.", ".$atype[0];
        }
        $string =  $string."</h4>";
        echo $string;
        }
?>
      <br>
      <br>
<form method="post">
      <?php
      if ($rated == false) {?>

          <div>
            <h4>Rate Your Visit: </h4>
            <select class="form-control txt-field" name="rate">
              <option value="5">***** Five stars</option>
              <option value="4">**** Four stars</option>
              <option value="3">*** Three stars</option>
              <option value="2">** Two stars</option>
              <option value="1">* One star</option>
            </select>
            <br>
            <button class="btn btn-default btn-lg btn-block text-center text-uppercase" type="submit" name="action" value="rate">Log visit</button>
          </div>

        <?php } ?>
        <?php
        if ($rated == true) {?>

        <?php
        $sql5 = "SELECT Rating FROM VISIT WHERE P_ID='$ID' AND U_ID = '$uname';";
        $result5 = mysqli_query($link,$sql5);
        $rate_given = mysqli_fetch_row($result5)[0];?>
        <h4>Your rate is: <?php echo $rate_given ?> </h4>
        <button class="btn btn-default btn-lg btn-block text-center text-uppercase" type="submit" name="action" value="unrate">Un-Log visit</button>

        <?php } ?>


            <br><br>
      <button name="action" value="back" class="btn btn-default btn-gr btn-block text-center text-uppercase text-white">Back</a>
    </div>
</form>
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
