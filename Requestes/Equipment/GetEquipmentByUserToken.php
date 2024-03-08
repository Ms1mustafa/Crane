<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/Encryption.php');
include('../../APIs/Account/Account.php');
include('../../APIs/Equipment/Equipment.php');

$account = new Account($con);
$equipment = new Equipment($con);

$token = Encryption::decryptToken(@$_POST["token"], constants::$tokenEncKey);
// $get = @$_POST["get"];

$equipmentSuccess = $account->getByUserToken($token, 'equipmentID');
$equipmentId = $equipmentSuccess['equipmentID'];

$equipmentSuccess = $equipment->getBy('*', 'id', $equipmentId);
if ($equipmentSuccess) {
    echo json_encode(array('success' => true, 'data' => $equipmentSuccess[0]));
} else {
    echo json_encode(array('success' => false, 'data' => $equipmentSuccess));
}