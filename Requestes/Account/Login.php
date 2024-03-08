<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/LimitRequests.php');
include('../../Helpers/Encryption.php');
include('../../APIs/Account/Account.php');

$maxRequestsPerMinute = 25;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$account = new Account($con);

$username = @$_POST["username"];
$password = @$_POST["password"];

$success = $account->Login($username, $password);

if ($success) {
    $token = $success[0]['token'];
    $hashedToken = Encryption::encryptToken($token, constants::$tokenEncKey);
    setcookie('token', $hashedToken, time() + (86400 * 365), "/");
    echo json_encode(['success' => true, 'data' => $success]);
} else {
    $errorMessage =
        $account->getError(constants::$fildsRequired) ??
        $account->getError(constants::$usernameNotExist) ??
        'incorrect password';

    echo json_encode(array('success' => false, 'message' => $errorMessage));
}