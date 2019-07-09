<?php

    include('dbConfig.php');

    session_start();
    $_SESSION['message'] = '';

    if (isset($_POST['submit'])) {

        if ($_POST['password'] === $_POST['confirm-password']) {

            $username = $conn->real_escape_string($_POST['username']);
            $email = $conn->real_escape_string($_POST['email']);
            $password = $conn->real_escape_string($_POST['password']);

            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            
            if ($conn -> query($sql) === true) {
                $_SESSION['message'] =  "Registration Successful";
                header('location: index.php');
            } else {
                $_SESSION['message'] =  "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $_SESSION['message'] = "Passoword does not match";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

    <?php include('templates/header.php'); ?>

    <p><?php echo $_SESSION['message']; ?> </p>

    <form action="register.php" method="POST">

        <label for="username">Username</label>
        <input type="text" name="username" required>

        <label for="email">Email</label>
        <input type="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" name="password" required>

        <label for="confirm-password">Confirm Password</label>
        <input type="password" name="confirm-password" required>

        <button type="submit" name="submit">Register</button>
    </form>     

    <?php include('templates/footer.php'); ?>

</html>