<?php
include ('../../includes/config.php');
include ('../../Helpers/Tools.php');
include ('../../Helpers/LimitRequests.php');
include ('../../APIs/Appointment/Appointment.php');
include '../../APIs/Appointment/AppointmentRqNo.php';

$maxRequestsPerMinute = 15;

if (!LimitRequests::checkRateLimit($maxRequestsPerMinute)) {
    echo json_encode(array('success' => false, 'message' => constants::$rate_limit));
    exit;
}

$appointment = new Appointment($con);

$books = $appointment->getAppointments();

// echo json_encode($appointments);

$booked_times = $appointment->getBookedTimes();
// echo json_encode($booked_times);


$token = Tools::generateUniqueToken();
$rq_no = AppointmentRqNo::getRqNo($appointment);

$created_by = $_POST['created_by'];
$equipment = $_POST['equipment'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$title = $_POST['title'];
$area = $_POST['area'];
$location = $_POST['location'];
$work_type = $_POST['work_type'];
$color = $_POST['color'];

// dates validation

if (empty ($start_date) || empty ($end_date)) {
    echo json_encode(array('success' => false, 'message' => 'Please select start and end dates.'));
    exit;
}

if ($start_date < date('Y-m-d H:i') || $end_date < date('Y-m-d H:i')) {
    echo json_encode(array('success' => false, 'message' => 'The date cannot be in the past.'));
    exit;
}

foreach ($booked_times as $time) {
    $hour = $time['hour'];
    if (Tools::getFromDate($start_date, 'hour') == $hour) {
        echo json_encode(array('success' => false, 'message' => 'The date has already been booked. Please choose another date.'));
        exit;
    }
    if (Tools::getFromDate($end_date, 'hour') == $hour && Tools::getFromDate($end_date, 'minute') != '00') {
        echo json_encode(array('success' => false, 'message' => 'The date has already been booked. Please choose another date.'));
        exit;
    }

    if (Tools::getFromDate($start_date, 'hour') < $hour && Tools::getFromDate($end_date, 'hour') > $hour) {
        echo json_encode(array('success' => false, 'message' => 'The date has already been booked. Please choose another date.'));
        exit;
    }
    //if start date is after end date
    if (Tools::getFromDate($start_date, 'hour') > Tools::getFromDate($end_date, 'hour')) {
        echo json_encode(array('success' => false, 'message' => 'Invalid date. Please choose another date.'));
        exit;
    }
}

foreach ($books as $book) {
    // Check for any overlap in times
    if (
        // تاريخ بداية الحجز الجديد متشابه مع تاريخ بداية الحجز الموجود
        $start_date === $book['start_date'] ||
            // تاريخ بداية الحجز الجديد بين تاريخ البداية والنهاية من الحجز الموجود
        ($start_date > $book['start_date'] && $start_date < $book['end_date']) ||
            // تاريخ بداية الحجز الجديد أصغر من تاريخ الحجز الموجود وتاريخ نهاية الحجز الجديد داخل الحجز الموجود أو أكبر من تاريخ نهايته
        ($start_date < $book['start_date'] && ($end_date > $book['start_date'] || $end_date > $book['end_date']))
    ) {
        echo json_encode(array('success' => false, 'message' => 'The date has already been booked. Please choose another date.'));
        exit;
    }

}

if ($end_date === $start_date) {
    echo json_encode(array('success' => false, 'message' => 'start date cannot be the same as end date.'));
    exit;
}

// ***********************

$success = $appointment->create($token, $rq_no, $created_by, $equipment, $start_date, $end_date, $title, $area, $location, $work_type, $color);

if ($success === true) {
    echo json_encode(array('success' => true));
} else {
    $errorMessage =
        $appointment->getError(constants::$fildsRequired) ??
        $appointment->getError(constants::$tokenTaken) ??
        $appointment->getError(constants::$timeTaken) ??
        'Something went wrong. Please try again';

    echo json_encode(array('success' => false, 'message' => $errorMessage ?? 'Something went wrong. Please try again'));
}