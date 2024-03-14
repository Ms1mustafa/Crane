<?php
if (!@$_COOKIE["token"]) {
    header("location: login.php");
}

$pageURL = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
$pageURL .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

echo $pageURL;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="sheard.js"></script>
    <script>getIsLoggedIn()</script>
    <title>Document</title>
</head>

<body>

</body>

</html>