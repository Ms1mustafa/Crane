<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/Encryption.php');
include('../../APIs/Account/Account.php');
include('../../APIs/UserType/UserType.php');

$account = new Account($con);

$id = null;
$token = Encryption::decryptToken(@$_POST["token"], constants::$tokenEncKey);

$success = $account->getBy('typeId', 'token', $token);

if ($success) {
    $id = $success['typeId'];
} else {

}

$userType = new UserType($con);

$success = $userType->getBy('name', 'id', $id);

if ($success) {
    echo json_encode(array('success' => true, 'data' => $success));
} else {
    echo json_encode(array('success' => false, 'data' => $success));
}