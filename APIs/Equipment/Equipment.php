<?php

include_once('../../Helpers/Constants.php');
include_once('EquipmentValidation.php');
class Equipment
{
    private $con;
    private $errorArray = array();
    private $currentDateTime;
    public function __construct($con)
    {
        $this->con = $con;
        $this->currentDateTime = date("Y-m-d H:i:s");
    }

    public function create($token, $asset_type, $description, $vechicle_no, $owner, $asset_number)
    {

        $query = $this->con->prepare("INSERT INTO equipment (token, asset_type ,description, vechicle_no, owner, asset_number) VALUES (:token, :asset_type, :description, :vechicle_no, :owner, :asset_number)");

        $validation = new EquipmentValidation($this->con, $this->errorArray);

        $validation->validateEmpty([$token, $asset_type, $description, $vechicle_no, $owner, $asset_number]);
        $validation->validateToken($token);
        $validation->validateDescription($description);
        $validation->validatevechicle_no($vechicle_no);
        $validation->validateAsset_number($asset_number);

        $query->bindValue(":token", $token);
        $query->bindValue(":asset_type", $asset_type);
        $query->bindValue(":description", $description);
        $query->bindValue(":vechicle_no", $vechicle_no);
        $query->bindValue(":owner", $owner);
        $query->bindValue(":asset_number", $asset_number);

        if (empty($this->errorArray))
            return $query->execute();
        else
            return false;
    }

    public function get($specialCond = null)
    {
        $sql = "SELECT * FROM equipment ";

        // Add special conditions if provided
        if (!empty($specialCond)) {
            $sql .= $specialCond;
        }

        // Prepare the SQL query
        $query = $this->con->prepare($sql);

        // Execute the query
        $query->execute();

        // Fetch all rows from the result set
        $equipment = $query->fetchAll(PDO::FETCH_ASSOC);

        return $equipment;
    }

    public function getBy($get, $by, $value)
    {
        $sql = "SELECT $get FROM equipment WHERE $by = :value ";

        $query = $this->con->prepare($sql);

        $query->bindValue(":value", $value);

        $query->execute();

        $equipment = $query->fetchAll(PDO::FETCH_ASSOC);

        return $equipment;
    }

    public function getCheckedToday($receiver_token = null)
    {
        $sql = 'SELECT notifications.asset_type, notifications.description, notifications.url, notifications.start_date, notifications.receiver_token, equipment.asset_type, equipment.asset_number, equipment.vechicle_no, tests_status.status FROM equipment 
        INNER JOIN tests_status ON equipment.id = tests_status.equipmentID 
        INNER JOIN notifications ON equipment.token = notifications.equipment_token 
        WHERE DATE(tests_status.date) = DATE(:currentDateTime) AND DATE(notifications.start_date) = DATE(:currentDateTime) AND notifications.status = "active" AND notifications.receiver_token = :receiver_token
        ORDER BY notifications.start_date DESC';
        $query = $this->con->prepare($sql);

        $query->bindValue(":receiver_token", $receiver_token);
        $query->bindValue(":currentDateTime", $this->currentDateTime);

        $query->execute();

        $equipment = $query->fetchAll(PDO::FETCH_ASSOC);

        return $equipment;
    }

    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return $error;
        }
    }
}