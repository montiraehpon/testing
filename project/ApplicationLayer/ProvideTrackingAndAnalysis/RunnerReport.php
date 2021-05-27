<?php
session_start();

require_once '../../BusinessServicesLayer/trackController/trackController.php';
$track = new trackController();
$rn_id = $_SESSION["id"];

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}
$data = $track->rn_rpt($rn_id);
$datacheck = $track->rn_rpt_check($rn_id);
?>
<html>
<head>
  
  <title>My Report</title>
  <link href="../../css/design.css" rel="stylesheet" >
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
  </table><hr>
  <table align="center">
    <tr ><td><h2 >My Commission Report</h2></td></tr>
  </table>
  <table id="scd_detail" width="70%" height="70%" align="center" rules="all">
    <tr style="border-bottom: 1px solid black;height: 8%"> <hr>
        <td align="center" width="20%%">Order ID</td>
        <td align="center" width="30%">Drop Date and Time</td>
        <td align="center" width="20%">Commission(RM)</td>
    </tr>
    <?php
    $subtotal=0;
      if($datacheck == 0){
        echo "<tr>
        <td colspan='3' align='center'> <h1>No delivery made</h1></td>
        </tr>
        </table>";
      }
      else{
        $subtotal = 0;
      foreach($data as $row){ 
        $rn_commission=5;
        $subtotal += $rn_commission;

    ?>
      <tr>
        <td align="center">ODR<?=$row["order_id"]?></td>
        <td align="center"><?=$row["order_droptime"]?></td>
        <td align="center">RM <?=$rn_commission?></td>
      </tr>
    <?php }} ?>
    <tr style="height: 5%">
        <td colspan="2" align="right" style="font-size: 25px">Total Commissions</td>
        <td align="center">RM <?=$subtotal?></td>
      </tr>
    
    <table>
      <tr>
      <td><button type="button" name="back" onclick="window.location.href='../ManageUser/RunnerHomepage.php'"> Back </button></td>
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
        url:'RunnerReport.php',
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
