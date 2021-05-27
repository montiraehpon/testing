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
  <title>Admin Homepage</title>
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
  <table id="detail" width="60%" height="70%" align="center">
    <tr> <hr>
      <td align="center"> <button type="button" style="width: 120px;height: 120px;" onclick="window.location.href='AdminViewSP.php'"> Service Provider <br> <br> <img src="../../images/GUIImages/user2.png" style="width:50px;height:50px;border:0"/>  </button> </td> 
      <td align="center"> <button type="button" style="width: 120px;height: 120px" onclick="window.location.href='AdminViewRunner.php'"> Runner <br> <br> <img src="../../images/GUIImages/user2.png" style="width:50px;height:50px;border:0"/>  </button> </td> 
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

