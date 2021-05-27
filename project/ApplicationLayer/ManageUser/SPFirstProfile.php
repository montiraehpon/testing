<?php

require_once '../../BusinessServicesLayer/userController/userController.php';

$user = new userController();

$user_idd = $_GET["user_id"];
$tokenn = $_GET["token"];

$data = $user->view($user_idd,$tokenn);

if(isset($_POST['save'])){
  $user->sp_save($user_idd,$tokenn);   
}

?>
<html>
<head>
  <title>Profile</title>
  <link href="../../css/design.css" rel="stylesheet">
</head>
<body bgcolor="#ccd9ff">
  <form action="" method="POST" enctype="multipart/form-data">
  <table id="top" height="9%" width="100%">
    <tr>
      <th align="left" height="5%" valign="top" width="25%"> <img src="../../images/GUIImages/courier.png" width="25" height="25"> Speeda</th>
      <th align="center" colspan="2" width="50%"> 100% Guaranteed Dispatch </th>
      <th></th>
    </tr>
    <tr>
      <td colspan="4" align="center"> <h3> Welcome! Please fill in all the required details (*). </h3> </td>
    </tr>
  </table>
  <table id="inside_part" width="60%" height="70%" align="center">
    <tr> <hr>
      <input type="hidden" name="username" size="30"  value="<?=$row['username']?>">
      <th align="center" style="font-size: 20px" colspan="3">My Profile</th>
    </tr>
    <tr>
      <td align="right">Full Name * : </td>
      <td width="15%"></td>
      <td width="50%" align="left"><input type="text" name="sp_name" size="30" placeholder="Full Name on IC" required></td>
    </tr>
    <tr>
      <td align="right">IC Number * : </td>
      <td></td>
      <td align="left"><input type="text" name="sp_ic" size="30" placeholder="XXXXXXXXXXXX" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required></td>
    </tr>
    <tr>
      <td align="right">IC Photo * : <br> (Front and Back in 1 piece of paper) <br> File Extension: .JPG,.JPEG,.PNG</td>
      <td></td>
      <td align="left"><input type="file" name="sp_icpath" required> </td>
    </tr>
    <?php
      foreach($data as $row){ 
      ?>
    <tr>
      <td align="right">Email : </td>
      <td></td>
      <td align="left"><input type="text" name="email" size="30"  value="<?=$row['email']?>" readonly></td>
    </tr>
    <?php } ?>
    <tr>
      <td align="right">Phone Number : </td>
      <td></td>
      <td align="left"><input type="text" name="sp_phone_num" size="30" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" placeholder="01xxxxxxxx" required></td>
    </tr>
    <tr>
      <td align="right">Address * : </td>
      <td></td>
      <td align="left"><input type="text" name="sp_address" size="30" placeholder="Address" required></td>
    </tr>
    <tr align="center" valign="bottom">
      <td colspan="3"><input id="submit_btn" type="submit" name="save" value="Save" style="width: 70px;height: 40px;font-size: 15px"></td>
    </tr>
  </table>
  </form>
  <table id="bottom" height="5%" width="100%">
    <tr> <hr>
      <td></td>
    </tr>
    <tr>
      <td></td>
    </tr>
    <tr>
      <td align="center" colspan="4"> Speeda Sdn.Bhd (1234567-T) &#169; All Rights Reserved</td> 
    </tr>
  </table>
</body>
</html>

