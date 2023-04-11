<?php 
    //This file for configuration
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "chatapp";
    $conn = mysqli_connect($hostname, $username, $password, $dbname);

    if (!$conn) {
        echo "Database connection failed".mysqli_connect_error();
    }
?>