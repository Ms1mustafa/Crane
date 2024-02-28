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
        $columnNames = implode(", ", array_keys($data));
        $columnPlaceholders = ":" . implode(", :", array_keys($data));
        $query = $this->con->prepare("INSERT INTO notifications (token, sender_token, receiver_token, username, url, start_date, $columnNames) VALUES (:token, :sender_token, :receiver_token, :username, :url, :currentDateTime, $columnPlaceholders)");

        $validation = new NotificationValidation($this->con, $this->errorArray);

        $validation->validateEmpty([$token, $sender_token, $receiver_token, $username, $url]);

        // Bind values to the parameters
        $query->bindValue(":token", $token);
        $query->bindValue(":sender_token", $sender_token);
        $query->bindValue(":receiver_token", $receiver_token);
        $query->bindValue(":username", $username);
        $query->bindValue(":url", $url);
        $query->bindValue(":currentDateTime", $this->currentDateTime);

        foreach ($data as $key => $value) {
            $query->bindValue(":$key", $value);
        }

        // Execute the query
        if (empty($this->errorArray))
            return $query->execute();
        else
            return false;
    }

    public function getNotification($token)
    {
        $query = $this->con->prepare("SELECT * FROM notifications WHERE receiver_token = :token AND status = 'active' ORDER BY start_date DESC");

        $query->bindValue(":token", $token);

        $query->execute();

        $notification = $query->fetchAll(PDO::FETCH_ASSOC);

        return $notification;
    }

    public function getError($error)
    {
        if (in_array($error, $this->errorArray)) {
            return $error;
        }
    }

}