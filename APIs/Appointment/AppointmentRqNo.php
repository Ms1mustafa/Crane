<?php
class AppointmentRqNo
{

    public static function getRqNo($appointment)
    {
        include ('../../includes/config.php');
        $appointmentRqNo = $appointment->getRqNo();

        $currentYear = date("Y");
        $preFullCode = @$appointmentRqNo;

        $preYear = substr($preFullCode, 0, 4);
        $preNumber = (int) substr($preFullCode, 4);

        if ($preYear == $currentYear) {
            // Increment the number after the year
            $newNumber = $preNumber + 1;
        } else {
            // If it's a new year, start with 1
            $newNumber = '0001';
        }

        $code = $currentYear . str_pad($newNumber, strlen($preFullCode) - 4, "0", STR_PAD_LEFT);
        return $code; // Output the new code

    }
}
