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
$notification = new Notification($con);

$nowDate = date("Y-m-d H:i:s");
// $notificationToken = Tools::getURLParam('noti');

$notificationToken = Encryption::decryptToken($_POST['token'], constants::$tokenEncKey);
$updateValues = [
    "status" => "inactive",
    "end_date" => $nowDate,
];

$success = $notification->updateByToken($updateValues, $notificationToken);

if ($success === true) {
    echo json_encode(['success' => true]);
} else {
    $errorMessage =
        'Something went wrong. Please try again';

    echo json_encode(array('success' => false, 'message' => $errorMessage ?? 'Something went wrong. Please try again'));
}