<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/LimitRequests.php');
include('../../APIs/Test/Test.php');

$maxRequestsPerMinute = 25;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$test = new Test($con);
$requestData = json_decode(file_get_contents('php://input'), true); // Get POST data

$success = $test->get(@$requestData);

if ($success) {
    echo json_encode(array('success' => true, 'data' => $success));
} else {
    $errorMessage = 'Something went wrong. Please try again';

    echo json_encode(array('success' => false, 'message' => $errorMessage));
}
?>