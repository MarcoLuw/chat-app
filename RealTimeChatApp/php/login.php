<?php
    session_start();
    include_once "config.php";
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    if (!empty($email) && !empty($password)) {
        // check email and password are matched to any email and password in database
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        // If the account matched
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
            
            $user_pass = md5($password);
            $enc_pass = $row['password'];
            if ($user_pass === $enc_pass){
                $status = "Active now";
                // Update user status to active now if user login successfully
                $sql2 = "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}";
                $query = mysqli_query($conn, $sql2);

                if ($query) {
                    $_SESSION['unique_id'] = $row['unique_id'];
                    echo "Success";
                }
                else{
                    echo "Something went wrong. Please try again!";
                }
            }
            else {
                echo "Email or Password is Incorrect!";
            }
        }
        else {
            echo "$email - This email not Exist!";
        }
    }
    else {
        echo "All input fields are required!";
    }
?>