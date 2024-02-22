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
        $query = $this->con->prepare('SELECT * FROM users WHERE token = :token');
        $query->bindValue(':token', $token);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, constants::$tokenTaken);
        }
    }
    public function validatePassword($password)
    {
        if (strlen($password) < 2 || strlen($password) > 25) {
            array_push($this->errorArray, constants::$passwordLength);
            return;
        }
    }

    public function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, constants::$emailInvalid);
        }

        $query = $this->con->prepare('SELECT * FROM users WHERE email = :email');
        $query->bindValue(':email', $email);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, constants::$emailTaken);
        }
    }
    public function validateUsername($username)
    {
        $query = $this->con->prepare('SELECT * FROM users WHERE username = :username');
        $query->bindValue(':username', $username);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, constants::$usernameTaken);
        }
    }

    public function validateUsernameExists($username)
    {
        $query = $this->con->prepare('SELECT * FROM users WHERE username = :username');
        $query->bindValue(':username', $username);

        $query->execute();

        if ($query->rowCount() == 0) {
            array_push($this->errorArray, constants::$usernameNotExist);
        }
    }
}