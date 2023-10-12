<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "webdev";


$con = new mysqli($servername, $username, $password, $db_name);
if ($con->connect_errno > 0) {
    die('Unable to connect to database [' . $con->connect_error . ']');
}

?>


