<?php
// get typeId by typeName
// get first user token by typeId

include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/Encryption.php');
include('../../APIs/Account/Account.php');
include('../../APIs/UserType/UserType.php');

$account = new Account($con);
$userType = new UserType($con);

$typeId = $userType->getBy('id', 'name', $_POST['typeName'])['id'];

$success = $typeId;

if ($success) {
    echo json_encode(array('success' => true, 'data' => $success));
} else {
    $errorMessage =
        'Something went wrong. Please try again';

    echo json_encode(array('success' => false, 'message' => $errorMessage ?? 'Something went wrong. Please try again'));
}