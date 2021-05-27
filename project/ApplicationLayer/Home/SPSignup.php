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

if(isset($_POST['signup'])){
    $user->signup_other(); 
}

?>
<html>
<head>
  <title>Sign up</title>
  <link href="../../css/design.css" rel="stylesheet">
</head>
<body>
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
  <form action="" method="POST">
  <table id="scd_detail" width="40%" height="70%" align="center">
    <tr> <hr>
      <th align="center" colspan="2">Trust in us</th>
    </tr>
    <tr>
      <th align="center" colspan="2">Increase Productivity Without Increasing Your Overheads</th>
    </tr>
    <tr>
      <th align="center" colspan="2">Want To Learn More About AskRunner Business?</th>
    </tr>
    <tr>
      <th align="center" colspan="2">Provide Us With Your Details And We Will Get In Touch With You!</th>
    </tr>
    <tr>
      <td align="right" width="30%">Email: </td>
      <td align="center"><input type="text" name="email" size="30" placeholder="example@example.com" required> </td>
    </tr>
    <tr>
      <td align="right">Password: </td>
      <td align="center"><input type="password" name="password" size="30" required> </td>
    </tr>
    <tr>
      <td align="right">Sign up as: </td>
      <td align="center"><input type="text" name="user_type" size="30" value="Service Provider" readonly> </td>
    </tr>
    <tr>
      <td align="center" colspan="2">By creating this account, you accept our <a href="Terms.php" target="_blank"> Terms of service</a></td>
    </tr>
    <tr>
      <td align="center" colspan="2"> <input type="submit" name="signup" value="Sign Up"> </td>
    </tr>
  </table>
  </form>
  <table id="detail" height="30%" width="100%">
    <tr> <hr>
      <td colspan="4" align="center"> <h2> Join Now! </h2></td>
    </tr>
    <tr>
      <td align="center"><img src="../../images/GUIImages/appraisal.png" style="width:100px;height:100px;border:0"/></td>
      <td align="center"><img src="../../images/GUIImages/email2.png" style="width:100px;height:100px;border:0"/></td>
      <td align="center"><img src="../../images/GUIImages/workshop.png" style="width:100px;height:100px;border:0"/></td>
      <td align="center"><img src="../../images/GUIImages/money.png" style="width:100px;height:100px;border:0"/></td>
    </tr>
    <tr>
      <td align="center">Sign up now!</td>
      <td align="center">Our representative will email you <br> to complete your personal details.</td>
      <td align="center">Complete your training.</td>
      <td align="center">Sign in, sell your product and earn!</td>
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

