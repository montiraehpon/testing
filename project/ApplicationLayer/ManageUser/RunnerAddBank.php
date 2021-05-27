<?php
session_start();

require_once '../../BusinessServicesLayer/userController/userController.php';

$user = new userController();
$rn_id= $_SESSION["id"];

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}

if(isset($_POST['save'])){
  $user->rn_bankAdd($rn_id);   
}

?>
<html>
<head>
  <title>Add bank</title>
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
  <form action="" method="POST">
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
      <td> <button type="button" onclick="window.location.href='RunnerBank.php'" style="width: 50px;height: 30px"> Back </button></td>
    </tr>
  </table>
  <table id="inside_part" width="80%" height="80%">
    <tr>
      <th width="10%"></th>
      <th align="left" colspan="2" style="font-size: 20px">Bank Info</th>
      <input type="hidden" name="rn_id" value="<?=$rn_id?>">
    </tr> 
    <tr>
      <td colspan="3" align="center"> Please enter your bank details to receive payment.</td>
    </tr>
    <tr>
      <td colspan="3"> 
        <table width="70%" align="center" cellpadding="15px">
          <tr>
            <td align="right" width="20%">Full Name : </td>
            <td align="center"><input type="text" name="accname" placeholder="Full name for your bank account" size="30" required></td>
          </tr>
          <tr>
            <td align="right">Account Number : </td>
            <td align="center"><input type="text" name="accnum" size="30" placeholder="Numbers only" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required></td>
          </tr>
          <tr>
            <td align="right">Bank Name : </td>
            <td align="center"><select name="bankname" required>
                    <option value="Affin Bank Berhad"> Affin Bank Berhad</option>
                    <option value="Alliance Bank Malaysia Berhad"> Alliance Bank Malaysia Berhad</option>
                    <option value="AmBank (M) Berhad"> AmBank (M) Berhad</option>
                    <option value="CIMB Bank Berhad"> CIMB Bank Berhad</option>
                    <option value="Citibank Berhad"> Citibank Berhad</option>
                    <option value="HSBC Bank Malaysia Berhad"> HSBC Bank Malaysia Berhad</option>
                    <option value="Hong Leong Bank Berhad"> Hong Leong Bank Berhad</option>
                    <option value="J.P. Morgan Chase Bank Berhad"> J.P. Morgan Chase Bank Berhad</option>
                    <option value="Malayan Banking Berhad"> Malayan Banking Berhad</option>
                    <option value="OCBC Bank (Malaysia) Berhad"> OCBC Bank (Malaysia) Berhad</option>
                    <option value="Public Bank Berhad"> Public Bank Berhad</option>
                    <option value="RHB Bank Berhad"> RHB Bank Berhad</option>
                    <option value="Standard Chartered Bank Malaysia Berhad"> Standard Chartered Bank Malaysia Berhad</option>
                    </select></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr align="center" valign="bottom">
      <td colspan="3"><input id="submit_btn" type="submit" name="save" value="Save" style="width: 50px;height: 30px"></td>
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

