<?php
session_start();

require_once '../../BusinessServicesLayer/petController/petController.php';
require_once '../../BusinessServicesLayer/orderController/orderController.php';

$pet_idd = $_GET["pet_id"];
$pet = new petController();
$order = new orderController();
$cus_id = $_SESSION["id"];

$data = $pet->pet_viewProduct($pet_idd);
$data2 = $pet->pet_viewImgProduct($pet_idd);
$data3 = $pet->pet_viewProduct($pet_idd);
$data4 = $pet->pet_viewImgProduct($pet_idd);
$data5 = $pet->pet_viewProduct($pet_idd);

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}


$value = isset($_POST['quantity']) ? $_POST['quantity'] : 1; 
if(isset($_POST['incqty'])){
   $max=$_POST['maxquantity']; //add
   if($_POST['quantity'] <= $max){//add
    $value += 1;
    if ($value > $max)//add
    {
      $value=$max;//add
    }
   }
                                          
}



if(isset($_POST['decqty']) && $_POST['quantity'] > 0){
   $value -= 1; 
   if ($_POST['quantity'] == 1) //add
   $value=1;  //add                                         
}
//else if(isset($_POST['decqty']) && $_POST['quantity'] == 1){
  // $value = 1;                                            
//}

if(isset($_POST['addcart'])){
  $order->addCart($cus_id);
}
?>
<html>
<head>
  <title>Product</title>
  <link href="../../css/design.css" rel="stylesheet">
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
    
    function goBack() {
      window.history.back();
    }

    function openModal() {
      document.getElementById("myModal").style.display = "block";
    }

    function closeModal() {
      document.getElementById("myModal").style.display = "none";
    }

    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
      showSlides(slideIndex += n);
    }

    function currentSlide(n) {
      showSlides(slideIndex = n);
    }

    function showSlides(n) {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      if (n > slides.length) {slideIndex = 1}
      if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      slides[slideIndex-1].style.display = "block";
    }
  </script> 
</head>
<body bgcolor="#ffcccc">
<form action="" method="POST">
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
          <a href="../ManagePetAssist/ViewCart.php"> <img src="../../images/GUIImages/supermarket.png" style="width:20px;border:0;vertical-align: middle;"/> My Cart </a> <br>
          <a href="../ProvideTrackingAndAnalysis/MyPurchase.php"> <img src="../../images/GUIImages/sales.png" style="width:20px;border:0;vertical-align: middle;"/> My Purchase </a> <br>
          <a href="../ProvideTrackingAndAnalysis/TrackOrder.php"> <img src="../../images/GUIImages/road.png" style="width:20px;border:0;vertical-align: middle;"/> Track Order </a> <br>
          <a href="../ManageUser/Logout.php"> <img src="../../images/GUIImages/logout.png" style="width:20px;border:0;vertical-align: middle;"/> Logout </a> <br>
        </form>
      </div>

    </tr>
    <tr>
      <td></td>
      <td colspan="2" align="center"> <a href="../ManageUser/CustomerHomepage.php" style="margin-right: 40px">Home</a> <a href="../ManagePetAssist/ViewCart.php" style="margin-right: 40px">My Cart</a> <a href="../ProvideTrackingAndAnalysis/MyPurchase.php" style="margin-right: 40px">My Purchase</a> <a href="../ProvideTrackingAndAnalysis/TrackOrder.php" style="margin-right: 40px">Track Order</a></td></td>
      <td align="center">Welcome <?=$_SESSION['name']?>! (Customer)</td>
    </tr>
  </table>
  <table id="detail" width="80%" height="80%" align="center">
      <?php
      foreach($data as $row){ 
        $image = $row['pet_coverpath'];
        $image_src = "../../images/PetImages/".$image;
      ?>
      
    <tr style="height: 90%"><hr>
      <td><table style="height: 85%;" align="center">
        <tr>
          <td valign="top">
             <div class="row">
              <div class="column">
                <img src='<?php echo $image_src?>' style="width:100px;height:100px" onclick="openModal();currentSlide(1)" class="hover-shadow cursor"><br><br>
                <?php } ?>
                <?php
                $i = 2;
                foreach($data2 as $row){
                  $image2 = $row['imgpath'];
                  $image_src2 = "../../images/PetImages/".$image2;

                  if($i%5 == 0){
                    echo "<img src='$image_src2' style='width:100px;height:100px' onclick='openModal();currentSlide($i)' class='hover-shadow cursor'> <br>";
                  }
                  else{
                    echo "<img src='$image_src2' style='width:100px;height:100px' onclick='openModal();currentSlide($i)' class='hover-shadow cursor'>";
                  }
                  $i++;
                }
                ?>
              </div>
            </div>

            <div id="myModal" class="modal">
              <span class="close cursor" onclick="closeModal()">&times;</span>
              <div class="modal-content">

              <div class="mySlides">
                <?php
                foreach($data3 as $row){
                  $image = $row['pet_coverpath'];
                  $image_src = "../../images/PetImages/".$image;
                  echo "<img src='$image_src' style='width:100%'>";
                }
                ?>
              </div>

              
                <?php  
                foreach($data4 as $row){
                  $image2 = $row['imgpath'];
                  $image_src2 = "../../images/PetImages/".$image2;
                  echo "<div class='mySlides'><img src='$image_src2' style='width:100%'> </div>";
                } ?>
    
              <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
              <a class="next" onclick="plusSlides(1)">&#10095;</a>

              </div>
            </div>
          </td>
        </tr>
      </table></td>
      <form action="" method="POST"><td style="width: 55%"><table style="height: 100%">
        <?php
      foreach($data5 as $row){ 
        if($row['pet_variation'] == "Food"){
          $show_variation = "Pet Food";
        }
        else if($row['pet_variation'] == "Toy"){
          $show_variation = "Pet Toy";
        }

      ?>
        <tr><input type="hidden" name="id" size="30" value="<?php echo $row['pet_id']?>"><input type="hidden" name="sp_id" size="30" value="<?php echo $row['sp_id']?>"><input type="hidden" name="imgpath" size="30" value="<?php echo $row['pet_coverpath']?>"><input type="hidden" name="type" size="30" value="Pet">
          <td width="20%">Product Name </td>
          <td>: <?=$row['pet_name']?> <input type="hidden" name="name" size="30" value="<?php echo $row['pet_name']?>"></td>
        </tr>
        <tr>
          <td>Product Price</td>
          <td>: RM <?=$row['pet_price']?> <input type="hidden" name="price" size="30" value="<?php echo $row['pet_price']?>"> </td>    
        </tr>
        <tr>
          <td>Quantity</td>
          <td>: <button name='decqty'>-</button>
        <input type='number' size='1' min= "1"  max="<?=$row["pet_quantity"]?>" name='quantity'  value='<?= $value; ?>'/> <! -- add -->
        <button name='incqty'>+</button>&nbsp; &nbsp; <?=$row["pet_quantity"]?> Available</td>
                <input type='hidden' name='maxquantity'  value="<?php echo $row['pet_quantity']?>"/> <! -- add -->
        </tr>
        <tr>
          <td>Variation</td>
          <td>: <?=$show_variation?></td>
        </tr>
        <tr>
          <td>Product Details</td>
          <td>: <?=$row['pet_detail']?></td>
        </tr>
      </table></td>
    </tr>
    <tr style="border-top: 1px solid black">
      <td><input type='hidden' name='maxquantity'  value="<?php echo $row['pet_quantity']?>"/> <button type="button" name="back" onclick="window.location.href='ViewProduct.php?pet_variation=<?php echo $row['pet_variation']?>'"> Back </button></td>
        <?php }?>
      <td width="50%" align="right"><input type="submit" id="submit_btn" name="addcart" value="Add to cart"></td></form>
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
  </form>
</body>
</html>

