<?php

    include('dbConfig.php');

    session_start();
    $_SESSION['message'] = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       
        $usernameEntry = $conn->real_escape_string($_POST['username']);
        $emailEntry = $conn->real_escape_string($_POST['email']);
        $passwordEntry = $conn->real_escape_string($_POST['password']);
        $confirmPasswordEntry = $conn->real_escape_string($_POST['confirm-password']);

        if (empty($_POST['username'])) {
            $usernameErr = "Please enter a username";
        } else {
            $countUsername = $conn -> query("SELECT COUNT(*) AS usernameCount FROM users WHERE username = '$usernameEntry'") or die($conn -> error);
            $rows = $countUsername -> fetch_assoc();
            $count = $rows['usernameCount'];
            // echo $count;
            
            if ($count > 0 ) {
                $usernameErr= "Username is already taken";
            } else {
                $username = $conn->real_escape_string($_POST['username']);
            }
        }

        if (empty($_POST['email'])) {
            $emailErr = "Please enter a valid email";
        } else {
            $countEmail = $conn -> query("SELECT COUNT(*) AS emailCount FROM users WHERE email = '$emailEntry'") or die($conn -> error);
            $rows = $countEmail -> fetch_assoc();

            if ($rows['emailCount'] > 0) {
                $emailErr = "Email is already registered";
            } else {
                $email = $conn -> real_escape_string($_POST['email']);
            }
        }

        if (empty($_POST['password'])) {
            $passwordErr = "Please enter a password";
        } else {
            if (strlen($passwordEntry) > 6 ) {
                $password = $conn -> real_escape_string($_POST['password']);
            } else {
                $passwordErr = "Password is too short";
            }
        }

        if (empty($_POST['confirm-password'])) {
            $confirmPasswordErr = "Please confirm password";
        } else {
            if ($passwordEntry !== $confirmPasswordEntry) {
                $confirmPasswordErr = "Password did not match";
            }
        }

        if (empty($usernameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPasswordErr)) {
            
            $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            
            if ($conn -> query($sql) === true) {
                $_SESSION['message'] =  "Registration Successful";
                header('location: index.php');
            } else {
                $_SESSION['message'] =  "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        
    }
    

?>

<!DOCTYPE html>
<html lang="en">

    <?php include('templates/header.php'); ?>

    <p>Sign up to add your own images!</p>

    <p><?php echo $_SESSION['message']; ?> </p>

    <form action="register.php" method="POST">

        <?php echo (!empty($usernameErr)) ? $usernameErr : ''; ?>
        <label for="username">Username</label>
        <input type="text" name="username" required>

        <?php echo (!empty($emailErr)) ? $emailErr : ''; ?>
        <label for="email">Email</label>
        <input type="email" name="email" required>

        <?php echo (!empty($passwordErr)) ? $passwordErr : ''; ?>
        <label for="password">Password</label>
        <input type="password" name="password" required>

        <?php echo (!empty($confirmPasswordErr)) ? $confirmPasswordErr : ''; ?>
        <label for="confirm-password">Confirm Password</label>
        <input type="password" name="confirm-password" required>

        <button type="submit" name="submit">Register</button>
    </form>     

    <?php include('templates/footer.php'); ?>

</html>