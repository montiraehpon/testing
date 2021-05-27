<?php
session_start();

require_once '../../BusinessServicesLayer/userController/userController.php';

$user = new userController();

if(isset($_SESSION["status"]) && $_SESSION["status"] == "truesp"){
    header("location: ../ManageUser/SPHomepage.php");
    exit;
}
else if(isset($_SESSION["status"]) && $_SESSION["status"] == "truecust"){
    header("location: ../ManageUser/CustomerHomepage.php");
    exit;
}
else if(isset($_SESSION["status"]) && $_SESSION["status"] == "truerun"){
    header("location: ../ManageUser/RunnerHomepage.php");
    exit;
}
else if(isset($_SESSION["status"]) && $_SESSION["status"] == "truead"){
    header("location: ../ManageUser/AdminHomepage.php");
    exit;
}

?>
<html>
<head>
  <title>Speeda</title>
  <link href="../../css/design.css" rel="stylesheet">
</head>
<body bgcolor="#ffffe6">
  <table id="top" height="9%" width="100%">
    <tr height="4%" valign="center">
      <th align="left" width="33.3%"> <img src="../../images/GUIImages/courier.png" width="25" height="25"> Speeda</th>
      <th align="center" > 100% Guaranteed Dispatch </th>
      <th align="right" width="33.3%"> <input type="button" onclick="window.location.href='Login.php'" value="Login" style="margin-right:50px "> <input type="button" onclick="window.location.href='CustomerSignup.php'" value="Sign up"></th>
    </tr>
    <tr height="6.6%">
      <td></td>
      <td colspan="2" valign="center" align="right"> <input type="button" onclick="window.location.href='Homepage.php'" value="Home" style="margin-right:40px">   <input type="button" onclick="window.location.href='About.php'" value="About us" style="margin-right:40px">   <input type="button" onclick="window.location.href='Service.php'" value="Our Service" style="margin-right:40px"> <input type="button" onclick="window.location.href='ContactUs.php'" value="Contact us" style="margin-right:40px">   <input type="button" onclick="window.location.href='Faq.php'" value="FAQ" style="margin-right:50px"></td>
    </tr>
  </table>
  <table id="detail" width="100%" height="80%">
    <tr bgcolor="#e1e1ea"> <hr>
      <td align="center" colspan="4"> <h3> BOOK NOW AND DELIVER TO YOUR HOUSE EVERYDAY </h3> <br> <input type="button" onclick="window.location.href='CustomerSignup.php'" value="SIGN UP NOW" style="width:120px ; height:40px"></td>
    </tr> 
    <tr>
      <td align="center" colspan="4"> <img src="../../images/GUIImages/homepage.png" alt="User" width="200" height="200"> <br></td>
    </tr>
    <tr>
      <td align="center" width="25%"><img src="../../images/GUIImages/hand.png" alt="User" width="80" height="80"></td>
      <td align="center" colspan="2"><img src="../../images/GUIImages/clock.png" alt="User" width="80" height="80"></td>
      <td align="center"><img src="../../images/GUIImages/box.png" alt="User" width="80" height="80"></td>
    </tr>
    <tr>
      <td align="center" > CHEAPEST WAY TO GET IT DONE</td>
      <td align="center" colspan="2" style="width: 50%"> SAVE TIME</td>
      <td align="center" > REQUEST AND DELIVER</td>
    </tr>
    <tr bgcolor="#e1e1ea">
      <td align="center" colspan="2" width="50%"> BECOME A RUNNER <br> <br> <input type="button" onclick="window.location.href='RunnerSignup.php'" value="SIGN UP NOW"></td>
      <td align="center" colspan="2"> BECOME A SERVICE PROVIDER <br> <br> <input type="button" onclick="window.location.href='SPSignup.php'" value="SIGN UP NOW"> </td>
    </tr>
  </table>
  <table id="bottom" height="15%" width="100%">
    <tr> <hr>
      <td valign="center" rowspan="2" width="10%">
        <ul style="list-style-type:none;">
        <li><a href="Homepage.php">Home</a></li>
        <li><a href="CustomerSignup.php">Sign up</a></li>
        <li><a href="Login.php">Login</a></li>
        <li><a href="Faq.php">FAQ</a></li>
        </ul>
      </td>
      <td valign="center" rowspan="2">
        <ul style="list-style-type:none;">
        <li><a href="About.php">About us</a></li>
        <li><a href="RunnerSignup.php">Become a Runner</a></li>
        <li><a href="SPSignup.php">Become a Service Provider</a></li>
        <li><a href="Terms.php">Terms & Conditions</a></li>
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

