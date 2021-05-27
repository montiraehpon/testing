<?php
session_start();
require_once '../../BusinessServicesLayer/orderController/orderController.php';

$order = new orderController();
$cus_id = $_GET["cus_id"];
$total = $_GET["total"];

$order->addOrder($cus_id,$total);

?>
