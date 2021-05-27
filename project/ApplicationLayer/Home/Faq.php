<?php
session_start();

require_once '../../BusinessServicesLayer/userController/userController.php';

$user = new userController();

?>
<html>
<head>
  <title>FAQ</title>
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
  <table id="detail" width="80%" height="70%" align="center">
    <tr> <hr>
      <td align="center" colspan="4"> <h3> What can we help? </h3> </td>
    </tr> 
    <tr>
      <td colspan="4" style="font-size: 20px;text-decoration: underline;"> Frequent Questions</td>
    </tr>
    <tr>
      <td valign="top" width="50%" colspan="2">
        <ul style="list-style-type:disc">
        <li style="margin: 20px"><a href="Terms.php">How do I place order?</a></li>
        <li style="margin: 20px"><a href="Terms.php">Can I cancel my booking?</a></li>
        <li style="margin: 20px"><a href="Terms.php">How can I login to Ask Runner account?</a></li>
        <li style="margin: 20px"><a href="Terms.php">How does Ask Runner protect our data?</a></li>
        </ul>
      </td>
      <td valign="top" colspan="2">
        <ul style="list-style-type:disc">
        <li style="margin: 20px"><a href="Terms.php">How soon will I get my refund afer cancelled my booking?</a></li>
        <li style="margin: 20px"><a href="Terms.php">How do I update my profile on Ask Runner?</a></li>
        <li style="margin: 20px"><a href="Terms.php">How can I track my order's booking status?</a></li>
        <li style="margin: 20px"><a href="Terms.php">What is the average prepare time for shipping?</a></li>
        </ul>
      </td>
    </tr>
    <tr>
      <td valign="top" height="5%" colspan="4" style="font-size: 20px;text-decoration: underline;">Categories </td>
    </tr>
    <tr>
      <td align="center"> <button type="button" name="sortname" style="width: 100px;height: 95px" onclick="location.href='Terms.php'">
                 <img src="../../images/GUIImages/user1.png" style="width:50px;height:50px;border:0"/> <br>
                 My Account</button> </td> 
      <td align="center"> <button type="button" name="sortname" style="width: 100px;height: 95px" onclick="location.href='Terms.php'">
                 <img src="../../images/GUIImages/bank.png" style="width:50px;height:50px;border:0"/> <br>
                 Payments </button> </td> 
      <td align="center"> <button type="button" name="sortname" style="width: 100px;height: 95px" onclick="location.href='Terms.php'">
                 <img src="../../images/GUIImages/homepage.png" style="width:50px;height:50px;border:0"/> <br>
                 Shipping & Delivery </button> </td> 
      <td align="center"> <button type="button" name="sortname" style="width: 100px;height: 95px" onclick="location.href='Terms.php'">
                 <img src="../../images/GUIImages/refund.png" style="width:50px;height:50px;border:0"/> <br>
                 Returns & Refunds </button> </td> 
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

