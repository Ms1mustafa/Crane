<?php
setcookie('token', '', -1, '/');
header("location: login.php");
exit();