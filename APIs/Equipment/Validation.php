<?php
class Validation
{
    private $con;
    private $errorArray = array();
    public function __construct($con, &$errorArray)
    {
        $this->con = $con;
        $this->errorArray = &$errorArray;
    }
    public function validateEmpty($inputArray)
    {
        foreach ($inputArray as $input) {
            if (empty($input)) {
                array_push($this->errorArray, constants::$fildsRequired);
            }
        }
    }
    public function validateToken($token)
    {
        $query = $this->con->prepare('SELECT * FROM equipment WHERE token = :token');
        $query->bindValue(':token', $token);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, constants::$tokenTaken);
        }
    }
    public function validateDescription($description)
    {
        $query = $this->con->prepare('SELECT * FROM equipment WHERE description = :description');
        $query->bindValue(':description', $description);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, constants::$descriptionTaken);
        }
    }
    public function validateVechicle_no($vechicle_no)
    {
        $query = $this->con->prepare('SELECT * FROM equipment WHERE vechicle_no = :vechicle_no');
        $query->bindValue(':vechicle_no', $vechicle_no);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, constants::$vechicle_noTaken);
        }
    }
    public function validateAsset_number($asset_number)
    {
        $query = $this->con->prepare('SELECT * FROM equipment WHERE asset_number = :asset_number');
        $query->bindValue(':asset_number', $asset_number);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, constants::$asset_numberTaken);
        }
    }
}