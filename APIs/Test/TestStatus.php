<?php

include_once('../../Helpers/Constants.php');
include_once('TestValidation.php');
class TestStatus
{
    private $con;
    private $currentDateTime;
    private $errorArray = array();

    public function __construct($con)
    {
        $this->con = $con;
        $this->currentDateTime = date("Y-m-d H:i:s");
    }

    public function create($equipmentID, $status)
    {

        $query = $this->con->prepare("INSERT INTO tests_status (equipmentID, status ,date) VALUES (:equipmentID, :status, :currentDateTime)");

        $validation = new TestValidation($this->con, $this->errorArray);

        $validation->validateEmpty([$equipmentID, $status]);

        $query->bindValue(":equipmentID", $equipmentID);
        $query->bindValue(":status", $status);
        $query->bindValue(":currentDateTime", $this->currentDateTime);

        if (empty($this->errorArray))
            return $query->execute();
        else
            return false;
    }

    public function get()
    {
        $sql = "SELECT * FROM tests_status";

        $query = $this->con->prepare($sql);

        $query->execute();

        $testsType = $query->fetchAll(PDO::FETCH_ASSOC);

        return $testsType;
    }

    public function geTestStatusTody()
    {

        $sql = "SELECT * FROM tests_status WHERE DATE(date) = DATE(:currentDateTime)";

        $query = $this->con->prepare($sql);

        $query->bindValue(":currentDateTime", $this->currentDateTime);

        $query->execute();

        $testsType = $query->fetchAll(PDO::FETCH_ASSOC);

        return $testsType;
    }

    public function geUserTestStatusTody($equipmentID)
    {

        $sql = "SELECT * FROM tests_status WHERE DATE(date) = DATE(:currentDateTime) AND equipmentID = :equipmentID";

        $query = $this->con->prepare($sql);

        $query->bindValue(":currentDateTime", $this->currentDateTime);
        $query->bindValue(":equipmentID", $equipmentID);

        $query->execute();

        $response = $query->fetchAll(PDO::FETCH_ASSOC);

        return $response;
    }

    public function getByDate($date, $equipmentID)
    {
        $sql = "SELECT status FROM tests_status WHERE DATE(date) = DATE(:date) AND equipmentID = :equipmentID";

        $query = $this->con->prepare($sql);

        $query->bindValue(":date", $date);
        $query->bindValue(":equipmentID", $equipmentID);

        $query->execute();

        $response = $query->fetch(PDO::FETCH_ASSOC);

        return $response;
    }

    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return $error;
        }
    }
}