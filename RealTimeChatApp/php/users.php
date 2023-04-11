<?php 
    session_start();
    include_once "config.php";
    
    $outgoing_id = $_SESSION['unique_id'];  // Dung ben file data.php and search.php - This is to save the curren users id

    $my_query = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id}";
    $sql = mysqli_query($conn, $my_query);

    $output = "";

    //if there is only one row in database -> only logged in users and no others to chat
    if (mysqli_num_rows($sql) == 0) {
        $output .= "No users are available to chat";
    }
    elseif (mysqli_num_rows($sql) > 0) {  
        include "data.php";
    }
    echo $output;
?>