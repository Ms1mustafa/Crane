<?php
class Constants
{
    public static $fildsRequired = "All fields are required";
    public static $tokenTaken = "Something went wrong. Please try again";
    public static $rate_limit = "Rate limit exceeded. Please try again later";
    public static $nameTaken = "name already in use";

    //********Account ************* */
    public static $usernameCharacters = "Your username must be between 2 and 25 characters";
    public static $usernameTaken = "Username already in use";
    public static $usernameNotExist = "Username Not Exist";
    public static $emailInvalid = "Invalid email";
    public static $emailTaken = "Email already in use";
    public static $passwordLength = "Your password must be between 5 and 25 characters";
    public static $loginFailed = "Your username or password was incorrect";
    public static $requestFailed = "You should fill all fields";
    public static $workOrderNoTaken = "workOrderNo already in use";
    public static $tokenEncKey = "msSCAra";

    //********Equipment ************* */
    public static $descriptionTaken = "Description already in use";
    public static $vechicle_noTaken = "Vechicle number already in use";
    public static $asset_numberTaken = "Asset number already in use";

}
?>