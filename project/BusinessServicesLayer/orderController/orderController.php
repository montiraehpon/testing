<?php

require_once '../../BusinessServicesLayer/orderModel/orderModel.php';

class orderController{

	//add cart//
	function addCart($cus_id){
		$order = new orderModel();
		$order->product_id = $_POST["id"];
		$order->product_name = $_POST["name"];
		$order->product_price = $_POST["price"];
		$order->cus_id = $cus_id;
		$order->sp_id = $_POST["sp_id"];
		$order->type = $_POST["type"];
		$order->product_imgpath = $_POST["imgpath"];
		$order->product_quantity = $_POST["quantity"];
		$folder = "../../ApplicationLayer/ManagePayment/OrderImages/";

		if($order->checkCart() > 0){
			$quandb = $order->getQuantity();
			$order->product_quantity = $quandb + $_POST["quantity"];
			if($order->updateQuantity() > 0){
				$message = "Already update your quantity of product.";
				echo "<script type='text/javascript'>alert('$message');
            	window.location = '../../ApplicationLayer/ManagePayment/ViewCart.php';</script>";
            	exit;
			}
		}

		if($order->addCart()){
			if($order->type == "Food"){
				$message = "Add into cart successfully.";
				echo "<script type='text/javascript'>alert('$message');
            	window.location = '../../ApplicationLayer/ManageFoodDelivery/FoodVariation.php';</script>";
            	exit;
			}	
			else if($order->type == "Goods"){
				$message = "Add into cart successfully.";
				echo "<script type='text/javascript'>alert('$message');
            	window.location = '../../ApplicationLayer/ManageGoodsDelivery/GoodsVariation.php';</script>";
            	exit;
			}	
			else if($order->type == "Medicine"){
				$message = "Add into cart successfully.";
				echo "<script type='text/javascript'>alert('$message');
            	window.location = '../../ApplicationLayer/ManageMedicineDelivery/MedVariation.php';</script>";
            	exit;
			}
			else if($order->type == "Pet"){
				$message = "Add into cart successfully.";
				echo "<script type='text/javascript'>alert('$message');
            	window.location = '../../ApplicationLayer/ManagePetAssist/PetVariation.php';</script>";
            	exit;
			}
		}
		else{
			$message = "Failed! Please try again.";
			echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManageUser/CustomerHomepage.php';</script>";
		}
	}

	//check cart//
	function checkCart($cus_id){
		$order = new orderModel();
		$order->cus_id = $cus_id;
		return $order->checkTotalCart();
	}

	//view cart//
	function viewCart($cus_id){
		$order = new orderModel();
		$order->cus_id = $cus_id;
		return $order->viewCart();
	}

	//delete product//
	function deleteProduct(){
		$order = new orderModel();
		$order->product_id = $_POST["product_id"];
		if($order->deleteProduct()){
			$message = "Delete successfully.";
			echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManagePayment/ViewCart.php';</script>";
		}
		else{
			$message = "Failed! Please try again.";
			echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ManagePayment/ViewCart.php';</script>";
		}
	}

	//view customer detail//
	function viewCusDetail($cus_idd){
		$order = new orderModel();
		$order->cus_id = base64_decode($cus_idd);
		return $order->viewCusDetail();
	}

	//add into order//
	function addOrder($cus_id,$total){
		$order = new orderModel();
		$order->cus_id = base64_decode($cus_id);
		$order->total_price = $total;
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$order->date = date("Y-m-d h:i:sa");
		$order->status = "Requested";
		$order->payment_status = "Success";
		$order->addPayment();
		$order->updateCart();
		header("location: ../../ApplicationLayer/ManagePayment/PaymentReceipt.php");
	}

	//go track order//
	function trackOrder($cus_id){
		$order = new orderModel();
		$order->cus_id = $cus_id;
		if($order->addOrder()){
				if($order->deleteCart()){
					header("location: ../../ApplicationLayer/ProvideTrackingAndAnalysis/TrackOrder.php");
				}
			}
	}

	//show cart item//
	function showCart($cus_idd){
		$order = new orderModel();
		$order->cus_id = base64_decode($cus_idd);
		return $order->showCart();
	}

	//update quantity//
	function updateQuantity($cus_id,$value){
		$order = new orderModel();
		$order->cus_id = $cus_id;
		$order->product_quantity = $value;
		$order->product_id = $_POST["product_id"];
		$order->updateQuantity();
		header("Refresh:0");
	}
}
?>