<?php
class AppointmentValidation
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
            if (empty ($input)) {
                array_push($this->errorArray, constants::$fildsRequired);
            }
        }
    }
    public function validateToken($token)
    {
        $query = $this->con->prepare('SELECT * FROM appointments WHERE token = :token');
        $query->bindValue(':token', $token);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, constants::$tokenTaken);
        }
    }
    public function validateRq_no($rq_no)
    {
        $query = $this->con->prepare('SELECT * FROM appointments WHERE rq_no = :rq_no');
        $query->bindValue(':rq_no', $rq_no);

        $query->execute();

        if ($query->rowCount() != 0) {
            array_push($this->errorArray, constants::$tokenTaken);
        }
    }
    public function validateStart_date($start_date)
    {
        $dateTime = new DateTime($start_date);
        $hour = (int) $dateTime->format('H');

        if ($hour === '12' || $hour === '19') {
            array_push($this->errorArray, constants::$timeTaken);
        }
    }
}