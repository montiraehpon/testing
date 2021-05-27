<?php
session_start();

require_once '../../BusinessServicesLayer/trackController/trackController.php';

$track = new trackController();
$sp_id = $_SESSION["id"];

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}
$data = $track->food_rpt($sp_id);
$datacheck = $track->food_rpt_check($sp_id);
?>
<html>
<head>
  <style>
  .rpt-btn .button {
  background-color: #d16464; 
  border: none;
  color: white;
  padding: 10px 70px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  cursor: pointer;
  float: left;
}

  </style>
  <title>Food Report</title>
  <link href="../../css/design.css" rel="stylesheet" >
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
    $("#sp_button").click(function() {
    $(".sp_form").show();
      });
    });

    $(document).mouseup(function (e) { 
      if ($(e.target).closest(".sp_form").length 
            === 0) { 
        $(".sp_form").hide(); 
      } 
    }); 

  </script> 
</head>
<body bgcolor="#ccd9ff">
  <table id="top" height="9%" width="100%">
    <tr>
      <th align="left" height="5%" valign="top" width="25%"> <img src="../../images/GUIImages/courier.png" width="25" height="25"> Speeda</th>
      <th align="center" colspan="2" width="50%"> 100% Guaranteed Dispatch </th>
      <th align="right"> <button type="button" id="sp_button" style="border:transparent;background:none;">
                <img src="../../images/GUIImages/user.png" style="width:20px;height:20px;border:0"/></button> 
      </th>

      <div class="sp_form">
        <form action="/action_page.php" class="form-container">
          <a href="../ManageUser/SPProfile.php"> <img src="../../images/GUIImages/gear.png" style="width:20px;border:0;vertical-align: middle;"/> My Account </a> <br>
          <a href="../ManageUser/SPManageProduct.php"> <img src="../../images/GUIImages/finger.png" style="width:20px;border:0;vertical-align: middle;"/> Manage Product </a> <br>
          <a href="SPOrderList.php"> <img src="../../images/GUIImages/order.png" style="width:20px;border:0;vertical-align: middle;"/> Order List </a> <br>
          <a href="SPTrackOrder.php"> <img src="../../images/GUIImages/road.png" style="width:20px;border:0;vertical-align: middle;"/> Track Order </a> <br>
          <a href="SPReport.php"> <img src="../../images/GUIImages/summary.png" style="width:20px;border:0;vertical-align: middle;"/> My Report</a> <br>
          <a href="../ManageUser/Logout.php"> <img src="../../images/GUIImages/logout.png" style="width:20px;border:0;vertical-align: middle;"/> Logout </a> <br>
        </form>
      </div>

    </tr>
    <tr>
      <td></td>
      <td colspan="2" align="center"> <a href="../ManageUser/SPHomepage.php" style="margin-right: 40px">Home</a> <a href="../ManageUser/SPManageProduct.php" style="margin-right: 40px">Manage Product</a> <a href="SPOrderList.php" style="margin-right: 40px">Order List</a> <a href="SPTrackOrder.php" style="margin-right: 40px">Track Order</a> <a href="SPReport.php">My Report</a></td>
      <td align="center">Welcome <?=$_SESSION['name']?>! (Service Provider)</td>
    </tr>
  </table>
<table id="btn" align="center">
    
    <tr >
      <td>
        <div class="rpt-btn">
          <button class="button" onclick="window.location.href='SPReport.php'">Food Report</button>
          <button class="button" onclick="window.location.href='SPReportGoods.php'">Goods Report</button>
          <button class="button" onclick="window.location.href='SPReportMedical.php'">Medical Report</button>
          <button class="button" onclick="window.location.href='SPReportPet.php'">Pet Report</button>
          </div>
      </td>
    </tr>
    <tr >
      <td><h2 style="text-align: center; height: 10px">Food Report</h2></td>
    </tr>
  </table>
  <table id="scd_detail" width="70%" height="70%" align="center" rules="all">
    <tr style="border-bottom: 1px solid black;height: 8%"> <hr>
        <td align="center">Name</td>
        <td align="center">Quantity Sold</td>
        <td align="center">Sale(RM)</td>
    </tr>
    <?php
      if($datacheck == 0){
        echo "<tr>
        <td colspan='5' align='center'> <h1>No items added</h1></td>
        </tr>
        </table>";
      }
      else{
        $subtotal = 0;
        $quantity = 0;
      foreach($data as $row){ 
        $fd_qty_sold = $row["sum"];
        $quantity += $row["product_quantity"];
        $fd_sale =(($row["sum"] * $quantity) * $row["product_price"]);
        $subtotal += $fd_sale;

    ?>
      <tr>
        <td align="center"><?=$row["product_name"]?></td>
        <td align="center"><?=$fd_qty_sold?></td>
        <td align="center">RM <?=$fd_sale?></td>
      </tr>
    <?php } ?>
    <tr style="height: 5%">
        <td colspan="2" align="right" style="font-size: 25px">Total Sale</td>
        <td align="center">RM <?=$subtotal?></td>
      </tr>
    <table>
      <?php } ?>
      <tr>
      <td><button type="button" name="back" onclick="window.location.href='../ManageUser/SPHomepage.php'"> Back </button></td>
    </tr>
    </table>
  </table>
  <table id="bottom" height="15%" width="100%">
    <tr> <hr>
      <td valign="center" rowspan="2" width="10%">
        <ul style="list-style-type:none;">
        <li><a href="../../ApplicationLayer/Home/Homepage.php">Home</a></li>
        <li><a href="../../ApplicationLayer/Home/CustomerSignup.php">Sign up</a></li>
        <li><a href="../../ApplicationLayer/Home/Login.php">Login</a></li>
        <li><a href="../../ApplicationLayer/Home/Faq.php">FAQ</a></li>
        </ul>
      </td>
      <td valign="center" rowspan="2">
        <ul style="list-style-type:none;">
        <li><a href="../../ApplicationLayer/Home/About.php">About us</a></li>
        <li><a href="../../ApplicationLayer/Home/RunnerSignup.php">Become a Runner</a></li>
        <li><a href="../../ApplicationLayer/Home/SPSignup.php">Become a Service Provider</a></li>
        <li><a href="../../ApplicationLayer/Home/Terms.php">Terms & Conditions</a></li>
        </ul>
      </td>
      <td align="center" width="25%" valign="bottom"> Follow us in </td>
    </tr>
    <tr>
      <td align="center" width="25%">
        <button type="button" style="border:transparent;background:none;" onclick="location.href='http://www.facebook.com'">
        <img src="../../images/GUIImages/facebook.png" style="width:25px;height:25px;border:0"/>
        </button>
        <button type="button" style="border:transparent;background:none;" onclick="location.href='http://www.twitter.com'">
        <img src="../../images/GUIImages/twitter.png" style="width:25px;height:25px;border:0"/>
        </button> 
        <button type="button" style="border:transparent;background:none;" onclick="location.href='http://www.instagram.com'">
        <img src="../../images/GUIImages/instagram.png" style="width:25px;height:25px;border:0"/>
        </button> </td>
    </tr>
    <tr>
      <td align="center" colspan="4"> Speeda Sdn.Bhd (1234567-T) &#169; All Rights Reserved</td> 
    </tr>
  </table>
</body>
</html>

