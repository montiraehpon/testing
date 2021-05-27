<?php
session_start();
require_once '../../BusinessServicesLayer/userController/userController.php';

$user = new userController();

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}

?>
<html>
<head>
  <title>Manage Product</title>
  <link href="../../css/design.css" rel="stylesheet">
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
          <a href="SPProfile.php"> <img src="../../images/GUIImages/gear.png" style="width:20px;border:0;vertical-align: middle;"/> My Account </a> <br>
          <a href="SPManageProduct.php"> <img src="../../images/GUIImages/finger.png" style="width:20px;border:0;vertical-align: middle;"/> Manage Product </a> <br>
          <a href="../ProvideTrackingAndAnalysis/SPOrderList.php"> <img src="../../images/GUIImages/order.png" style="width:20px;border:0;vertical-align: middle;"/> Order List </a> <br>
          <a href="../ProvideTrackingAndAnalysis/SPTrackOrder.php"> <img src="../../images/GUIImages/road.png" style="width:20px;border:0;vertical-align: middle;"/> Track Order </a> <br>
          <a href="../ProvideTrackingAndAnalysis/SPReport.php"> <img src="../../images/GUIImages/summary.png" style="width:20px;border:0;vertical-align: middle;"/> My Report</a> <br>
          <a href="Logout.php"> <img src="../../images/GUIImages/logout.png" style="width:20px;border:0;vertical-align: middle;"/> Logout </a> <br>
        </form>
      </div>

    </tr>
    <tr>
      <td></td>
      <td colspan="2" align="center"> <a href="SPHomepage.php" style="margin-right: 40px">Home</a> <a href="SPManageProduct.php" style="margin-right: 40px">Manage Product</a> <a href="../ProvideTrackingAndAnalysis/SPOrderList.php" style="margin-right: 40px">Order List</a> <a href="../ProvideTrackingAndAnalysis/SPTrackOrder.php" style="margin-right: 40px">Track Order</a> <a href="../ProvideTrackingAndAnalysis/SPReport.php">My Report</a></td>
      <td align="center">Welcome <?=$_SESSION['name']?>! (Service Provider)</td>
    </tr>
  </table>
  <table id="detail" width="63%" height="70%" align="center">
    <tr> <hr>
      <th style="font-size: 20px" colspan="4">Manage Product</th>
    </tr>
    <tr>
      <td align="center" colspan="4">View/ Add / Edit / Delete</td>
    </tr>
    <tr>
      <td align="center" width="20%"> <button type="button" style="width: 120px;height: 100px" onclick="window.location.href='../ManageFoodDelivery/FoodProduct.php'">
                 Food<br> <img src="../../images/GUIImages/food.png" style="width:50px;height:50px;border:0"/>  </button> </td> 
      <td align="center" width="20%"> <button type="button" style="width: 120px;height: 100px" onclick="window.location.href='../ManageGoodsDelivery/GoodsProduct.php'">
                 Goods <br> <img src="../../images/GUIImages/groceries.png" style="width:50px;height:50px;border:0"/>  </button> </td> 
      <td align="center" width="20%"> <button type="button" style="width: 120px;height: 100px" onclick="window.location.href='../ManagePetAssist/PetProduct.php'">
                 Pet Assist<br> <img src="../../images/GUIImages/pet-food.png" style="width:50px;height:50px;border:0"/>  </button> </td>
      <td align="center" width="20%"> <button type="button" style="width: 120px;height: 100px" onclick="window.location.href='../ManageMedicineDelivery/MedProduct.php'">
                 Medicine<br> <img src="../../images/GUIImages/medicine.png" style="width:50px;height:50px;border:0"/>  </button> </td>
    </tr>
    <tr align="center" valign="bottom">
      <td colspan="4"> <button type="button" onclick="window.location.href='SPHomepage.php'" style="width: 50px;height: 30px"> Back </button></td>
    </tr>
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

