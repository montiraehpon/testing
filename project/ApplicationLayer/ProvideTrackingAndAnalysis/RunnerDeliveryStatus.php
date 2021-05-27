<?php
session_start();

require_once '../../BusinessServicesLayer/trackController/trackController.php';

$track = new trackController();
$rn_id = $_SESSION["id"];

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}

$getComplete = $track->getComplete($rn_id);

?>
<html>
<head>
  <title>Delivery Status</title>
  <link href="../../css/design.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
    $("#rn_button").click(function() {
    $(".rn_form").show();
      });
    });

    $(document).mouseup(function (e) { 
      if ($(e.target).closest(".rn_form").length 
            === 0) { 
        $(".rn_form").hide(); 
      } 
    }); 

  </script>
</head>
<body bgcolor="#ffdd99">
  <table id="top" height="9%" width="100%">
    <tr>
      <th align="left" height="5%" valign="top" width="25%"> <img src="../../images/GUIImages/courier.png" width="25" height="25"> Speeda</th>
      <th align="center" colspan="2" width="50%"> 100% Guaranteed Dispatch </th>
      <th align="right"> <button type="button" id="rn_button" style="border:transparent;background:none;">
                <img src="../../images/GUIImages/user.png" style="width:20px;height:20px;border:0"/></button> 
      </th>

      <div class="rn_form">
        <form action="/action_page.php" class="form-container">
          <a href="../ManageUser/RunnerProfile.php"> <img src="../../images/GUIImages/gear.png" style="width:20px;border:0;vertical-align: middle;"/> My Account </a> <br>
          <a href="RunnerDeliveryList.php"> <img src="../../images/GUIImages/order.png" style="width:20px;border:0;vertical-align: middle;"/> Delivery List </a> <br>
          <a href="RunnerDeliveryStatus.php"> <img src="../../images/GUIImages/road.png" style="width:20px;border:0;vertical-align: middle;"/> Delivery Status</a> <br>
          <a href="RunnerReport.php"> <img src="../../images/GUIImages/summary.png" style="width:20px;border:0;vertical-align: middle;"/> My Report</a> <br>
          <a href="../ManageUser/Logout.php"> <img src="../../images/GUIImages/logout.png" style="width:20px;border:0;vertical-align: middle;"/> Logout </a> <br>
        </form>
      </div>

    </tr>
    <tr>
      <td></td>
      <td colspan="2" align="center"> <a href="../ManageUser/RunnerHomepage.php" style="margin-right: 40px">Home</a> <a href="RunnerDeliveryList.php" style="margin-right: 40px">Delivery List</a> <a href="RunnerDeliveryStatus.php" style="margin-right: 40px">Delivery Status</a> <a href="RunnerReport.php" style="margin-right: 40px">Report</a></td>
      <td align="center">Welcome <?=$_SESSION['name']?>! (Runner)</td>
  </table>
  <?php 
  if($getComplete == 0){
          echo "<table id='detail' width='60%' height='70%' align='center'>
                <tr><hr>
                <td><h1 align='center'>No delivery yet</h1></td>
                </tr>
                </table>";
        }
      else{
          $sp_id = $track->getSP($rn_id);
          $data = $track->viewSPDetail($sp_id);
          $data2 = $track->viewStatus($rn_id);

          if(isset($_POST["update"])){
            $track->updateDelivery($rn_id,$sp_id);
          }
  ?>
  <table id="detail" width="60%" height="70%" align="center">
    <tr><hr> 
      <td align="center" width="100%"><table id="scd_detail" width="100%" height="100%">
        <tr>
          <td align="center" height="20%" colspan="2" style="font-size: 20px;">Service Provider Detail</td>
        </tr>
        <?php
          foreach ($data as $row){
        ?> 
        <tr>
          <td align="left" width="40%" height="50%">Service Provider Address: </td>
          <td ><?=$row["sp_address"]?></td>
        </tr>
        <tr>
          <td align="left" width="40%">Service Provider Phone Number: </td>
          <td><?=$row["phone_num"]?></td>
        </tr>
        <?php } ?>
      </table>
    </td>
  </tr>
  <tr>
    <td width="100%"><table id="scd_detail" width="100%" height="100%">
      <tr>
        <td align="center" colspan="2" height="15%" style="font-size: 20px">Order Detail</td>
      </tr>
      <?php
        foreach ($data2 as $row){
       
      echo "<tr>
        <td align='left' width='30%'>Customer Address: </td>
        <td>".$row["cus_address"]."</td>
      </tr>
      <tr>
        <td align='left'>Customer Phone Number: </td>
        <td>".$row["phone_num"]."</td>
      </tr>
      <tr> 
        <td align=''left'>Order Name: </td>
        <td>".$row["product_name"]."</td>
      </tr>
      <tr style='border-bottom:1px solid black'>
        <td align='left'>Order Quantity: </td>
        <td>".$row["product_quantity"]."</td>
      </tr>";
     } ?>
     <tr>
      <form action="" method="POST">
      <td>Status: <select name="status">
                    <option value="Sending">Sending</option>
                    <option value="Completed">Completed</option> </select></td>
      <td align="center" width="10%"><input id="submit_btn" type="submit" name="update" value="Update"></td>
      </form>

    </tr>
    </table>
    </td>
    </tr>
  </table>
  <?php } ?>
  <table id="detail" width="85%" align="center">
    <tr>
      <td><button type="button" name="back" onclick="window.location.href='../ManageUser/RunnerHomepage.php'"> Back </button></td>
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

