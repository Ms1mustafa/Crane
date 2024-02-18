<?php

include_once('../../Helpers/Constants.php');
include_once('Validation.php');
class Test
{
    private $con;
    private $errorArray = array();

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function create($token, $priority, $name)
    {

        $query = $this->con->prepare("INSERT INTO tests_type (token, priority ,name) VALUES (:token, :priority, :name)");

        $validation = new Validation($this->con, $this->errorArray);

        $validation->validateEmpty([$token, $priority, $name]);
        $validation->validateToken($token);
        $validation->validateName($name);

        $query->bindValue(":token", $token);
        $query->bindValue(":priority", $priority);
        $query->bindValue(":name", $name);

        if (empty($this->errorArray))
            return $query->execute();
        else
            return false;
    }

    public function get($conditions = array())
    {
        $sql = "SELECT * FROM tests_type";

        // If conditions are provided, add WHERE clause to the query
        if (!empty($conditions)) {
            $sql .= " WHERE ";
            $sql .= implode(" AND ", array_map(function ($key) {
                return "$key = :$key";
            }, array_keys($conditions)));
        }

        // Prepare the SQL query
        $query = $this->con->prepare($sql);

        // Bind values for parameters in the conditions
        foreach ($conditions as $key => $value) {
            $query->bindValue(":$key", $value);
        }

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