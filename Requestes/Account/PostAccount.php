<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/LimitRequests.php');
include('../../APIs/Account/Account.php');

$maxRequestsPerMinute = 15;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$account = new Account($con);
$token = Tools::generateUniqueToken();

$username = @$_POST["username"];
$password = @$_POST["password"];
$email = @$_POST["email"];
$typeId = @$_POST["typeId"];
$equipmentID = @$_POST["equipmentID"];

$success = $account->create($token, $username, $email, $password, $typeId, $equipmentID);

if ($success === true) {
    echo json_encode(array('success' => true));
} else {
    $errorMessage =
        $account->getError(constants::$fildsRequired) ??
        $account->getError(constants::$emailInvalid) ??
        $account->getError(constants::$usernameTaken) ??
        $account->getError(constants::$emailTaken) ??
        $account->getError(constants::$passwordLength) ??
        $account->getError(constants::$tokenTaken) ??
        'Something went wrong. Please try again';

    echo json_encode(array('success' => false, 'message' => $errorMessage ?? 'Something went wrong. Please try again'));
}