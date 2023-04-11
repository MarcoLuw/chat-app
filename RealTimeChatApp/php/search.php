<?php
    session_start();
    include_once "config.php";
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
    $outgoing_id = $_SESSION['unique_id'];
    $output = "";


    $query = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%')";
    $sql = mysqli_query($conn, $query);

    if (mysqli_num_rows($sql) > 0) {    
        include "data.php";
    }
    else {      // if there is no user related to the search term
        $output .= "No user found";
    }
    echo $output;
?>
