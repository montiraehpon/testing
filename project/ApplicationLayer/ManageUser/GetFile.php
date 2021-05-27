<?php
session_start();

require_once '../../BusinessServicesLayer/userController/userController.php';
$user = new userController();

if (isset($_GET['ic'])){
    $id = $_GET['ic'];

    $user->ad_downloadIc($id);
}
else if(isset($_GET['license'])){
    $id = $_GET['license'];

    $user->ad_downloadLicense($id);
}
else if(isset($_GET['spic'])){
    $id = $_GET['spic'];

    $user->ad_downloadSPIc($id);
}

?>