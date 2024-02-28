<?php
class UserTypeValidation
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
    public function validateName($name)
    {
        $query = $this->con->prepare('SELECT * FROM users_type WHERE name = :name');
        $query->bindValue(':name', $name);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, constants::$nameTaken);
        }
    }

}