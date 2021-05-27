<?php
session_start();

require_once '../../BusinessServicesLayer/userController/userController.php';

$user = new userController();
$cus_id= $_SESSION["id"];
$data = $user->cus_view($cus_id);

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}

if(isset($_POST['update'])){
  $user->cus_update($cus_id);   
}

?>
<html>
<head>
  <title>My Profile</title>
  <link href="../../css/design.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
    $("#cus_button").click(function() {
    $(".cus_form").show();
      });
    });

    $(document).mouseup(function (e) { 
      if ($(e.target).closest(".cus_form").length 
            === 0) { 
        $(".cus_form").hide(); 
      } 
    }); 

  </script>
</head>
<body bgcolor="#ffcccc">
  <form action="" method="POST" enctype="multipart/form-data">
  <table id="top" height="9%" width="100%">
    <tr>
      <th align="left" height="5%" valign="top" width="25%"> <img src="../../images/GUIImages/courier.png" width="25" height="25"> Speeda</th>
      <th align="center" colspan="2" width="50%"> 100% Guaranteed Dispatch </th>
      <th align="right"> <button type="button" id="cus_button" style="border:transparent;background:none;">
                <img src="../../images/GUIImages/user.png" style="width:20px;height:20px;border:0"/></button> 
      </th>

      <div class="cus_form">
        <form action="/action_page.php" class="form-container">
          <a href="CustomerProfile.php"> <img src="../../images/GUIImages/gear.png" style="width:20px;border:0;vertical-align: middle;"/> My Account </a> <br>
          <a href="../ManagePayment/ViewCart.php"> <img src="../../images/GUIImages/supermarket.png" style="width:20px;border:0;vertical-align: middle;"/> My Cart </a> <br>
          <a href="../ProvideTrackingAndAnalysis/MyPurchase.php"> <img src="../../images/GUIImages/sales.png" style="width:20px;border:0;vertical-align: middle;"/> My Purchase </a> <br>
          <a href="../ProvideTrackingAndAnalysis/TrackOrder.php"> <img src="../../images/GUIImages/road.png" style="width:20px;border:0;vertical-align: middle;"/> Track Order </a> <br>
          <a href="Logout.php"> <img src="../../images/GUIImages/logout.png" style="width:20px;border:0;vertical-align: middle;"/> Logout </a> <br>
        </form>
      </div>

    </tr>
    <tr>
      <td></td>
      <td colspan="2" align="center"> <a href="CustomerHomepage.php" style="margin-right: 40px">Home</a> <a href="../ManagePayment/ViewCart.php" style="margin-right: 40px">My Cart</a> <a href="../ProvideTrackingAndAnalysis/MyPurchase.php" style="margin-right: 40px">My Purchase</a> <a href="../ProvideTrackingAndAnalysis/TrackOrder.php" style="margin-right: 40px">Track Order</a></td></td>
      <td align="center">Welcome <?=$_SESSION['name']?>! (Customer)</td>
    </tr>
  </table>
  <table id="left_part" style="float: left;width:20%" height="80%">
    <tr> <hr>
      <th align="left"> <img src="../../images/GUIImages/user2.png" style="width:20px;border:0"/> My Account </th>
    </tr>
    <tr>
      <td><ul style="list-style-type:none;">
        <li><a href="CustomerProfile.php">Profile</a></li>
        <li><a href="CustomerChangePassword.php">Change Password</a></li>
        <li><a href="CustomerBank.php">Bank Info </a></li>
      </ul></td>
    </tr>
    <tr valign="bottom" height="60%">
      <td> <button type="button" onclick="window.location.href='CustomerHomepage.php'" style="width: 50px;height: 30px"> Back </button></td>
    </tr>
  </table>
  <table id="inside_part" width="80%" height="80%">
    <?php
      foreach($data as $row){ 
        if($row['cus_imgpath'] == null){
          $image_src = "../../images/GUIImages/user2.png";
        }
        else{
        $image = $row['cus_imgpath'];
        $image_src = "../../images/UserImages/".$image;
        }

      ?>
    <tr>
      <th align="center" style="font-size: 20px" width="20%">My Profile</th>
      <td align="center"><img src='<?php echo $image_src?>' id="image" width="120" height="120" style="border: 1px solid black;" /></td>
      <input type="hidden" name="cus_id" value="<?=$row['cus_id']?>">
    </tr>
    <tr align="center">
      <td></td>
      <td>File extension: .JPG, .PNG</td>
    </tr>
    <tr align="center">
      <td></td>
      <td><input type="file" name="cus_imgpath"
      onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])"></td>
    </tr>
    <tr>
      <td colspan="2">
        <table width="60%" align="center" cellpadding="10px">
          <tr>
            <td align="right">Username : </td>
            <td align="center"><input type="text" name="username" size="30" value="<?php echo $row['username']?>" required></td>
          </tr>
          <tr>
            <td align="right">Full Name : </td>
            <td align="center"><input type="text" name="cus_name" size="30" value="<?php echo $row['cus_name']?>" required></td>
          </tr>
          <tr>
            <td align="right">Gender : </td>
            <td align="center"><select name="cus_gender" required>
              <option value="Male" <?php if ($row['cus_gender'] == "Male" ) echo 'selected' ; ?> >Male</option>
              <option value="Female" <?php if ($row['cus_gender'] == "Female" ) echo 'selected' ; ?>>Female</option>
              <option value="Other" <?php if ($row['cus_gender'] == "Other" ) echo 'selected' ; ?>>Other</option></select></td>
          </tr>
          <tr>
            <td align="right">Phone Number : </td>
            <td align="center"><input type="text" name="cus_phone_num" size="30" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" value="<?php echo $row['phone_num']?>" required></td>
          </tr>
          <tr>
            <td align="right">Date of birth : </td>
            <td align="center"><input type="date" name="cus_dob" size="30" value="<?php echo $row['cus_dob']?>" required></td>
          </tr>
          <tr>
            <td align="right">Address : </td>
            <td align="center"><input type="text" name="cus_address" size="30" value="<?php echo $row['cus_address']?>" required></td>
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

