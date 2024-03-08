<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/Encryption.php');
include('../../APIs/Equipment/Equipment.php');

$equipment = new Equipment($con);

$token = @$_POST["token"];
// $get = @$_POST["get"];

$equipmentSuccess = $equipment->getBy('*', 'token', $token);
if ($equipmentSuccess) {
    echo json_encode(['success' => true, 'data' => $equipmentSuccess[0]]);
} else {
    echo json_encode(array('success' => false, 'data' => $equipmentSuccess));
}