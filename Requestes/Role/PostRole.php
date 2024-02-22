<?php
include('../../includes/config.php');
include('../../Helpers/Tools.php');
include('../../Helpers/LimitRequests.php');
include('../../APIs/Role/Role.php');

$permission = new Role($con); // Make sure to replace Permission with the appropriate class name

// Extract typeId and pageId from POST data
$typeId = @$_POST["typeId"];
$pageId = @$_POST["pageId"];

// Check if typeId and pageId are set
if (isset($typeId) && isset($pageId)) {
    // Add or remove permission based on the request
    $success = @$_POST["action"] === "add" ? $permission->create($typeId, $pageId) : $permission->delete($typeId, $pageId);

    // Check if the operation was successful
    if ($success === true) {
        echo json_encode(array('success' => true));
    } else {
        $errorMessage = 'Something went wrong. Please try again';
        echo json_encode(array('success' => false, 'message' => $errorMessage ?? 'Something went wrong. Please try again'));
    }
} else {
    // If typeId or pageId is not set in the request
    echo json_encode(array('success' => false, 'message' => 'Type ID and Page ID must be provided'));
}