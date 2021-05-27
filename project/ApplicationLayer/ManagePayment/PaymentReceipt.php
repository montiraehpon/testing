<?php
session_start();

require_once '../../BusinessServicesLayer/orderController/orderController.php';

$order = new orderController();
$cus_id = $_SESSION["id"];
$data = $order->viewCart($cus_id);

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}

if(isset($_POST["track"])){
  $order->trackOrder($cus_id);
}

?>
<html>
<head>
  <title>Payment Receipt</title>
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
      <th></th>

    </tr>
    <tr>
      <td colspan="4" align="center"><h2>Thank you for your purchase!</h2></td>
    </tr>
  </table>
  <table id="scd_detail" width="70%" height="70%" align="center" >
    <tr style="border-bottom: 1px solid black;height: 8%"> <hr>
        <td align="center" colspan="2">Product</td>
        <td align="center">Quantity</td>
        <td align="center">Price (RM)</td>
    </tr>
    <?php
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
        
        $total = $row["total_price"];
    ?>
      <tr style="border-top: 1px solid black">
        <td width="20%"><img src="<?php echo $image_src?>" style="width: 100px;height: 100px;vertical-align: middle;"></td>
        <td><?=$row["product_name"]?></td>
        <td align="center" width="15%"><?=$row["product_quantity"]?></td>
        <td align="center" width="15%">RM <?=$row["product_price"]?></td>
      </tr>
    <?php } ?>
      <tr valign="bottom" style="border-top: 1px solid black;height: 10%">
        <td colspan="3" align="right" style="font-size: 25px">Total</td>
        <td align="center">RM <?php echo $total?></td>
      </tr>
  </table>
  <table align="center">
    <tr>
        <form action="" method="POST">
        <td align="center"><input id="button" type="submit" name="track" value="Track Order"></td>
        </form>
      </tr>
  </table>
  <table id="bottom" height="15%" width="100%">
    <tr><hr>
      <td align="center" colspan="4"> Speeda Sdn.Bhd (1234567-T) &#169; All Rights Reserved</td> 
    </tr>
  </table>
</body>
</html>

