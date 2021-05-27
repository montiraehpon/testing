<?php
session_start();

require_once '../../BusinessServicesLayer/orderController/orderController.php';

$order = new orderController();
$cus_idd = $_GET['cus_id'];
$total_price = $_GET['total'];

$data = $order->viewCusDetail($cus_idd);
$data2 = $order->showCart($cus_idd);

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}

if(isset($_POST["continue"])){
  if($_POST["bank"] == "bankislam"){
    echo "<script type='text/javascript'>window.location.href='https://www.bankislam.biz/';</script>";
  }
  else if($_POST["bank"] == "publicbank"){
    echo "<script type='text/javascript'>window.location.href='https://www2.pbebank.com/myIBK/apppbb/servlet/BxxxServlet?RDOName=BxxxAuth&MethodName=login';</script>";
  }
  else if($_POST["bank"] == "maybank"){
    echo "<script type='text/javascript'>window.location.href='https://www.maybank2u.com.my/home/m2u/common/login.do';</script>";
  }
  else if($_POST["bank"] == "rhbbank"){
    echo "<script type='text/javascript'>window.location.href='https://logon.rhb.com.my/';</script>";
  }

}
?>
<html>
<head>
  <title>Make Payment</title>
  <link href="../../css/design.css" rel="stylesheet" >
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
    $("#cus_button").click(function() {
    $(".cus_form").show();
      });
    });

    $(document).mouseup(function (e) { 
      if ($(e.target).closest(".cus_form").length 
            === 0) { 
        $(".cus_form").hide(); 
      } 
    }); 
  </script>
  
</head>
<body bgcolor="#ffcccc">
  <table id="top" height="9%" width="100%">
    <tr>
      <th align="left" height="5%" valign="top" width="25%"> <img src="../../images/GUIImages/courier.png" width="25" height="25"> Speeda</th>
      <th align="center" colspan="2" width="50%"> 100% Guaranteed Dispatch </th>
      <th align="right"> <button type="button" id="cus_button" style="border:transparent;background:none;">
                <img src="../../images/GUIImages/user.png" style="width:20px;height:20px;border:0"/></button> 
      </th>

      <div class="cus_form">
        <form action="/action_page.php" class="form-container">
          <a href="../ManageUser/CustomerProfile.php"> <img src="../../images/GUIImages/gear.png" style="width:20px;border:0;vertical-align: middle;"/> My Account </a> <br>
          <a href="ViewCart.php"> <img src="../../images/GUIImages/supermarket.png" style="width:20px;border:0;vertical-align: middle;"/> My Cart </a> <br>
          <a href="../ProvideTrackingAndAnalysis/MyPurchase.php"> <img src="../../images/GUIImages/sales.png" style="width:20px;border:0;vertical-align: middle;"/> My Purchase </a> <br>
          <a href="../ProvideTrackingAndAnalysis/TrackOrder.php"> <img src="../../images/GUIImages/road.png" style="width:20px;border:0;vertical-align: middle;"/> Track Order </a> <br>
          <a href="../ManageUser/Logout.php"> <img src="../../images/GUIImages/logout.png" style="width:20px;border:0;vertical-align: middle;"/> Logout </a> <br>
        </form>
      </div>

    </tr>
    <tr>
      <td></td>
      <td colspan="2" align="center"> <a href="../ManageUser/CustomerHomepage.php" style="margin-right: 40px">Home</a> <a href="ViewCart.php" style="margin-right: 40px">My Cart</a> <a href="../ProvideTrackingAndAnalysis/MyPurchase.php" style="margin-right: 40px">My Purchase</a> <a href="../ProvideTrackingAndAnalysis/TrackOrder.php" style="margin-right: 40px">Track Order</a></td>
      <td align="center">Welcome <?=$_SESSION['name']?>! (Customer)</td>
    </tr>
  </table>
  <table id="scd_detail" width="70%" height="70%" align="center">
    <?php
        $rn_commission = 5;
        $count = $total_price * 0.06;
        $sst = sprintf('%.2f', $count);
        $totall = $total_price + $sst + $rn_commission;
        $total = number_format($totall, 2); 

      foreach($data as $row){ 
    ?>
    <tr height="10%"><hr>
        <td align="center" colspan="4" style="font-size: 25px；border-top: 1px solid black;text-decoration: underline;">Customer Information</td>
    </tr>
    <tr height="10%">
        <td colspan="2">Name: <?=$row['cus_name']?></td>
        <td width="40%" colspan="2">Phone number: <?=$row['phone_num']?></td>
    </tr>
    <tr >
        <td colspan="4" style="border-bottom: 1px solid black">Delivery Address: <?=$row['cus_address']?></td>
    </tr>
    <?php } ?>
    <tr> 
        <td align="center" colspan="4" style="font-size: 20px">Order Details</td>
    </tr>
    <?php 
        foreach ($data2 as $row){

       	if($row['type'] == "Food"){
          $image = $row['product_imgpath'];
          $image_src = "../../images/FoodImages/".$image;
        }
        else if($row['type'] == "Goods"){
          $image = $row['product_imgpath'];
          $image_src = "../../images/GoodsImages/".$image;
        }
        else if($row['type'] == "Medicine"){
          $image = $row['product_imgpath'];
          $image_src = "../../images/MedicineImages/".$image;
        }
        else if($row['type'] == "Pet"){
          $image = $row['product_imgpath'];
          $image_src = "../../images/PetImages/".$image;
        }

    ?>  
    <tr>
    	<td width="10%"><img src="<?php echo $image_src?>" style="width: 100px;height: 100px;vertical-align: middle;"></td>
        <td width="20%"><?=$row["product_name"]?></td>
        <td><?=$row["product_quantity"]?></td>
        <td>RM <?=$row["product_price"]?> </td>
    </tr>
    <?php } ?>
    <tr >
        <td colspan="4" height="10%" style="border-top: 1px solid black" align="right"> Subtotal: &nbsp;&nbsp;&nbsp;&nbsp;RM <?=$total_price?></td>
    </tr>
    <tr>
        <td colspan="4" height="10%" align="right">Sales and Service Tax (6%): &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RM <?=$sst?></td>
    </tr>
    <tr>
        <td colspan="4" align="right">Delivery Charge: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RM <?=$rn_commission?></td>
    </tr>
    <tr >
        <td colspan="4" align="right" style="border-top: 1px solid black;font-size: 20px;border-bottom: 1px solid black" height="15%"> Total: RM <?=$total?></td>
    </tr>
    <tr>
        <td align="center" style="font-size: 20px" valign="top" height="8%" colspan="4">Payment Method</td>
    </tr>
    <tr>
        <td style="font-size: 18px" colspan="4">PayPal</td>
    </tr>
    <tr>
        <td colspan="4"><div align="center" id="paypal-button-container" ></div></td>
    </tr>
    <tr>
        <td height="8%" style="font-size: 18px" colspan="4">Online Banking</td>
    </tr>
    <tr>
        <td height="5%" colspan="4">Please choose your bank: </td>
    </tr>
       	<form action="" method="POST">
    <tr>
        <td colspan="4"><input type="radio" name="bank" value="bankislam" required><img src="../../images/GUIImages/bankislam.png" width="100px" height="60px"><input type="radio" name="bank" value="publicbank" required><img src="../../images/GUIImages/publicbank.png" width="100px" height="60px"><input type="radio" name="bank" value="maybank" required><img src="../../images/GUIImages/maybank.png" width="100" height="60"><input type="radio" name="bank" value="rhbbank" required><img src="../../images/GUIImages/rhbbank.png" width="100px" height="60px"></td>
    </tr>
    <tr>
        <td align="right" colspan="4"><input id="button" type="submit" name="continue" value="Continue"></td>
    </tr>
      	</form>
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
  <form action="" method="POST">
  <script src="https://www.paypal.com/sdk/js?client-id=AepvQmJz2Fujnwxdw7WVk-6hJKGbC-A6YGNAUyJtArPFRIHpeJgNBF3Ia2SA2VXtm3V5IyMsZih2ZOBx&currency=USD"></script>
  <script>
    var id = "<?php echo $cus_idd?>";
    var pay = "<?php echo $total?>";
    var num = parseInt(pay).toFixed();
    var usd = (num / 4);
    
    paypal.Buttons({
      createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
          amount: {
          value: usd
          }
        }]
        });
      },

      onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
          alert('Transaction Success!');
          window.location.href = 'Proceed.php?cus_id=<?=$cus_idd?>&total=<?=$total?>';
        });
      },

      style:{
      layout: 'horizontal'
      }
    }).render('#paypal-button-container');

  </script>
</form>
</body>
</html>

