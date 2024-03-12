<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/Encryption.php');
include('../../Helpers/LimitRequests.php');
include('../../APIs/Equipment/Equipment.php');

$maxRequestsPerMinute = 15;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$equipment = new Equipment($con);
$receiver_token = Encryption::decryptToken(Tools::getFromCookie('token'), constants::$tokenEncKey);

$success = $equipment->getCheckedToday($receiver_token); // Pass special condition to the get method

if ($success) {
    echo json_encode(['success' => true, 'data' => $success]);
} else {
    $errorMessage = 'Something went wrong. Please try again';
    echo json_encode(['success' => false, 'message' => $errorMessage]);
}
