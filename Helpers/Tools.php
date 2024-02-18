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

}
