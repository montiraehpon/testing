<?php
session_start();

require_once '../../BusinessServicesLayer/userController/userController.php';

$user = new userController();

?>
<html>
<head>
  <title>Terms</title>
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
  <table id="thd_detail" width="80%" height=auto align="center">
    <tr> <hr>
      <td> <h3> Terms & Conditions </h3></td>
    </tr>
    <tr>
      <td>1.1 Welcome to the AskRunner.com.my website. These Terms of Use govern your access and use of the Platform and the use of any services, information and functions made available by us at the Platform (“Services”). Before using this Platform or the Services, you must read carefully and accept these Terms of Use and all other terms and conditions and policies pertaining to the use of the Platform and/or the Services (collectively referred to as AskRunner Terms and Conditions”) and you must consent to the processing of your personal data as described in the Privacy Policy set out at https://www.AskRunner.com.my/privacy-policy/. By accessing the Platform and/or using the Services, you agree to be bound by AskRunner Terms and Conditions and any amendments to the foregoing issued by us from time to time. If you do not agree to AskRunner Terms and Conditions and the Privacy Policy, do not access and/or use this Platform and/or the Services.</td>
    </tr>
    <tr>
      <td> <br> 1.2 AskRunner reserves the right, to change, modify, add, or remove portions of these Terms of Use and/or AskRunner Terms and Conditions at any time. Changes will be effective when posted on the Platform with no other notices provided and you are deemed to be aware of and bound by any changes to the foregoing upon their publication on the Platform.</td>
    </tr>
    <tr>
      <td> <br> 1.3 If you are under the age of 18 or the legal age for giving consent hereunder pursuant to the applicable laws in your country (the “legal age”), you must obtain permission from your parent(s) or legal guardian(s) to open an account on the Platform. If you are the parent or legal guardian of a minor who is creating an account, you must accept and comply with these Terms of Use on the minor's behalf and you will be responsible for the minor’s actions, any charges associated with the minor’s use of the Platform and/or Services or purchases made on the Platform. If you do not have consent from your parent(s) or legal guardian(s), you must stop using/accessing this Platform and/or Services.</td>
    </tr>
    <tr>
      <td> <br> 1.4 Content provided on this Platform is solely for informational purposes. Product representations expressed on this Platform are those of the vendor and are not made by us. Submissions or opinions expressed on this Platform are those of the individual posting such content and may not reflect our opinions.</td>
    </tr>
    <tr>
      <td> <br> 1.5 Lazada and all of its respective officers, employees, directors, agents, contractors and assigns shall not be liable to you for any losses whatsoever or howsoever caused (regardless of the form of action) arising directly or indirectly in connection with:<br>(a) any access, use and/or inability to use the Platform or the Services; <br>(b) reliance on any data or information made available through the Platform and/or through the Services. You should not act on such data or information without first independently verifying its contents;<br>(c) any system, server or connection failure, error, omission, interruption, delay in transmission, computer virus or other malicious, destructive or corrupting code, agent program or macros; and <br>(d) any use of or access to any other website or webpage linked to the Platform, even if we or our officers or agents or employees may have been advised of, or otherwise might have anticipated, the possibility of the same.</td>
    </tr>
    <tr>
      <td> <br> 1.6 Risk of damage to or loss of the Goods shall pass to the Buyer at the time of delivery or if the Buyer wrongfully fails to take delivery of the Goods, the time when AskRunner has tendered delivery of the Goods.</td>
    </tr>
    <tr>
      <td> <br> 1.7 Neither AskRunner nor Seller shall be liable for non-performance, error, interruption or delay in the performance of its obligations under these Conditions (or any part thereof) or for any inaccuracy, unreliability or unsuitability of the Platform's and/or Services’ contents if this is due, in whole or in part, directly or indirectly to an event or failure which is beyond AskRunner's or Seller’s reasonable control.</td>
    </tr>
    <tr>
      <td> <br> 1.8 The Buyer shall indemnify Lazada against all loss damages costs expenses and legal fees incurred by the Buyer in connection with the assertion and enforcement of Lazada's rights under this condition.</td>
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
