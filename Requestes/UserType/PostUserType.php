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

$name = @$_POST["name"];
$url = @$_POST["url"];

$success = $userType->create($name);

if ($success === true) {
    echo json_encode(array('success' => true));
} else {
    $errorMessage =
        $userType->getError(constants::$fildsRequired) ??
        $userType->getError(constants::$nameTaken) ??
        'Something went wrong. Please try again';

    echo json_encode(array('success' => false, 'message' => $errorMessage ?? 'Something went wrong. Please try again'));
}