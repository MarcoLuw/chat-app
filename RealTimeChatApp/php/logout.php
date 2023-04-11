<?php
    session_start();
    // if user is logged in then come to this page otherwise go to login page
    if (isset($_SESSION['unique_id'])) {
        include_once "config.php";
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        // if logout id is set
        if (isset($logout_id)) {
            $status = "Offline now";
            // once user logout then we'll update this status to offline and in the login form we'll again update the status to active now if user logged in successfully
            $sql = "UPDATE users SET users.status = '{$status}' WHERE unique_id = {$logout_id}";
            $query = mysqli_query($conn, $sql);

            if ($query) {
                session_unset();
                session_destroy();
                header("location: ../login.php");
            }
        }
        else {
            header("location: ../users.php");
        }
    }
    else {
        header("location: ../login.php");
    }
?>