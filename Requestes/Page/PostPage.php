<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/LimitRequests.php');
include('../../APIs/Page/Page.php');

$maxRequestsPerMinute = 15;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$page = new Page($con);

$name = @$_POST["name"];
$url = @$_POST["url"];

$success = $page->create($name, $url);

if ($success === true) {
    echo json_encode(array('success' => true));
} else {
    $errorMessage =
        $page->getError(constants::$fildsRequired) ??
        $page->getError(constants::$nameTaken) ??
        'Something went wrong. Please try again';

    echo json_encode(array('success' => false, 'message' => $errorMessage ?? 'Something went wrong. Please try again'));
}