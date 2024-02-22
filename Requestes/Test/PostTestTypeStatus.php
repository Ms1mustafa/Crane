<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/LimitRequests.php');
include('../../APIs/Test/TestTypeStatus.php');

$maxRequestsPerMinute = 15;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$testTypeStatus = new TestTypeStatus($con);

$equipmentID = @$_POST["equipmentID"];
$status = @$_POST["status"];

$success = $testTypeStatus->create($equipmentID, $status);

if ($success === true) {
    echo json_encode(array('success' => true));
} else {
    $errorMessage =
        $testTypeStatus->getError(constants::$fildsRequired) ??
        'Something went wrong. Please try again';

    echo json_encode(array('success' => false, 'message' => $errorMessage ?? 'Something went wrong. Please try again'));
}