<?php
class Encryption
{
    public static function encryptToken($token, $encryptionKey)
    {
        try {
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            $encryptedToken = openssl_encrypt($token, 'aes-256-cbc', $encryptionKey, 0, $iv);
            // Encode the encrypted token using Base64 without special symbols
            return strtr(base64_encode($encryptedToken . '::' . $iv), '+/', '-_');
        } catch (Exception $e) {
            return header("location: logout.php");
        }
    }

    public static function decryptToken($encryptedToken, $encryptionKey)
    {
        try {
            // Decode the Base64-encoded token, replacing characters to allow for decryption
            $decodedToken = base64_decode(strtr($encryptedToken, '-_', '+/'));
            list($tokenData, $iv) = explode('::', $decodedToken, 2);
            if (strlen($iv) > 16) {
                // IV length is incorrect, log out by redirecting to logout.php
                header("location: logout.php");
                exit;
            }
            return openssl_decrypt($tokenData, 'aes-256-cbc', $encryptionKey, 0, $iv);
        } catch (Exception $e) {
            // return header("location: logout.php");
        }
    }
}