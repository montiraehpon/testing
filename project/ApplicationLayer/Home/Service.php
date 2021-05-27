<?php
session_start();

require_once '../../BusinessServicesLayer/userController/userController.php';

$user = new userController();

?>
<html>
<head>
  <title>Our service</title>
  <link href="../../css/design.css" rel="stylesheet">
</head>
<body bgcolor="#ffffe6">
  <table id="top" height="9%" width="100%">
    <tr height="4%" valign="center">
      <th align="left" width="33.3%"> <img src="../../images/GUIImages/courier.png" width="25" height="25"> Speeda</th>
      <th align="center" > 100% Guaranteed Dispatch </th>
      <th align="right" width="33.3%"> <input type="button" onclick="window.location.href='Login.php'" value="Login" style="margin-right:50px "> <input type="button" onclick="window.location.href='CustomerSignup.php'" value="Sign up"></th>
    </tr>
    <tr height="6.6%">
      <td></td>
      <td colspan="2" valign="center" align="right"> <input type="button" onclick="window.location.href='Homepage.php'" value="Home" style="margin-right:40px">   <input type="button" onclick="window.location.href='About.php'" value="About us" style="margin-right:40px">   <input type="button" onclick="window.location.href='Service.php'" value="Our Service" style="margin-right:40px"> <input type="button" onclick="window.location.href='ContactUs.php'" value="Contact us" style="margin-right:40px">   <input type="button" onclick="window.location.href='Faq.php'" value="FAQ" style="margin-right:50px"></td>
    </tr>
  </table>
  <table id="detail" width="100%" height="80%">
    <tr> <hr>
      <td align="center" colspan="4" height="5%"> <h3> What we do? </h3></td>
    </tr> 
    <tr>
      <td align="center" colspan="4" style="font-size: 20px">We deliver throughout Kuantan City.</td>
    </tr>
    <tr>
      <td align="center"> <button type="button" name="sortname" style="width:80px;border:transparent;background:none;" onclick="location.href='CustomerSignup.php'">
                 <img src="../../images/GUIImages/food.png" style="width:50px;height:50px;border:0"/> <br>
                 Food Delivery </button></td> 
      <td align="center"> <button type="button" name="sortname" style="width:80px;border:transparent;background:none;" onclick="location.href='CustomerSignup.php'">
                 <img src="../../images/GUIImages/groceries.png" style="width:50px;height:50px;border:0"/> <br>
                 Goods Delivery </button></td> 
      <td align="center"> <button type="button" name="sortname" style="width:80px;border:transparent;background:none;" onclick="location.href='CustomerSignup.php'">
                 <img src="../../images/GUIImages/pet-food.png" style="width:50px;height:50px;border:0"/> <br>
                 Pet Assist </button></td> 
      <td align="center"> <button type="button" name="sortname" style="width:80px;border:transparent;background:none;" onclick="location.href='CustomerSignup.php'">
                 <img src="../../images/GUIImages/medicine.png" style="width:50px;height:50px;border:0"/> <br>
                 Medical Delivery </button></td> 
    </tr>
    <tr align="center">
      <td colspan="2"><h3>How it works?</h3></td>
      <td rowspan="4" colspan="2">
        <div class="slideshow-container">
          <div class="mySlides fade">   
            <img src="../../images/GUIImages/1.png" style="width: 250;height: 250px">
          </div>
          <div class="mySlides fade">   
            <img src="../../images/GUIImages/2.png" style="width: 250;height: 250px">
          </div>
          <div class="mySlides fade">   
            <img src="../../images/GUIImages/3.png" style="width: 250;height: 250px">
          </div>
          </div></td>
    </tr>
    <tr align="center">
      <td colspan="2"><img src="../../images/GUIImages/choose.png" style="width:50px;height:50px;border:0"/> Choose your service </td>
    </tr>
    <tr align="center">
      <td colspan="2"><img src="../../images/GUIImages/tap.png" style="width:50px;height:50px;border:0"/> Pick what you want </td>
    </tr>
    <tr align="center">
      <td colspan="2"><img src="../../images/GUIImages/bank.png" style="width:50px;height:50px;border:0"/> Pay your order</td>
    </tr>
    <tr align="center">
      <td colspan="2"><img src="../../images/GUIImages/hourglass.png" style="width:50px;height:50px;border:0"/> Wait for the delivery </td>
      <td colspan="2"><div style="text-align:center">
          <span class="dot"></span> 
          <span class="dot"></span> 
          <span class="dot"></span> 
      </div></td>
    </tr>
  </table>
  <table id="bottom" height="15%" width="100%">
    <tr> <hr>
      <td valign="center" rowspan="2" width="10%">
        <ul style="list-style-type:none;">
        <li><a href="Homepage.php">Home</a></li>
        <li><a href="CustomerSignup.php">Sign up</a></li>
        <li><a href="Login.php">Login</a></li>
        <li><a href="Faq.php">FAQ</a></li>
        </ul>
      </td>
      <td valign="center" rowspan="2">
        <ul style="list-style-type:none;">
        <li><a href="About.php">About us</a></li>
        <li><a href="RunnerSignup.php">Become a Runner</a></li>
        <li><a href="SPSignup.php">Become a Service Provider</a></li>
        <li><a href="Terms.php">Terms & Conditions</a></li>
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
<script>
  var slideIndex = 0;
  showSlides();

  function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");

    for (i = 0; i < slides.length; i++){
      slides[i].style.display = "none";  
    }

    slideIndex++;

    if (slideIndex > slides.length){
      slideIndex = 1
    }    

    for (i = 0; i < dots.length; i++){
      dots[i].className = dots[i].className.replace(" active", "");
    }

    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 2000); // Change image every 2 seconds
    }
</script>
</html>

