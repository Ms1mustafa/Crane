<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/LimitRequests.php');
include('../../APIs/Test/Test.php');

$maxRequestsPerMinute = 15;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$test = new Test($con);

$token = Tools::generateUniqueToken();
$priority = @$_POST["priority"];
$name = @$_POST["name"];

$success = $test->create($token, $priority, $name);

if ($success === true) {
    echo json_encode(array('success' => true));
} else {
    $errorMessage =
        $test->getError(constants::$fildsRequired) ??
        $test->getError(constants::$nameTaken) ??
        'Something went wrong. Please try again';

    echo json_encode(array('success' => false, 'message' => $errorMessage ?? 'Something went wrong. Please try again'));
}