<?php

include_once('../../Helpers/Constants.php');
include_once('Validation.php');
class Page
{
    private $con;
    private $errorArray = array();

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function create($name, $url = "")
    {

        $query = $this->con->prepare("INSERT INTO pages (name ,url) VALUES (:name, :url)");

        $validation = new Validation($this->con, $this->errorArray);

        $validation->validateEmpty([$name]);
        $validation->validateName($name);

        $query->bindValue(":name", $name);
        $query->bindValue(":url", $url);

        if (empty($this->errorArray))
            return $query->execute();
        else
            return false;
    }

    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return $error;
        }
    }
}