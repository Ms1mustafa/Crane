<?php

include_once('../../Helpers/Constants.php');
include_once('Validation.php');
class Account
{
    private $con;
    private $errorArray = array();

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function create($token, $username, $email, $password, $type, $equipment)
    {

        $query = $this->con->prepare("INSERT INTO users (token, username ,email, password, type, equipment) VALUES (:token, :username, :email, :password, :type, :equipment)");

        $validation = new Validation($this->con, $this->errorArray);

        $validation->validateEmpty([$token, $username, $email, $password, $type, $equipment]);
        $validation->validateToken($token);
        $validation->validateEmail($email);
        $validation->validateUsername($username);
        $validation->validatePassword($password);

        $query->bindValue(":token", $token);
        $query->bindValue(":username", $username);
        $query->bindValue(":email", $email);
        $query->bindValue(":password", $password);
        $query->bindValue(":type", $type);
        $query->bindValue(":equipment", $equipment);

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