<?php

include_once('../../Helpers/Constants.php');
include_once('Validation.php');
class UserType
{
    private $con;
    private $errorArray = array();

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function create($name)
    {

        $query = $this->con->prepare("INSERT INTO users_type (name) VALUES (:name)");

        $validation = new Validation($this->con, $this->errorArray);

        $validation->validateEmpty([$name]);
        $validation->validateName($name);

        $query->bindValue(":name", $name);

        if (empty($this->errorArray))
            return $query->execute();
        else
            return false;
    }

    public function get($conditions = array())
    {
        $sql = "SELECT * FROM users_type";

        // Check if conditions are provided
        if (!empty($conditions)) {
            // Add WHERE clause to the query based on the provided conditions
            $sql .= " WHERE ";
            $conditionsArray = array();
            foreach ($conditions as $key => $value) {
                $conditionsArray[] = "$key = :$key";
            }
            $sql .= implode(" AND ", $conditionsArray);
        }

        $query = $this->con->prepare($sql);

        // Bind values for parameters in the conditions
        foreach ($conditions as $key => $value) {
            $query->bindValue(":$key", $value);
        }

        // Execute the query
        $query->execute();

        // Fetch all rows from the result set
        $userTypes = $query->fetchAll(PDO::FETCH_ASSOC);

        // Return the user types
        return $userTypes;
    }

    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return $error;
        }
    }
}