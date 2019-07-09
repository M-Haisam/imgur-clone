<?php 

    include('dbConfig.php');

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT username, password FROM users WHERE username = '$username' and password = '$password'";

    $result = mysql_query($sql);

    $count = mysql_num_rows($result);

    if ($count == 1) {
        session_register("username");
        session_register("password");
        header('location: login_success.php');
    } else {
        echo "Error logging in";
    }

