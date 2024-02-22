<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/LimitRequests.php');
include('../../APIs/UserType/UserType.php');

$maxRequestsPerMinute = 15;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$userType = new UserType($con);

$success = $userType->get();

if ($success) {
    echo json_encode(array('success' => true, 'data' => $success));
} else {
    $errorMessage = 'Something went wrong. Please try again';

    echo json_encode(array('success' => false, 'message' => $errorMessage));
}