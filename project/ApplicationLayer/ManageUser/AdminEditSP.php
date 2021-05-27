<?php
session_start();

require_once '../../BusinessServicesLayer/userController/userController.php';

$sp_idd = $_GET["sp_id"];

$user = new userController();
$data = $user->ad_viewSp($sp_idd);

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}

if(isset($_POST['update'])){
  $output = $user->ad_spStatus();
}

?>
<html>
<head>
  <title>Edit SP</title>
  <link href="../../css/design.css" rel="stylesheet">
</head>
<body bgcolor="#98b2e6">
  <table id="top" height="9%" width="100%">
    <tr>
      <th align="left" width="25%"> <img src="../../images/GUIImages/courier.png" alt="User" width="25" height="25"> Speeda</th>
      <th align="center" colspan="2" width="50%"> 100% Guaranteed Dispatch </th>
      <th> <a href="Logout.php"> Logout </a> </th>
    </tr>
    <tr>
      <td colspan="3"></td>
      <td align="center">Welcome <?=$_SESSION['name']?>! (Admin)</td>
    </tr>
  </table>
  <form action="" method="POST">
  <table id="scd_detail" width="50%" height="70%" align="center">
    <tr> <hr>
      <td colspan="3" align="center" style="text-decoration: underline;"> <h3> Information </h3></td>
    </tr>
      <?php
      foreach($data as $row){ 
      ?>
    <tr> 
      <input type="hidden" name="sp_id" value="<?=$row['sp_id']?>">
      <td width="20%"></td>
      <td>Name</td>
      <td>: <?=$row['sp_name']?></td>
    </tr>
    <tr>
      <td></td>
      <td>IC Number</td>
      <td>: <?=$row['sp_ic']?></td>
    </tr>
    <tr>
      <td></td>
      <td>Phone Number</td>
      <td>: <?=$row['phone_num']?></td>
    </tr>
    <tr>
      <td></td>
      <td>Email</td>
      <td>: <?=$row['email']?></td>
    </tr>
    <tr>
       <td></td>
      <td>Address</td>
      <td>: <?=$row['sp_address']?></td>
    </tr>
    <?php } ?>
    <tr>
      <td></td>
      <td>Status</td>
      <td>: <select name="status">
          <option value="Pass" <?php if ($row['status'] == "Pass" ) echo 'selected' ; ?>>Pass</option>
          <option value="Fail" <?php if ($row['status'] == "Fail" ) echo 'selected' ; ?>>Fail</option> </select></td>
    </tr>
    <tr>
      <td></td>
      <td>File</td>
      <td>: <a href="GetFile.php?spic=<?=$row['sp_id']?>">IC photo</a></td>
    </tr>
    <tr>
      <td><button type="button" name="back" onclick="window.location.href='AdminViewSP.php'"> Back </button></td>
      <td colspan="2" align="right"><input type="submit" id="submit_btn" name="update" value="Submit"></td>
    </tr>
  </table>
  </form>
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