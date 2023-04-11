<?php 
    //echo "This file from sign up";
    session_start();
    include_once "config.php";
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    //$image = mysqli_real_escape_string($conn, $_POST['image']);

    if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
        // check user name valid or not
        // if email valid
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // check that email already exist in the database or not
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
            // if email is already exist
            if (mysqli_num_rows($sql) > 0) {
                echo "$email - This email is already exist";
            }
            else {
                // let's check user upload file or not
                // if file is uploaded
                if (isset($_FILES['image'])) {
                    $img_name = $_FILES['image']['name'];   // Getting user uploaded img name
                    $img_type = $_FILES['image']['type'];   // Getting user upload img type
                    $tmp_name = $_FILES['image']['tmp_name']; // this temporary name is used to save/move file in our folder

                    // let's explode image and get the last extension like jpg png
                    $img_explode = explode('.', $img_name);
                    $img_ext = end($img_explode);   // get the extension of an user uploaded img file
                    $extensions = ["png", "jpeg", "jpg"];
                    
                    //  if user uploaded img ext is matched with any array extensions
                    if (in_array($img_ext, $extensions) === true) {
                        $time = time();     //this will return current time...

                        // we need this time because when uploading user img to our folder - we rename user file with current time so all the img file will have a unique name

                        // let's move the user uploaded img to our particular folder
                        $new_img_name = $time.$img_name;

                        // we don't upload img file in the database, just save the file url of these. Actually file will be saved in our particular folder

                        //if user upload img move to our folder successfully
                        if (move_uploaded_file($tmp_name, "images/".$new_img_name)){
                            $status = "Active now"; //once user signed up then his status will be active now
                            $random_id = rand(time(), 10000000); // creating random id for user
                            $encrypt_pass = md5($password);
                            // insert all user data inside table
                            $sql2 = mysqli_query($conn, "INSERT INTO users(unique_id, fname, lname, email, password, img, status)
                            VALUE ({$random_id}, '{$fname}', '{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");

                            // if these data inserted
                            if ($sql2) {
                                $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                if (mysqli_num_rows($sql3) > 0) {
                                    $row = mysqli_fetch_assoc($sql3);   //Here mysqli_num_rows($sql3) = 1 (1 row)since there is 1 email for unique person
                                    $_SESSION['unique_id'] = $row['unique_id'];     // use this session we used user unique_id in other php file
                                    echo "Success";
                                }
                                else {
                                    echo "This email address is not exist!";
                                }
                            }
                            else {
                                echo "Something went wrong";
                            }
                        }
                    }
                    else {
                        echo "Please select right image file - jpeg, png, jpg !";
                    }
                }
                else {
                    echo "Please upload an image file !";
                }
            }
        }
        else {
            echo "$email - This is not a valid email";
        }
    }
    else {
        echo "All input field are required";
    }
?>