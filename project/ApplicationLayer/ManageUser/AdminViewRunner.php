<?php
session_start();

require_once '../../BusinessServicesLayer/userController/userController.php';

$user = new userController();

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}

if(isset($_POST['getData'])){
  $output = $user->ad_rnData();
  echo $output;
  exit;
}

?>
<html>
<head>
  <title>View Runner</title>
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
  <table id="detail" width="100%" height="70%" align="center">
    <tr> <hr>
      <td width="60%"></td>
      <td align="center">Search: <input type="text" size="20" id="search_box" placeholder="Search name here"> </td>
    </tr>
    <tr>
      <td colspan="2" align="center" style="font-size: 20px">Runner</td>
    </tr>
    <tr height="75%">
      <td colspan="2">
        <div id="content" style="height: 90%"></div>
      </td>
    </tr>
    <tr>
      <td><button type="button" name="back" onclick="window.location.href='AdminHomepage.php'"> Back </button></td>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">

    $(document).ready(function(){
    load_data(2, 1);

    function load_data(getData, page, search = '' ){
      $.ajax({
        url:'AdminViewRunner.php',
        method:"POST",
        data:{getData:getData, page:page, search:search},
        success:function(data){
        $('#content').html(data);

        }
      });
    }

    $(document).on('click', '.page-link', function(){
      var page = $(this).data('page_number');
      var search = $('#search_box').val();
      load_data(2, page, search);
    });

    $('#search_box').keyup(function(){
      var search = $('#search_box').val();
      load_data(2, 1, search);
    });

    });

</script>

