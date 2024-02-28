<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/Encryption.php');
include('../../Helpers/LimitRequests.php');
include('../../APIs/Account/Account.php');
include('../../APIs/UserType/UserType.php');
include('../../APIs/Notification/Notification.php');

$maxRequestsPerMinute = 30;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$account = new Account($con);
$userType = new UserType($con);
$notification = new Notification($con);
$token = Tools::generateUniqueToken();

//Get receiver token
$typeId = $userType->getBy('id', 'name', $_POST['receiverType'])['id'];
$receiver_token = $account->getBy('token', 'typeId', $typeId)['token'];

$sender_token = Encryption::decryptToken(@$_COOKIE["token"], constants::$tokenEncKey);
$username = $account->getByUserToken($sender_token, "username")["username"];
$url = @$_POST["url"];
$data = @$_POST["data"];

$success = $notification->create($token, $sender_token, $receiver_token, $username, $url, $data);

if ($success === true) {
    echo json_encode(array('success' => true));
} else {
    $errorMessage =
        'Something went wrong. Please try again';

    echo json_encode(array('success' => false, 'message' => $errorMessage ?? 'Something went wrong. Please try again'));
}