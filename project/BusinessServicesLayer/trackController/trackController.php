<?php

require_once '../../BusinessServicesLayer/trackModel/trackModel.php';

class trackController{

	//check list//
	function checkList($date){
		$track = new trackModel();
		$track->date = $date;
		$track->status = "Completed";
		return $track->checkList();
	}

	//check list//
	function checkDate($date){
		$track = new trackModel();
		$track->date = $date;
		$track->status = "Requested";
		return $track->checkDate();
	}

	//go to delivery detail//
	function goDetail(){
		$track = new trackModel();
		$sp_id = $_POST["sp_id"];
		header("location: ../../ApplicationLayer/ProvideTrackingAndAnalysis/ViewDeliveryDetail.php?sp_id=$sp_id");
	}

	//view delivery detail//
	function viewDeliveryDetail($sp_id){
		$track = new trackModel();
		$track->sp_id = $sp_id;
		$track->status = "Completed";
		return $track->viewDeliveryDetail();
	}

	//view service provider detail//
	function viewSPDetail($sp_id){
		$track = new trackModel();
		$track->sp_id = $sp_id;
		return $track->viewSPDetail();
	}

	//accept delivery//
	function acceptDelivery($rn_id,$sp_id){
		$track = new trackModel();
		$track->rn_id = $rn_id;
		$track->sp_id = $sp_id;
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$track->date = date("Y-m-d h:i:sa");
		$track->status = "Picking up";
		$track->doneStatus = "Completed";
		if($track->acceptDelivery() > 0){
			$message = "Successfully accept.";
			echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ProvideTrackingAndAnalysis/RunnerDeliveryStatus.php';</script>";
		}
	}

	///update status//
	function viewStatus($rn_id){
		$track = new trackModel();
		$track->rn_id = $rn_id;
		$track->status = "Completed";
		return $track->viewStatus();
	}

	//get service provider//
	function getSP($rn_id){
		$track = new trackModel();
		$track->rn_id = $rn_id;
		$track->status = "Completed";
		$spdb = $track->getSP();
		return $spdb;
	}

	//get runner//
	function getRunner($rn_id){
		$track = new trackModel();
		$track->rn_id = $rn_id;
		$track->status = "Completed";
		return $track->getRunner();
	}

	//get runner//
	function getComplete($rn_id){
		$track = new trackModel();
		$track->rn_id = $rn_id;
		$track->status = "Picking Up";
		$track->status2 = "Sending";
		return $track->getComplete();
	}

	//update status//
	function updateDelivery($rn_id,$sp_id){
		$track = new trackModel();
		$track->rn_id = $rn_id;
		$track->sp_id = $sp_id;
		$track->status = $_POST["status"];
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$track->date = date("Y-m-d h:i:sa");
		$track->doneStatus = "Completed";
		if($track->updateDelivery() > 0){
			if($track->status == "Sending"){
				$message = "You are sending now!";
				echo "<script type='text/javascript'>alert('$message');
            	window.location = '../../ApplicationLayer/ProvideTrackingAndAnalysis/RunnerDeliveryStatus.php';</script>";
			}
			else if($track->status == "Completed"){
					$message = "Thank you!";
					echo "<script type='text/javascript'>alert('$message');
            		window.location = '../../ApplicationLayer/ProvideTrackingAndAnalysis/RunnerDeliveryList.php';</script>";	
			}
		}
		else{
			$message = "Failed! Please try again.";
			echo "<script type='text/javascript'>alert('$message');
            window.location = '../../ApplicationLayer/ProvideTrackingAndAnalysis/RunnerDeliveryStatus.php';</script>";
		}
	}

	//check order//
	function checkOrder($cus_id){
		$track = new trackModel();
		$track->cus_id = $cus_id;
		return $track->checkOrder();
	}

	//view order//
	function viewOrder($cus_id){
		$track = new trackModel();
		$track->cus_id = $cus_id;
		return $track->viewOrder();
	}

	//check history//
	function checkHistory($cus_id){
		$track = new trackModel();
		$track->cus_id = $cus_id;
		$track->status = "Completed";
		return $track->checkHistory();
	}

	//view history//
	function viewHistory($cus_id){
		$track = new trackModel();
		$track->cus_id = $cus_id;
		$track->status = "Completed";
		return $track->viewHistory();
	}

	//service provider check order//
	function checkSPOrder($sp_id){
		$track = new trackModel();
		$track->sp_id = $sp_id;
		return $track->checkSPOrder();
	}

	//service provider view order//
	function viewSPOrder($sp_id){
		$track = new trackModel();
		$track->sp_id = $sp_id;
		return $track->viewSPOrder();
	}

	//check service provider history//
	function checkSPHistory($sp_id){
		$track = new trackModel();
		$track->sp_id = $sp_id;
		$track->status = "Completed";
		return $track->checkSPHistory();
	}

	//view history//
	function viewSPHistory($sp_id){
		$track = new trackModel();
		$track->sp_id = $sp_id;
		$track->status = "Completed";
		return $track->viewSPHistory();
	}

	//Food report//
    function food_rpt($sp_id){
		$track = new trackModel();
		$track->sp_id = $sp_id;
		$track->type = "Food";
		return $track->food_rpt();
	}

    function food_rpt_check($sp_id){
		$track = new trackModel();
		$track->sp_id = $sp_id;
		$track->type = "Food";
		return $track->food_rpt_check();
	}

	//Goods Report//
	function goods_rpt($sp_id){
		$track = new trackModel();
		$track->sp_id = $sp_id;
		$track->type = "Goods";
		return $track->goods_rpt();
	}

	function goods_rpt_check($sp_id){
		$track = new trackModel();
		$track->sp_id = $sp_id;
		$track->type = "Goods";
		return $track->goods_rpt_check();
	}

	//Medical report//
	function med_rpt($sp_id){
		$track = new trackModel();
		$track->sp_id = $sp_id;
		$track->type = "Medicine";
		return $track->med_rpt();
	}

	function med_rpt_check($sp_id){
		$track = new trackModel();
		$track->sp_id = $sp_id;
		$track->type = "Medicine";
		return $track->med_rpt_check();
	}

	//Pet Report//
	function pet_rpt($sp_id){
		$track = new trackModel();
		$track->sp_id = $sp_id;
		$track->type = "Pet";
		return $track->pet_rpt();
	}

	function pet_rpt_check($sp_id){
		$track = new trackModel();
		$track->sp_id = $sp_id;
		$track->type = "Pet";
		return $track->pet_rpt_check();
	}

	//Runner Report//
	function rn_rpt($rn_id){
		$track = new trackModel();
		$track->rn_id = $rn_id;
		$track->status = "Completed";
		return $track->rn_rpt();
	}

	function rn_rpt_check($rn_id){
		$track = new trackModel();
		$track->rn_id = $rn_id;
		$track->status = "Completed";
		return $track->rn_rpt_check();
	}
}
?>