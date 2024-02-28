<?php
class NotificationValidation
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

}