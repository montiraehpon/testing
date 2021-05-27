<?php
session_start();

require_once '../../BusinessServicesLayer/trackController/trackController.php';

$track = new trackController();

date_default_timezone_set("Asia/Kuala_Lumpur");
$date = date("Y-m-d");
$rn_id = $_SESSION["id"];
$data = $track->checkList($date);
$checkDate = $track->checkDate($date);
$getRunner = $track->getRunner($rn_id);

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}

if($getRunner > 0){
  $message = "You only can accept ONE delivery at the same time.";
  echo "<script type='text/javascript'>alert('$message');
  window.location = '../ManageUser/RunnerHomepage.php';</script>";
  exit;
}

if(isset($_POST["view"])){
  $track->goDetail();
}

?>
<html>
<head>
  <title>Delivery List</title>
  <link href="../../css/design.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
    $("#rn_button").click(function() {
    $(".rn_form").show();
      });
    });

    $(document).mouseup(function (e) { 
      if ($(e.target).closest(".rn_form").length 
            === 0) { 
        $(".rn_form").hide(); 
      } 
    }); 

  </script>
</head>
<body bgcolor="#ffdd99">
  <table id="top" height="9%" width="100%">
    <tr>
      <th align="left" height="5%" valign="top" width="25%"> <img src="../../images/GUIImages/courier.png" width="25" height="25"> Speeda</th>
      <th align="center" colspan="2" width="50%"> 100% Guaranteed Dispatch </th>
      <th align="right"> <button type="button" id="rn_button" style="border:transparent;background:none;">
                <img src="../../images/GUIImages/user.png" style="width:20px;height:20px;border:0"/></button> 
      </th>

      <div class="rn_form">
        <form action="/action_page.php" class="form-container">
          <a href="../ManageUser/RunnerProfile.php"> <img src="../../images/GUIImages/gear.png" style="width:20px;border:0;vertical-align: middle;"/> My Account </a> <br>
          <a href="RunnerDeliveryList.php"> <img src="../../images/GUIImages/order.png" style="width:20px;border:0;vertical-align: middle;"/> Delivery List </a> <br>
          <a href="RunnerDeliveryStatus.php"> <img src="../../images/GUIImages/road.png" style="width:20px;border:0;vertical-align: middle;"/> Delivery Status</a> <br>
          <a href="RunnerReport.php"> <img src="../../images/GUIImages/summary.png" style="width:20px;border:0;vertical-align: middle;"/> My Report</a> <br>
          <a href="../ManageUser/Logout.php"> <img src="../../images/GUIImages/logout.png" style="width:20px;border:0;vertical-align: middle;"/> Logout </a> <br>
        </form>
      </div>

    </tr>
    <tr>
      <td></td>
      <td colspan="2" align="center"> <a href="../ManageUser/RunnerHomepage.php" style="margin-right: 40px">Home</a> <a href="RunnerDeliveryList.php" style="margin-right: 40px">Delivery List</a> <a href="RunnerDeliveryStatus.php" style="margin-right: 40px">Delivery Status</a> <a href="RunnerReport.php" style="margin-right: 40px">Report</a></td>
      <td align="center">Welcome <?=$_SESSION['name']?>! (Runner)</td>
  </table>
  <table id="scd_detail" width="50%" height="70%" align="center" rules="all">
    <tr height="8%"><hr>
      <td align="center">No</td>
      <td align="center">Date</td>
      <td align="center">Service Provider</td>
      <td align="center">View</td>
    </tr>
    <?php
      if($checkDate == null){
        echo "<tr height='95%'><td colspan='4' align='center'><h1>No list yet</h1></td></tr>";
      }
      else{
      $i = 1;
      foreach ($data as $row) {
    ?>
      <tr>
        <td align="center"><?=$i?></td>
        <td align="center"><?=$date?></td>
        <td align="center"><?=$row["sp_id"]?></td>
        <form action="" method="POST">
        <td align="center">
          <input type="hidden" name="sp_id" value="<?php echo $row["sp_id"]?>"><input type="submit" name="view" id="button" value="View"></td></form>
      </tr>
    <?php
      $i++;
    }}
    ?>
  </table>
  <button type="button" name="back" onclick="window.location.href='../ManageUser/RunnerHomepage.php'"> Back </button>
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

