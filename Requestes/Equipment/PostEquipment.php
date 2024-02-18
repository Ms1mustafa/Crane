<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/LimitRequests.php');
include('../../APIs/Equipment/Equipment.php');

$maxRequestsPerMinute = 15;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$equipment = new Equipment($con);
$token = Tools::generateUniqueToken();

$asset_type = @$_POST["asset_type"];
$description = @$_POST["description"];
$vechicle_no = @$_POST["vechicle_no"];
$owner = @$_POST["owner"];
$asset_number = @$_POST["asset_number"];

$success = $equipment->create($token, $asset_type, $description, $vechicle_no, $owner, $asset_number);

if ($success === true) {
    echo json_encode(array('success' => true));
} else {
    $errorMessage =
        $equipment->getError(constants::$fildsRequired) ??
        $equipment->getError(constants::$descriptionTaken) ??
        $equipment->getError(constants::$vechicle_noTaken) ??
        $equipment->getError(constants::$asset_numberTaken) ??
        $equipment->getError(constants::$tokenTaken) ??
        'Something went wrong. Please try again';

    echo json_encode(array('success' => false, 'message' => $errorMessage ?? 'Something went wrong. Please try again'));
}