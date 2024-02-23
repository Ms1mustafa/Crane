<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/LimitRequests.php');
include('../../APIs/Test/TestStatus.php');

$maxRequestsPerMinute = 15;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$testStatus = new TestStatus($con);

$equipmentID = @$_POST["equipmentID"];
$status = @$_POST["status"];

$success = $testStatus->create($equipmentID, $status);

if ($success === true) {
    echo json_encode(array('success' => true));
} else {
    $errorMessage =
        $testStatus->getError(constants::$fildsRequired) ??
        'Something went wrong. Please try again';

    echo json_encode(array('success' => false, 'message' => $errorMessage ?? 'Something went wrong. Please try again'));
}