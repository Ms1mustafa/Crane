<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/LimitRequests.php');
include('../../APIs/Role/Role.php');

$maxRequestsPerMinute = 20;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$role = new Role($con);

$typeId = @$_POST["typeId"];
$pageId = @$_POST["pageId"];

$success = $role->delete($typeId, $pageId);

if ($success === true) {
    echo json_encode(array('success' => true));
} else {
    $errorMessage = 'Something went wrong. Please try again';

    echo json_encode(array('success' => false, 'message' => $errorMessage ?? 'Something went wrong. Please try again'));
}