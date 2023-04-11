<?php
    session_start();
    if (!isset($_SESSION['unique_id'])) {
        header("location: login.php");
    }
?>

<?php include_once "header.php" ?>
<body>
    <div class="wrapper">
        <section class="users">
            <header>
                <?php
                    include_once "php/config.php";
                    $my_query = "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}";
                    $sql = mysqli_query($conn, $my_query);
                    if (mysqli_num_rows($sql) > 0) {
                        $row = mysqli_fetch_assoc($sql);
                    }
                ?>
                <div class="content">
                    <img src="php/images/<?php echo $row['img']; ?>" alt="ava">
                    <div class="details">
                        <span>
                            <?php echo $row['fname']." ".$row['lname']; ?>
                        </span>
                        <p>
                            <?php echo $row['status']; ?>
                        </p>
                    </div>
                </div>
                <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">Logout</a>
            </header>
            <div class="search">
                <span class="text">Select an user to start chat</span>
                <input type="text" placeholder="Enter name to search...">
                <button><i class="fa fa-search"></i></button>
            </div>
            <div class="users-list">
                
            </div>
        </section>
    </div>

    <script src="js/users.js"></script>

</body>
</html>