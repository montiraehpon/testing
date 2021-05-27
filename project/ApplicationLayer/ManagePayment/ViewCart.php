<?php
session_start();

require_once '../../BusinessServicesLayer/orderController/orderController.php';

$order = new orderController();
$cus_id = $_SESSION["id"];
$data = $order->viewCart($cus_id);
$cus_idd = base64_encode($cus_id);
$datacheck = $order->checkCart($cus_id);

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}

if(isset($_POST["delete"])){
  $order->deleteProduct();
}

if(isset($_POST['incqty'])){
  $value = $_POST['product_quantity'] + 1;
  $order = $order->updateQuantity($cus_id,$value);
}

if(isset($_POST['decqty']) && $_POST['product_quantity'] > 0){
  

  $value = $_POST['product_quantity'] - 1;
  if ($_POST['product_quantity'] == 1) 
  {
    $value=1;
  }     
  $order = $order->updateQuantity($cus_id,$value);     
}


?>
<html>
<head>
  <title>My Cart</title>
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
    <tr style="border-bottom: 1px solid black;height: 8%" > <hr>
        <td align="center" colspan="2">Product</td>
        <td align="center">Quantity</td>
        <td align="center">Price (RM)</td>
        <td align="center">Total Price (RM)</td>
    </tr>
    <?php
    if($datacheck == 0){
      echo "<tr>
      <td colspan='5' align='center'><h2>No product yet</h2></td>
      </tr>
      </table>";
    }
    else{
      $subtotal = 0;
      foreach($data as $row){ 

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
        
        $total_price = ($row["product_quantity"] * $row["product_price"]);

        $subtotal += $total_price;

        
    ?>

      <tr >
        <td width="20%"><img src="<?php echo $image_src?>" style="width: 100px;height: 100px;vertical-align: middle;"></td>
        <td><?=$row["product_name"]?></td>
        <form action="" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $row["product_id"]?>"><input type="hidden" name="product_quantity" value="<?php echo $row["product_quantity"]?>">


        <td align="center" width="15%"><button name='decqty'>-</button>&nbsp;&nbsp;<?=$row["product_quantity"]?>&nbsp;&nbsp;<button name='incqty'>+ </button></td>
        </form>
        <td align="center" width="15%">RM <?=$row["product_price"]?></td>
        <td align="center" width="15%">RM <?=$total_price?> </td>
      </tr>
      <tr style="border-bottom: 1px solid black">
        <form action="" method="POST">
          <td colspan="5" align="right"><input type="hidden" name="product_id" value="<?=$row["product_id"]?>"><button type="submit" id="delete_btn" name="delete" onclick="return confirm('Are you sure you want to delete?')">Delete</button></td></form>
      </tr>
    <?php } ?>
    
      <tr style="height: 5%">
        <td colspan="4" align="right" style="font-size: 25px">Subtotal</td>
        <td align="center">RM <?=$subtotal?></td>
      </tr>
  </table>
  <table width="80%" align="center">
    <tr>
      <td><button type="button" name="back" onclick="window.location.href='../ManageUser/CustomerHomepage.php'"> Back </button></td>
      <td align="right"><form action="" method="POST"><input id="order_btn" type="button" name="order" value="Order Now" onclick="window.location.href='MakePayment.php?cus_id=<?=$cus_idd?>&total=<?=$subtotal?>';"></form></td>
    </tr>
  </table>
<?php } ?>
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

