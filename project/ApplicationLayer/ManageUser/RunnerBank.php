<?php
session_start();

require_once '../../BusinessServicesLayer/userController/userController.php';

$user = new userController();
$rn_id= $_SESSION["id"];
$data = $user->rn_bankView($rn_id);
$dataCheck= $user->rn_bankCheck($rn_id);

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}

if(isset($_POST['delete'])){
  $user->rn_bankDelete($rn_id);   
}

?>
<html>
<head>
  <title>Bank</title>
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
          <a href="RunnerProfile.php"> <img src="../../images/GUIImages/gear.png" style="width:20px;border:0;vertical-align: middle;"/> My Account </a> <br>
          <a href="../ProvideTrackingAndAnalysis/RunnerDeliveryList.php"> <img src="../../images/GUIImages/order.png" style="width:20px;border:0;vertical-align: middle;"/> Delivery List </a> <br>
          <a href="../ProvideTrackingAndAnalysis/RunnerDeliveryStatus.php"> <img src="../../images/GUIImages/road.png" style="width:20px;border:0;vertical-align: middle;"/> Delivery Status</a> <br>
          <a href="../ProvideTrackingAndAnalysis/RunnerReport.php"> <img src="../../images/GUIImages/summary.png" style="width:20px;border:0;vertical-align: middle;"/> My Report</a> <br>
          <a href="Logout.php"> <img src="../../images/GUIImages/logout.png" style="width:20px;border:0;vertical-align: middle;"/> Logout </a> <br>
        </form>
      </div>

    </tr>
    <tr>
      <td></td>
      <td colspan="2" align="center"> <a href="RunnerHomepage.php" style="margin-right: 40px">Home</a> <a href="../ProvideTrackingAndAnalysis/RunnerDeliveryList.php" style="margin-right: 40px">Delivery List</a> <a href="../ProvideTrackingAndAnalysis/RunnerDeliveryStatus.php" style="margin-right: 40px">Delivery Status</a> <a href="../ProvideTrackingAndAnalysis/RunnerReport.php" style="margin-right: 40px">Report</a></td>
      <td align="center">Welcome <?=$_SESSION['name']?>! (Runner)</td>
  </table>
  <table id="left_part" style="float: left;width:20%" height="80%">
    <tr> <hr>
      <th align="left"> <img src="../../images/GUIImages/user2.png" style="width:20px;border:0"/> My Account </th>
    </tr>
    <tr>
      <td><ul style="list-style-type:none;">
        <li><a href="RunnerProfile.php">Profile</a></li>
        <li><a href="RunnerChangePassword.php">Change Password</a></li>
        <li><a href="RunnerBank.php">Bank Info </a></li>
      </ul></td>
    </tr>
    <tr valign="bottom" height="60%">
      <td> <button type="button" onclick="window.location.href='RunnerHomepage.php'" style="width: 50px;height: 30px"> Back </button></td>
    </tr>
  </table>
  <table id="inside_part" width="80%" height="80%">
    <tr>
      <td width="10%"></td>
      <th align="left" colspan="2" style="font-size: 20px">Bank Info</th>
      <input type="hidden" name="sp_id" value="<?=$sp_id?>">
    </tr> 
    <tr style="height: 60%"><td colspan="3" valign="top">
      <table id="inside_part" border="1" align="center" width="70%" style="text-align: center">
        <tr style="border-bottom:1px solid black;">
          <td>No</td>
          <td>Name</td>
          <td>Account Number</td>
          <td>Bank Account</td>
          <td>Action</td>
        </tr>
        <?php
          $i = 1;
          if($dataCheck == null){
            echo "<tr>"
          . "<td colspan='5'> You  haven't add any bank account yet.</td></tr>";
          }
          else{
          foreach($data as $row){
          echo "<tr>"
          . "<td>".$i."</td>"
          . "<td>".$row['accname']."</td>"
          . "<td>".$row['accnum']."</td>"
          . "<td>".$row['bankname']."</td>";
        ?>
        <form action="" method="POST">
        <td> 
        <input type="hidden" name="acc_id" value="<?=$row['acc_id']?>">
        <button type="submit" style="border:transparent;background:none;vertical-align: middle;" name="delete" onclick="return confirm('Are you sure you want to delete?')"> <img src="../../images/GUIImages/rubbish.png" style="width:30px;height:30px;border:0"/> </button> 
        </td></form>
        <?php
          echo "</tr>";
          $i++;
          } 
          }
        ?>
      </table>
    </td></tr>
    <tr>
      <td colspan="3" valign="bottom" align="right"><input type="button" id="submit_btn" onclick="window.location.href='RunnerAddBank.php'" style="width: 90px;height: 30px" value="Add bank"></td>
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

