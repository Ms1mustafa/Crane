<?php

include_once('../../Helpers/Constants.php');
include_once('Validation.php');
class Equipment
{
    private $con;
    private $errorArray = array();

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function create($token, $asset_type, $description, $vechicle_no, $owner, $asset_number)
    {

        $query = $this->con->prepare("INSERT INTO equipment (token, asset_type ,description, vechicle_no, owner, asset_number) VALUES (:token, :asset_type, :description, :vechicle_no, :owner, :asset_number)");

        $validation = new Validation($this->con, $this->errorArray);

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


    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return $error;
        }
    }
}