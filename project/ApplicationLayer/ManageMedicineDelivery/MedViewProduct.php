<?php
session_start();

require_once '../../BusinessServicesLayer/medController/medController.php';

$med_idd = $_GET["med_id"];
$med = new medController();
$sp_id= $_SESSION["id"];

$data = $med->med_view($sp_id,$med_idd);
$data2 = $med->med_imgView($sp_id,$med_idd);
$data3 = $med->med_view($sp_id,$med_idd);
$data4 = $med->med_imgView($sp_id,$med_idd);

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}

?>
<html>
<head>
  <title>View Med Product</title>
  <link href="../../css/design.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
    $("#sp_button").click(function() {
    $(".sp_form").show();
      });
    });

    $(document).mouseup(function (e) { 
      if ($(e.target).closest(".sp_form").length 
            === 0) { 
        $(".sp_form").hide(); 
      } 
    }); 
    
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
<body bgcolor="#ccd9ff">
<form action="" method="POST">
  <table id="top" height="9%" width="100%">
    <tr>
      <th align="left" height="5%" valign="top" width="25%"> <img src="../../images/GUIImages/courier.png" width="25" height="25"> Speeda</th>
      <th align="center" colspan="2" width="50%"> 100% Guaranteed Dispatch </th>
      <th align="right"> <button type="button" id="sp_button" style="border:transparent;background:none;">
                <img src="../../images/GUIImages/user.png" style="width:20px;height:20px;border:0"/></button> 
      </th>

      <div class="sp_form">
        <form action="/action_page.php" class="form-container">
          <a href="../ManageUser/SPProfile.php"> <img src="../../images/GUIImages/gear.png" style="width:20px;border:0;vertical-align: middle;"/> My Account </a> <br>
          <a href="../ManageUser/SPManageProduct.php"> <img src="../../images/GUIImages/finger.png" style="width:20px;border:0;vertical-align: middle;"/> Manage Product </a> <br>
          <a href="../ProvideTrackingAndAnalysis/SPOrderList.php"> <img src="../../images/GUIImages/order.png" style="width:20px;border:0;vertical-align: middle;"/> Order List </a> <br>
          <a href="../ProvideTrackingAndAnalysis/SPTrackOrder.php"> <img src="../../images/GUIImages/road.png" style="width:20px;border:0;vertical-align: middle;"/> Track Order </a> <br>
          <a href="../ProvideTrackingAndAnalysis/SPReport.php"> <img src="../../images/GUIImages/summary.png" style="width:20px;border:0;vertical-align: middle;"/> My Report</a> <br>
          <a href="../ManageUser/Logout.php"> <img src="../../images/GUIImages/logout.png" style="width:20px;border:0;vertical-align: middle;"/> Logout </a> <br>
        </form>
      </div>

    </tr>
    <tr>
      <td></td>
      <td colspan="2" align="center"> <a href="../ManageUser/SPHomepage.php" style="margin-right: 40px">Home</a> <a href="../ManageUser/SPManageProduct.php" style="margin-right: 40px">Manage Product</a> <a href="../ProvideTrackingAndAnalysis/SPOrderList.php" style="margin-right: 40px">Order List</a> <a href="../ProvideTrackingAndAnalysis/SPTrackOrder.php" style="margin-right: 40px">Track Order</a> <a href="../ProvideTrackingAndAnalysis/SPReport.php">My Report</a></td>
      <td align="center">Welcome <?=$_SESSION['name']?>! (Service Provider)</td>
    </tr>
  <table id="detail" width="80%" height="80%" align="center">
    <tr> <hr>
      <th align="center" colspan="2">View Product</th>
    </tr>
      <?php
      foreach($data as $row){ 
        if($row['med_variation'] == "Vitamin"){
          $show_variation = "Vitamin";
        }
        else if($row['med_variation'] == "Personal"){
          $show_variation = "Personal Care";
        }
        else if($row['med_variation'] == "Food"){
          $show_variation = "Health Food";
        }
        else if($row['med_variation'] == "Tool"){
          $show_variation = "Health Tool";
        }      

        $image = $row['med_coverpath'];
        $image_src = "../../images/MedicineImages/".$image;
      ?>
      <input type="hidden" name="med_id" size="30" value="<?php echo $row['med_id']?>">
    <tr style="height: 90%">
      <td style="width: 65%"><table style="height: 100%">
        <tr>
          <td width="20%">Product Name</td>
          <td>: <?=$row['med_name']?></td>
        </tr>
        <tr>
          <td>Product Price</td>
          <td>: RM <?=$row['med_price']?> </td>    
        </tr>
        <tr>
          <td>Quantity</td>
          <td>: <?=$row['med_quantity']?></td>
        </tr>
        <tr>
          <td>Variation</td>
          <td>: <?=$show_variation?></td>
        </tr>
        <tr>
          <td>Product Details</td>
          <td>: <?=$row['med_detail']?></td>
        </tr>
      </table></td>
      <td><table style="height: auto">
        <tr>
          <td valign="top">
             <div class="row">
              <div class="column">
                Cover image : <br> <br> <img src='<?php echo $image_src?>' style="width:100px;height:100px" onclick="openModal();currentSlide(1)" class="hover-shadow cursor"><br><br>Product images : <br><br>
                <?php } ?>
                <?php
                $i = 2;
                foreach($data2 as $row){
                  $image2 = $row['imgpath'];
                  $image_src2 = "../../images/MedicineImages/".$image2;

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
                  $image = $row['med_coverpath'];
                  $image_src = "../../images/MedicineImages/".$image;
                  echo "<img src='$image_src' style='width:100%'>";
                }
                ?>
              </div>

              
                <?php  
                foreach($data4 as $row){
                  $image2 = $row['imgpath'];
                  $image_src2 = "../../images/MedicineImages/".$image2;
                  echo "<div class='mySlides'><img src='$image_src2' style='width:100%'> </div>";
                } ?>
    
              <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
              <a class="next" onclick="plusSlides(1)">&#10095;</a>

              </div>
            </div>
          </td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td colspan="2"><button type="button" name="back" onclick="window.location.href='MedProduct.php'"> Back </button></td></td>
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

