<?php
$dbConnection = mysqli_connect("localhost","root","","shopping");

if (mysqli_connect_error()) {
    echo "Database connection failed: " . mysqli_connect_error();
    exit();
}
?>