<?php

include_once('../../Helpers/Constants.php');
include_once('Validation.php');
class TestTypestatus
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

        $query = $this->con->prepare("INSERT INTO tests_type_status (equipmentID, status ,date) VALUES (:equipmentID, :status, :currentDateTime)");

        $validation = new Validation($this->con, $this->errorArray);

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
        $sql = "SELECT * FROM tests_type_status";

        $query = $this->con->prepare($sql);

        $query->execute();

        $testsType = $query->fetchAll(PDO::FETCH_ASSOC);

        return $testsType;
    }

    public function geTestTypeStatusTody()
    {

        $sql = "SELECT * FROM tests_type_status WHERE DATE(date) = DATE(:currentDateTime)";

        $query = $this->con->prepare($sql);

        $query->bindValue(":currentDateTime", $this->currentDateTime);

        $query->execute();

        $testsType = $query->fetchAll(PDO::FETCH_ASSOC);

        return $testsType;
    }


    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return $error;
        }
    }
}