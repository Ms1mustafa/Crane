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

    public function create($token, $username, $email, $password, $typeId, $equipmentID = null)
    {

        $query = $this->con->prepare("INSERT INTO users (token, username ,email, password, typeId, equipmentID) VALUES (:token, :username, :email, :password, :typeId, :equipmentID)");

        $validation = new Validation($this->con, $this->errorArray);

        $validation->validateEmpty([$token, $username, $email, $password, $typeId]);
        $validation->validateToken($token);
        $validation->validateEmail($email);
        $validation->validateUsername($username);
        $validation->validatePassword($password);

        $query->bindValue(":token", $token);
        $query->bindValue(":username", $username);
        $query->bindValue(":email", $email);
        $query->bindValue(":password", $password);
        $query->bindValue(":typeId", $typeId);

        if (!empty($equipmentID)) {
            $query->bindValue(":equipmentID", $equipmentID);
        } else {
            $query->bindValue(":equipmentID", null, PDO::PARAM_NULL);
        }

        if (empty($this->errorArray))
            return $query->execute();
        else
            return false;
    }

    public function login($username, $password)
    {
        $query = $this->con->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $validation = new Validation($this->con, $this->errorArray);

        $validation->validateEmpty([$username, $password]);
        $validation->validateUsernameExists($username);

        $query->bindValue(":username", $username);
        $query->bindValue(":password", $password);

        $query->execute();

        $account = $query->fetchAll(PDO::FETCH_ASSOC);

        return $account;
    }

    public function getIsLoggedIn($token)
    {
        $query = $this->con->prepare("SELECT * FROM users WHERE token = :token");

        $query->bindValue(":token", $token);

        $query->execute();

        if ($query->rowCount() == 1)
            return true;
        else
            return false;

    }

    public function getByUserToken($token, $get)
    {
        $query = $this->con->prepare("SELECT $get FROM users WHERE token = :token");

        $query->bindValue(":token", $token);
        // $query->bindValue(":get", $get);

        $query->execute();

        $account = $query->fetchAll(PDO::FETCH_ASSOC);

        return $account;
    }

    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return $error;
        }
    }
}