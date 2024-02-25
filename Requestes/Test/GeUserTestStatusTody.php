<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/LimitRequests.php');
include('../../APIs/Test/TestStatus.php');

$maxRequestsPerMinute = 25;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$testStatus = new TestStatus($con);
$equipmentID = @$_POST["equipmentID"];

$success = $testStatus->geUserTestStatusTody($equipmentID);

if ($success) {
    echo json_encode(array('success' => true, 'data' => $success));
} else {
    $errorMessage = 'No data found';

    echo json_encode(array('success' => false, 'message' => $errorMessage));
}