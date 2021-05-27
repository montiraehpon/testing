<?php
session_start();

require_once '../../BusinessServicesLayer/medController/medController.php';

$med = new medController();
$sp_id= $_SESSION["id"];

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}

if(isset($_POST['add'])){
  $med->med_addProduct($sp_id);   
}

?>
<html>
<head>
  <title>Add Med Product</title>
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
  <form action="" method="POST" enctype="multipart/form-data">
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
          <a href="../ProvideTrackingAndAnalysis/SPOrderList.php"> <img src="../../images/GUIImages/order.png" style="width:20px;border:0;vertical-align: middle;"/> Order List </a> <br>
          <a href="../ProvideTrackingAndAnalysis/SPTrackOrder.php"> <img src="../../images/GUIImages/road.png" style="width:20px;border:0;vertical-align: middle;"/> Track Order </a> <br>
          <a href="../ProvideTrackingAndAnalysis/SPReport.php"> <img src="../../images/GUIImages/summary.png" style="width:20px;border:0;vertical-align: middle;"/> My Report</a> <br>
          <a href="../ManageUser/Logout.php"> <img src="../../images/GUIImages/logout.png" style="width:20px;border:0;vertical-align: middle;"/> Logout </a> <br>
        </form>
      </div>

    </tr>
    <tr>
      <td></td>
      <td colspan="2" align="center"> <a href="../ManageUser/SPHomepage.php" style="margin-right: 40px">Home</a> <a href="../ManageUser/SPManageProduct.php" style="margin-right: 40px">Manage Product</a> <a href="../ProvideTrackingAndAnalysis/SPOrderList.php" style="margin-right: 40px">Order List</a> <a href="../ProvideTrackingAndAnalysis/SPTrackOrder.php" style="margin-right: 40px">Track Order</a> <a href="../ProvideTrackingAndAnalysis/SPReport.php">My Report</a></td>
      <td align="center">Welcome <?=$_SESSION['name']?>! (Service Provider)</td>
    </tr>
  <table id="inside_part" width="70%" height="70%" align="center">
    <tr> <hr>
      <th align="center" colspan="4">Add Product</th>
    </tr>
    <tr>
      <td>Product Name: </td>
      <td><input type="text" name="name" size="30" placeholder="Product Name" required></td>
      <td align="center">Cover Image *: </td>
      <td align="center"><input type="file" name="coverpath"
      onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])" required> </td>
    </tr>
    <tr>
      <td>Product Price: </td>
      <td>RM <input type="number" step="0.01" name="price" placeholder="00.00" required> </td>
      <td colspan="2" rowspan="3" align="center"><img id="image" width="160" height="160"/></td>
    </tr>
    <tr>
      <td>Quantity: </td>
      <td><input type="number" name="quantity" placeholder="1000" required></td>
    </tr>
    <tr>
      <td>Variation: </td>
      <td><select name="med_variation">
          <option value="" disabled selected value>-Select one variation-</option>
          <option value="Vitamin">Vitamin</option>
          <option value="Personal">Personal Care</option>
          <option value="Food">Health Food</option>
          <option value="Tool">Health Tool</option>
      </select> </td> 
    </tr>
    <tr>
      <td>Product Details: </td>
      <td ><textarea rows="5" cols="40" name="detail" placeholder="Maximum 100 words" required></textarea></td>
      <td align="center">Product Images *:</td>
      <td align="center"><input type="file" name="imgpath[]" multiple></td>
    </tr>
    <tr>
      <td colspan="2"></td>
      <td colspan="2" align="center" style="font-size: 13px"> * File extension: .JPG, .JPEG, .PNG <br> Product images will be displayed based on your sequence. <br> Maximum 8 images for product images.</td>
    </tr>
    <tr>
      <td colspan="2"><button type="button" name="back" onclick="window.location.href='MedProduct.php'"> Back </button></td>
      <td colspan="2" align="right"><input id="product_btn" type="submit" name="add" value="Add"></td>
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
  </form>
</body>
</html>

