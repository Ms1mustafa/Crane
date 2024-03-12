<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/Encryption.php');
include('../../Helpers/LimitRequests.php');
include('../../APIs/Account/Account.php');
include('../../APIs/UserType/UserType.php');
include('../../APIs/Equipment/Equipment.php');
include('../../APIs/Notification/Notification.php');

$maxRequestsPerMinute = 15;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$account = new Account($con);
$userType = new UserType($con);
$notification = new Notification($con);
$equipment = new Equipment($con);
$token = Tools::generateUniqueToken();

//Get receiver token
$typeId = @$userType->getBy('id', 'name', @$_POST['receiverType'])['id'];

//Get Equipment by User token
$userToken = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);

$equipmentSuccess = @$account->getByUserToken($userToken, 'equipmentID');
$equipmentId = @$equipmentSuccess['equipmentID'];

$equipment_token = @$equipment->getBy('*', 'id', $equipmentId);

//API Info
$sender_token = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);
$username = $account->getByUserToken($sender_token, "username")["username"];
$url = @$_POST["url"] . '?noti=' . Encryption::encryptToken($token, constants::$tokenEncKey);
$data = @$_POST["data"];

$receiver_token = @$_POST['receiver_token'] ?? $account->getBy('token', 'typeId', $typeId)['token'];

if (@$equipment_token) {
    $data['equipment_token'] = @$equipment_token[0]['token'];
    $data['asset_type'] = @$equipment_token[0]['asset_type'];
    $data['description'] = @$equipment_token[0]['description'];
}

$success = $notification->create($token, $sender_token, $receiver_token, $username, $url, $data);

if ($success === true) {
    echo json_encode(array('success' => true));
} else {
    $errorMessage =
        'Something went wrong. Please try again';

    echo json_encode(array('success' => false, 'message' => $errorMessage ?? 'Something went wrong. Please try again'));
}