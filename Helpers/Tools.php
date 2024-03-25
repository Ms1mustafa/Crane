<?php
class Tools
{
    public static function generateUniqueToken()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < 15; $i++) {
            $token .= $characters[mt_rand(0, $max)]; // Append a random character from $characters
        }
        return $token;
    }

    public static function sanitizeFormString($inputText)
    {
        $inputText = strip_tags($inputText);
        return $inputText;
    }

    public static function sanitizeFormEmail($inputText)
    {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
    }

    public static function getDateOnly($dateTime)
    {
        $date = new DateTime($dateTime);
        return $date->format('Y-m-d');
    }

    public static function getURLParam($param)
    {
        return $_GET[$param];
    }
    public static function getFromCookie($param)
    {
        return $_COOKIE[$param];
    }

    public static function getFromDate($dateTime, $get)
    {
        $date = new DateTime($dateTime);

        if ($get == 'year')
            return $date->format('Y');
        if ($get == 'month')
            return $date->format('m');
        if ($get == 'day')
            return $date->format('d');
        if ($get == 'hour')
            return $date->format('H');
        if ($get == 'minute')
            return $date->format('i');
        if ($get == 'second')
            return $date->format('s');
    }
}
