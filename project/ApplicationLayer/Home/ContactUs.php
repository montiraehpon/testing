<?php
session_start();

require_once '../../BusinessServicesLayer/userController/userController.php';

$user = new userController();

if(isset($_POST['send'])){
  $user->subject();   
}
?>
<html>
<head>
  <title>Contact us</title>
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
  <table id="detail" height="22.3%" width="100%">
    <tr> <hr>
      <td align="center" rowspan="6"> <img src="../../images/GUIImages/telephone.png" style="width:50px;height:50px;border:0"/></td>
      <td style="text-decoration: underline;"> Call Us </td>
      <td align="center" rowspan="6"> <img src="../../images/GUIImages/email.png" style="width:50px;height:50px;border:0"/></td>
      <td style="text-decoration: underline;"> Drop Us Your Message </td>
      <td align="center" rowspan="6"> <img src="../../images/GUIImages/company.png" style="width:50px;height:50px;border:0"/></td>
      <td style="text-decoration: underline;"> Office Address </td>
    </tr> 
    <tr>
      <td>Main Support Line</td>
      <td>hello@askrunner.com</td>
      <td>AskRunner Sdn.Bhd</td>
    </tr>
    <tr>
      <td>603-12345678</td>
      <td></td>
      <td>No.10, Lot 32</td>
    </tr>
    <tr>
      <td>Customer Service</td>
      <td></td>
      <td>Jalan Roberson,</td>
    </tr>
    <tr>
      <td>603-87654321</td>
      <td></td>
      <td>50150, Kuala Lumpur</td>
    </tr>
  </table>
  <table id="detail" height=50% width="100%"> 
    <tr>
      <td style="font-size: 20px">Contact Our Team</td>
    </tr>
    <form action="" method="POST">
    <tr>
      <td align="center" colspan="2">Your Name (Required)</td>
      <td align="center" colspan="2">Subject</td>
    </tr>
    <tr>
      <td align="center" colspan="2"><input type="text" name="name" size="40" placeholder="Your name here" required></td>
      <td align="center" colspan="2"><input type="text" name="enquiry" size="40" placeholder="Enquiry" required></td>
    </tr>
     <tr>
      <td align="center" colspan="2">Your Email (Required)</td>
      <td align="center" colspan="2">Your Message</td>
    </tr>
    <tr>
      <td align="center" colspan="2"><input type="text" name="email" size="40" placeholder="Your mail here" required></td>
      <td align="center" colspan="2" rowspan="3"><textarea name="message" placeholder="Your message here" rows="5" cols="30" required></textarea></td>
    </tr>
    <tr>
      <td align="center" colspan="2">Mobile Number (Required)</td>
    </tr>
    <tr>
      <td align="center" colspan="2"><input type="text" name="phone_num" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" size="40" placeholder="Your mobile no" required></td>
    </tr>
    <tr>
      <td colspan="4" align="center"> <input type="submit" name="send" value="Send" style="width:50px;height:30px"></td>
    </tr>
    </form>
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
