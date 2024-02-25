<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/Encryption.php');
include('../../APIs/Account/Account.php');

$account = new Account($con);

$token = Encryption::decryptToken(@$_POST["token"], constants::$tokenEncKey);

$success = $account->getByUserToken($token, 'equipmentID');

if ($success) {
    echo json_encode(array('success' => true, 'data' => $success));
} else {
    echo json_encode(array('success' => false, 'data' => $success));
}