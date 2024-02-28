<?php
setcookie('token', '', time() - 3600, '/');

header("location: login.php");
exit();