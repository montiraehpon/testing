<?php

require_once '../../BusinessServicesLayer/userController/userController.php';

$user = new userController();

$user_idd = $_GET["user_id"];
$tokenn = $_GET["token"];

if(isset($_GET["user_id"]) && isset($_GET["token"])){
	$user->setPw($user_idd,$tokenn);
}

?>

