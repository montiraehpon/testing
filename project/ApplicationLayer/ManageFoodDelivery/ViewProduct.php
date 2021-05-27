<?php
session_start();


require_once '../../BusinessServicesLayer/foodController/foodController.php';

$food = new foodController();

if(!isset($_SESSION["loggedin"])){
  header("location: ../../ApplicationLayer/Home/Homepage.php");
  exit;
}

if(isset($_POST['getData'])){
  $output = $food->food_viewVariation();
  echo $output;
  exit;
}

$fd_variationn = $_GET['fd_variation'];

if($fd_variationn == "Biscuits"){
  $name = "Biscuits & Crackers";
}
else if($fd_variationn == "Noodles"){
  $name = "Noodles";
}
else if($fd_variationn == "Chips"){
  $name = "Potato Chips & Crips";
}
else if($fd_variationn == "Fruits"){
  $name = "Dry Fruits & Nuts";
}
else if($fd_variationn == "Others"){
  $name = "Others";
}


?>
<html>
<head>
  <title>View Product</title>
  <link href="../../css/design.css" rel="stylesheet">
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
          <a href="../ManagePayment/ViewCart.php"> <img src="../../images/GUIImages/supermarket.png" style="width:20px;border:0;vertical-align: middle;"/> My Cart </a> <br>
          <a href="../ProvideTrackingAndAnalysis/MyPurchase.php"> <img src="../../images/GUIImages/sales.png" style="width:20px;border:0;vertical-align: middle;"/> My Purchase </a> <br>
          <a href="../ProvideTrackingAndAnalysis/TrackOrder.php"> <img src="../../images/GUIImages/road.png" style="width:20px;border:0;vertical-align: middle;"/> Track Order </a> <br>
          <a href="../ManageUser/Logout.php"> <img src="../../images/GUIImages/logout.png" style="width:20px;border:0;vertical-align: middle;"/> Logout </a> <br>
        </form>
      </div>

    </tr>
    <tr>
      <td></td>
      <td colspan="2" align="center"> <a href="../ManageUser/CustomerHomepage.php" style="margin-right: 40px">Home</a> <a href="../ManagePayment/ViewCart.php" style="margin-right: 40px">My Cart</a> <a href="../ProvideTrackingAndAnalysis/MyPurchase.php" style="margin-right: 40px">My Purchase</a> <a href="../ProvideTrackingAndAnalysis/TrackOrder.php" style="margin-right: 40px">Track Order</a></td></td>
      <td align="center">Welcome <?=$_SESSION['name']?>! (Customer)</td>
    </tr>
  </table>
  <table width="100%" height="80%" align="center">
    <tr> <hr>
      <th align="center" colspan="3"><h2><?=$name?></h2> <input type="hidden" id="variation" value="<?=$fd_variationn?>"></th>
    </tr>
    <tr>
      <td><img src="../../images/GUIImages/arrows.png" onclick="window.location.href='FoodVariation.php'" style="width: 25px;height: 25px"></td>
      <td align="right">Price: <select id="price">
          <option value="none">None</option>
          <option value="asc">Low to High</option>
          <option value="desc">High to low</option>
          </select></td>
      <td align="center">Search: <input type="text" size="20" id="search_box" placeholder="Search name here"></td>
    </tr>
    <tr>
      <td colspan="3" style="height: auto">
        <div id="food_product"></div>
      </td>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
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

    $(document).ready(function(){
    var variation = "<?php echo $_GET['fd_variation']?>";
    load_data(2, 1, "none", variation);

    function load_data(getData, page, sortPrice = '',variation, search = ''){
      $.ajax({
        url:'ViewProduct.php',
        method:"POST",
        data:{getData:getData, page:page, sortPrice:sortPrice, variation:variation, search:search},
        success:function(data){
        $('#food_product').html(data);

        }
      });
    }

    $(document).on('click', '.page-link', function(){
      var page = $(this).data('page_number');
      var search = $('#search_box').val();
      var sortPrice = $('#price').val();
      var variation = $('#variation').val();
      load_data(2, page, sortPrice, variation, search);
    });

    $('#search_box').keyup(function(){
      var search = $('#search_box').val();
      var sortPrice = $('#price').val();
      var variation = $('#variation').val();
      load_data(2, 1, sortPrice, variation, search);
    });

    $(document).on('change', '#price', function(){
      var search = $('#search_box').val();
      var sortPrice = $('#price').val();
      var variation = $('#variation').val();
      load_data(2, 1, sortPrice, variation, search);  
    });

    });

  </script>