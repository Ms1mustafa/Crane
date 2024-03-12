<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/Encryption.php');
include('../../APIs/Account/Account.php');
include('../../APIs/UserType/UserType.php');
include('../../APIs/Notification/Notification.php');
include('../../APIs/Equipment/Equipment.php');
include('../../APIs/Test/TestStatus.php');

$account = new Account($con);
$userType = new UserType($con);
$notification = new Notification($con);
$equipment = new Equipment($con);
$testStatus = new TestStatus($con);
$tools = new Tools();

$token = Encryption::decryptToken(@$_POST["token"], constants::$tokenEncKey);

$notificationSuccess = $notification->getby('*', 'token', $token);

$equipmentSuccess = $equipment->getBy('*', 'token', $notificationSuccess[0]['equipment_token']);

//get equipment status
$equipmentID = $equipmentSuccess[0]['id'];
$notificationDate = $notificationSuccess[0]['start_date'];
$receiver_TypeId = $account->getBy('typeId', 'token', $notificationSuccess[0]['receiver_token']);
$receiver_Type = $userType->getBy('name', 'id', $receiver_TypeId['typeId']);

$equipmentStatus = $testStatus->getByDate($notificationDate, $equipmentID);
$equipmentSuccess[0]['equipmentStatus'] = $equipmentStatus['status'];

if (Tools::getDateOnly($notificationDate) !== date("Y-m-d") || $notificationSuccess[0]['status'] !== "active")
    echo json_encode(['success' => false, 'message' => 'Notification expired']);
else
    echo json_encode(['success' => true, 'data' => $notificationSuccess[0], 'data2' => $equipmentSuccess[0], 'receiver_Type' => $receiver_Type]);

// $equipmentSuccess = $equipment->getBy('*', 'token', $notificationSuccess[0]['equipment_token']);
// if ($equipmentSuccess) {
//     echo json_encode(['success' => true, 'data' => $equipmentSuccess[0]]);
// } else {
//     echo json_encode(array('success' => false, 'data' => $equipmentSuccess));
// }