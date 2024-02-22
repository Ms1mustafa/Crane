<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/LimitRequests.php');
include('../../APIs/Equipment/Equipment.php');

$maxRequestsPerMinute = 25;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$equipment = new Equipment($con);
$createAccount = 'WHERE NOT EXISTS (SELECT 1 FROM users WHERE users.equipmentID = equipment.id)';

$success = $equipment->get($createAccount); // Pass special condition to the get method

if ($success) {
    echo json_encode(array('success' => true, 'data' => $success));
} else {
    $errorMessage = 'Something went wrong. Please try again';
    echo json_encode(array('success' => false, 'message' => $errorMessage));
}
