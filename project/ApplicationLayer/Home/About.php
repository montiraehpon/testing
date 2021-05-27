<?php
session_start();

require_once '../../BusinessServicesLayer/userController/userController.php';

$user = new userController();

?>
<html>
<head>
  <title>About</title>
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
  <table id="detail" height="60%" width="100%" >
    <tr> <hr>
      <td align="left" colspan="4" height="5%"> <h3> About Ask Runner </h3></td>
    </tr> 
    <tr>
      <td align="center" colspan="4" height="5%"> <h1> A Platform That Can Make Your Life Easier </h1></td>
    </tr>
    <tr>
      <td align="center" width="40%"> <img src="../../images/GUIImages/map.png" alt="User" width="400" height="350"></td>
      <td align="left" width="60%" style="font-size: 20px">We Connect The City. Create Work. <br> <br> Our vision is to empower the city to achieve greater productivity and connectivity in everyday work. <br> For too long, work has been rigid and boring. <br> We, the AskRunner, are doing something different. <br> We believe work is more connected, more flexible and more mobile than ever before. <br> Today, we connect the city to instantly create work opportunities. Say hello to the future of work.  </td>
    </tr>
  </table>
  <table id="scd_detail" height="15%" width="80%" border="1" align="center">
    <tr style="font-size: 20px;">
      <td align="center" width="50%"> OUR VISION </td>
      <td align="center"> OUR MISSION </td>
    </tr>
    <tr style="font-size: 18px">
      <td align="center">To empower businesses to grow without scaling their costs.</td>
      <td align="center">To make sure we provide the best service Malaysia has ever seen. </td>
    </tr>
    <tr style="font-size: 18px">
      <td colspan="4" align="center"> We believe in providing the best service to you to solve all your troubles and provide convenience. </td>
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

