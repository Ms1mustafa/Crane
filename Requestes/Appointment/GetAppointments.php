<?php
include '../../includes/config.php';
include '../../Helpers/Tools.php';
include '../../Helpers/Encryption.php';
include '../../APIs/Account/Account.php';
include ('../../Helpers/LimitRequests.php');
include '../../APIs/Equipment/Equipment.php';
include ('../../APIs/Appointment/Appointment.php');
include '../../APIs/Appointment/AppointmentRqNo.php';

$maxRequestsPerMinute = 15;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$account = new Account($con);
$equipment = new Equipment($con);

// Get the basic data
$basic_data = array();

// Get the request number
$appointment = new Appointment($con);
$rqNo = AppointmentRqNo::getRqNo($appointment);
$basic_data['rqNo'] = $rqNo;

// Get the Username
$token = Encryption::decryptToken(Tools::getFromCookie('token'), constants::$tokenEncKey);
$username = $account->getBy('username', 'token', $token)['username'];
$basic_data['username'] = $username;

// Get the asset type
$asset_type = $equipment->getBy('asset_type', 'token', $_POST['eq'])[0]['asset_type'];
$basic_data['asset_type'] = $asset_type;
////////////////////////////////////////////////////////////

// Get the appointments
$appointmentsData = array();
$appointments = $appointment->getAppointments();

foreach ($appointments as $appointment) {
    $requesterToken = Encryption::decryptToken($appointment['created_by'], constants::$tokenEncKey);
    $requester = $account->getByUserToken($requesterToken, 'username')['username'];
    $appointmentsData[] = array(
        'id' => $appointment['id'],
        'token' => $appointment['token'],
        'rq_no' => $appointment['rq_no'],
        'requester' => $requester,
        'created_at' => $appointment['created_at'],
        'equipment' => $appointment['equipment'],
        'start' => $appointment['start_date'],
        'end' => $appointment['end_date'],
        'title' => $appointment['title'] . ' / ' . $requester,
        'area' => $appointment['area'],
        'location' => $appointment['location'],
        'work_type' => $appointment['work_type'],
        'color' => $appointment['color'],
    );
}

// print_r(json_encode($basic_data));
echo json_encode(array('success' => true, 'basic_data' => $basic_data, 'appointments' => $appointmentsData));