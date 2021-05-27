<?php
session_start();

require_once '../../BusinessServicesLayer/userController/userController.php';

$user = new userController();

$user_idd = $_SESSION["user_id"];

$data = $user->cus_firstView($user_idd);

if(isset($_POST['save'])){
  $user->cus_save($user_idd);   
}

?>
<html>
<head>
  <title>Profile</title>
  <link href="../../css/design.css" rel="stylesheet">
</head>
<body bgcolor="#ffcccc">
  <form action="" method="POST" enctype="multipart/form-data">
  <table id="top" height="9%" width="100%">
    <tr>
      <th align="left" height="5%" valign="top" width="25%"> <img src="../../images/GUIImages/courier.png" width="25" height="25"> Speeda</th>
      <th align="center" colspan="2" width="50%"> 100% Guaranteed Dispatch </th>
      <th></th>
    </tr>
    <tr>
      <td colspan="4" align="center"> <h3> Welcome!  Please fill in all the required details (*). </h3> </td>
    </tr>
  </table>
  <table id="inside_part" width="60%" height="90%" align="center">
    <tr> <hr>
      <th align="center" style="font-size: 20px" colspan="4">My Profile</th>
    </tr>
    <tr>
      <td align="right">Username * : </td>
      <td><input type="text" name="username" size="30" placeholder="Username will be display on public" required></td>
      <td width="7%"></td>
      <td>Profile picture : <input type="file" name="cus_imgpath"
      onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])"> </td>
    </tr>
    <tr>
      <td align="right">Full Name * : </td>
      <td align="left"><input type="text" name="cus_name" size="30" placeholder="Full Name on IC" required></td>
      <td colspan="2" rowspan="3" align="center"> <table align="center"><tr><td><img id="image" width="160" height="160"/> </td></tr></table> <br> File Extension: .JPG,.JPEG,.PNG </td>
    </tr>
    <tr>
      <td align="right">Gender * : </td>
      <td align="left"><select name="cus_gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option></select> </td>   
    </tr>
    <tr>
      <td align="right">Date of birth * : </td>
      <td align="left"><input type="date" name="cus_dob" size="30" placeholder="Full Name" required></td>
    </tr>
    <tr>
      <?php
        foreach($data as $row){ 
      ?>
      <td align="right">Email : </td>
      <td align="left"><input type="text" name="email" size="30"  value="<?=$row['email']?>" readonly></td>
      <td colspan="2"></td>
      <?php } ?>      
    </tr>
    <tr>
      <td align="right">Phone Number * : </td>
      <td align="left"><input type="text" name="cus_phone_num" size="30" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" placeholder="01xxxxxxxx" required></td>
      <td colspan="2"></td>
    </tr>
    <tr>
      <td align="right">Address * : </td>
      <td align="left"><input type="text" name="cus_address" size="30" placeholder="Address" required></td>
      <td colspan="2"></td>
    </tr>
    <tr align="center" valign="bottom">
      <td colspan="4"><input id="submit_btn" type="submit" name="save" value="Save" style="width: 70px;height: 40px;font-size: 15px"></td>
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