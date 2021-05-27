<?php
session_start();

require_once '../../BusinessServicesLayer/userController/userController.php';

$user = new userController();
$rn_id= $_SESSION["id"];
$data = $user->rn_view($rn_id);

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}

if(isset($_POST['update'])){
  $user->rn_update($rn_id);   
}

?>
<html>
<head>
  <title>My Profile</title>
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
  <form action="" method="POST" enctype="multipart/form-data">
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
    <?php
      foreach($data as $row){ 
        if($row['rn_imgpath'] == null){
          $image_src = "../../images/GUIImages/user2.png";
        }
        else{
        $image = $row['rn_imgpath'];
        $image_src = "../../images/UserImages/".$image;
        }

      ?>
    <tr>
      <th align="center" style="font-size: 20px" width="20%">My Profile</th>
      <td align="center"><img src='<?php echo $image_src?>' id="image" width="120" height="120" style="border: 1px solid black;" /></td>
      <input type="hidden" name="rn_id" value="<?=$row['rn_id']?>">
    </tr>
    <tr align="center">
      <td></td>
      <td>File extension: .JPG, .PNG</td>
    </tr>
    <tr align="center">
      <td></td>
      <td><input type="file" name="rn_imgpath"
      onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])"></td>
    </tr>
    <tr>
      <td colspan="2">
        <table width="60%" align="center" cellpadding="10px"> 
          <tr>
            <td align="right">Full Name : </td>
            <td align="center"><input type="text" name="rn_name" size="30" value="<?php echo $row['rn_name']?>" required></td>
          </tr>
          <tr>
            <td align="right">Gender : </td>
            <td align="center"><select name="rn_gender" required>
              <option value="Male" <?php if ($row['rn_gender'] == "Male" ) echo 'selected' ; ?> >Male</option>
              <option value="Female" <?php if ($row['rn_gender'] == "Female" ) echo 'selected' ; ?>>Female</option>
              <option value="Other" <?php if ($row['rn_gender'] == "Other" ) echo 'selected' ; ?>>Other</option></select></td>
          </tr>
          <tr>
            <td align="right">Phone Number : </td>
            <td align="center"><input type="text" name="rn_phone_num" size="30" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" value="<?php echo $row['phone_num']?>" required></td>
          </tr>
          <tr>
            <td align="right">Address : </td>
            <td align="center"><input type="text" name="rn_address" size="30" value="<?php echo $row['rn_address']?>" required></td>
          </tr>
          <tr>
            <td align="right">Email : </td>
            <td align="center"><input type="text" name="email" size="30" value="<?php echo $row['email']?>" readonly></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr align="center" valign="bottom">
      <td colspan="2"><input type="submit" id="submit_btn" name="update" value="Update" style="width: 80px;height: 30px"></td>
    </tr>
    <?php } ?>
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
