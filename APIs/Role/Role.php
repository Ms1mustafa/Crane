<?php

include_once('../../Helpers/Constants.php');
include_once('Validation.php');
class Role
{
    private $con;
    private $errorArray = array();

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function create($typeId, $pageId)
    {
        $query = $this->con->prepare("INSERT INTO roles (typeId, pageId) VALUES (:typeId, :pageId)");

        $validation = new Validation($this->con, $this->errorArray);
        $validation->validateEmpty([$typeId, $pageId]);

        $query->bindValue(":typeId", $typeId);
        $query->bindValue(":pageId", $pageId);

        if (empty($this->errorArray))
            return $query->execute();
        else
            return false;
    }

    public function delete($typeId, $pageId)
    {
        $query = $this->con->prepare("DELETE FROM roles WHERE typeId = :typeId AND pageId = :pageId");

        $validation = new Validation($this->con, $this->errorArray);
        $validation->validateEmpty([$typeId, $pageId]);

        $query->bindValue(":typeId", $typeId);
        $query->bindValue(":pageId", $pageId);

        if (empty($this->errorArray))
            return $query->execute();
        else
            return false;
    }
}