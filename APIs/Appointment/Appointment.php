<?php

include_once ('../../Helpers/Constants.php');
include_once ('AppointmentValidation.php');
class Appointment
{
    private $con;
    private $errorArray = array();
    private $currentDateTime;
    public function __construct($con)
    {
        $this->con = $con;
        $this->currentDateTime = date("Y-m-d H:i:s");
    }

    public function create($token, $rq_no, $created_by, $equipment, $start_date, $end_date, $title, $area, $location, $work_type, $color)
    {

        $query = $this->con->prepare("INSERT INTO appointments (token, rq_no, created_by, created_at, equipment, start_date, end_date, title, area, location, work_type, color) VALUES (:token, :rq_no, :created_by, :currentDateTime, :equipment, :start_date, :end_date, :title, :area, :location, :work_type, :color)");

        $validation = new AppointmentValidation($this->con, $this->errorArray);

        $validation->validateEmpty([$token, $rq_no, $created_by, $equipment, $start_date, $end_date, $title, $area, $location, $work_type, $color]);
        $validation->validateToken($token);
        $validation->validateRq_no($rq_no);
        $validation->validateStart_date($start_date);

        $query->bindValue(":token", $token);
        $query->bindValue(":rq_no", $rq_no);
        $query->bindValue(":created_by", $created_by);
        $query->bindValue(":currentDateTime", $this->currentDateTime);
        $query->bindValue(":equipment", $equipment);
        $query->bindValue(":start_date", $start_date);
        $query->bindValue(":end_date", $end_date);
        $query->bindValue(":title", $title);
        $query->bindValue(":area", $area);
        $query->bindValue(":location", $location);
        $query->bindValue(":work_type", $work_type);
        $query->bindValue(":color", $color);

        if (empty ($this->errorArray))
            return $query->execute();
        else
            return false;
    }

    public function getBy($get, $by, $value)
    {
        $sql = "SELECT $get FROM appointments WHERE $by = :value ";

        $query = $this->con->prepare($sql);

        $query->bindValue(":value", $value);

        $query->execute();

        $equipment = $query->fetchAll(PDO::FETCH_ASSOC);

        return $equipment;
    }

    public function getAppointments()
    {
        $sql = "SELECT * FROM appointments WHERE status ='active'";

        $query = $this->con->prepare($sql);

        $query->execute();

        $equipment = $query->fetchAll(PDO::FETCH_ASSOC);

        return $equipment;
    }

    public function getRqNo()
    {
        $sql = "SELECT rq_no FROM appointments ORDER BY rq_no DESC LIMIT 1;";

        $query = $this->con->prepare($sql);

        $query->execute();

        $reqNo = $query->fetchColumn();

        return $reqNo;

    }

    public function getBookedTimes()
    {
        $sql = "SELECT * FROM booked_times";

        $query = $this->con->prepare($sql);

        $query->execute();

        $booked_times = $query->fetchAll(PDO::FETCH_ASSOC);

        return $booked_times;
    }

    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return $error;
        }
    }
}