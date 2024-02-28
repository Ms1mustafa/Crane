<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/Encryption.php');
include('../../APIs/Account/Account.php');
include('../../APIs/Notification/Notification.php');

$account = new Account($con);
$notification = new Notification($con);

$id = null;
// $token = Encryption::decryptToken(@$_POST["token"], constants::$tokenEncKey);
$token = 'Rr1ru1Ce5bueqe2';

$success = $notification->getNotification($token);

if ($success) {
    echo json_encode(array('success' => true, 'data' => $success));
} else {
    echo json_encode(array('success' => false, 'data' => $success));
}