<?php

include_once('../../Helpers/Constants.php');
include_once('NotificationValidation.php');

class Notification
{
    private $con;
    private $currentDateTime;
    private $errorArray = array();

    public function __construct($con)
    {
        $this->con = $con;
        $this->currentDateTime = date("Y-m-d H:i:s");
    }

    public function create($token, $sender_token, $receiver_token, $username, $url, $data = array())
    {
        // Prepare the SQL query
        $columnNames = !empty($data) ? ", " . implode(", ", array_keys($data)) : "";
        $columnPlaceholders = !empty($data) ? ", :" . implode(", :", array_keys($data)) : "";
        $query = $this->con->prepare("INSERT INTO notifications (token, sender_token, receiver_token, username, url, start_date $columnNames) VALUES (:token, :sender_token, :receiver_token, :username, :url, :currentDateTime $columnPlaceholders)");

        $validation = new NotificationValidation($this->con, $this->errorArray);

        $validation->validateEmpty([$token, $sender_token, $receiver_token, $username, $url]);

        // Bind values to the parameters
        $query->bindValue(":token", $token);
        $query->bindValue(":sender_token", $sender_token);
        $query->bindValue(":receiver_token", $receiver_token);
        $query->bindValue(":username", $username);
        $query->bindValue(":url", $url);
        $query->bindValue(":currentDateTime", $this->currentDateTime);

        // Bind data values if $data is not empty
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $query->bindValue(":$key", $value);
            }
        }

        // Execute the query
        if (empty($this->errorArray))
            return $query->execute();
        else
            return false;
    }



    public function getNotification($token, $byToday = null)
    {
        $sql = "SELECT * FROM notifications WHERE receiver_token = :token AND status = 'active'";

        // If $byToday is true, add condition to filter by today's date
        if ($byToday) {
            $sql .= " AND DATE(start_date) = DATE(:currentDateTime)";
        }

        // Order the results by start_date in descending order
        $sql .= " ORDER BY 'start_date' DESC";

        $query = $this->con->prepare($sql);
        $query->bindValue(":token", $token);
        if ($byToday)
            $query->bindValue(":currentDateTime", $this->currentDateTime);

        $query->execute();
        $notification = $query->fetchAll(PDO::FETCH_ASSOC);

        return $notification;
    }


    public function getBy($get, $by, $value)
    {
        $query = $this->con->prepare("SELECT $get FROM notifications WHERE $by = :value");

        $query->bindValue(":value", $value);

        $query->execute();

        $notification = $query->fetchAll(PDO::FETCH_ASSOC);

        return $notification;
    }

    public function updateByToken($values, $token)
    {
        $setValues = '';
        foreach ($values as $key => $value) {
            $setValues .= "$key = :$key, ";
        }
        $setValues = rtrim($setValues, ', '); // Remove the trailing comma and space

        $sql = "UPDATE notifications SET $setValues WHERE token = :token";

        $query = $this->con->prepare($sql);

        foreach ($values as $key => $value) {
            $query->bindValue(":$key", $value);
        }
        if ($token) {
            $query->bindValue(":token", $token);
        }

        return $query->execute();
    }

    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return $error;
        }
    }

}