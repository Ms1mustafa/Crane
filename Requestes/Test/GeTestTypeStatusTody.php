<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/LimitRequests.php');
include('../../APIs/Test/TestTypestatus.php');

$maxRequestsPerMinute = 25;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$testTypestatus = new TestTypestatus($con);

$success = $testTypestatus->geTestTypeStatusTody();

if ($success) {
    echo json_encode(array('success' => true, 'data' => $success));
} else {
    $errorMessage = 'No data found';

    echo json_encode(array('success' => false, 'message' => $errorMessage));
}