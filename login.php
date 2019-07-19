<?php

    session_start();

    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
        header('location: index.php');
        exit;
    }

    include('dbConfig.php');

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        if (empty($_POST["username"])) {
            $usernameErr = "Please enter a username";
        } else {
            $username = $conn -> real_escape_string($_POST["username"]);
        }

        if (empty($_POST["password"])) {
            $passwordErr = "Please enter a password";
        } else {
            $password = $conn -> real_escape_string($_POST["password"]);
        }

        if (empty($usernameErr) && empty($passwordErr)) {

            $sql = "SELECT user_id, username, password FROM users WHERE username = ?";
            
            if ($stmt = $conn -> prepare($sql)) {
                $stmt -> bind_param("s", $paramUsername);
                $paramUsername = $username;
                echo $paramUsername;

                if ($stmt -> execute()) {
                    $stmt -> store_result();

                    if ($stmt -> num_rows === 1) {
                        $stmt -> bind_result($id, $user, $pass);

                        if ($stmt -> fetch()) {

                            if ($password === $pass) {
                                
                                session_start();

                                $_SESSION["loggedIn"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;

                                header("location: index.php");
                            } else {
                                $passwordErr = "Incorrect password";
                            }
                        } 
                    } else {
                        $loginErr = "User does not exist";
                    }
                } else {
                    $loginErr = "Something went wrong";
                }
            } else {
                echo $conn -> error;
            }

        } else {
            $loginErr = "Username or password is incorrect";
        }
    } 


?>

<!DOCTYPE html>
<html lang="en">

    <?php include('templates/header.php'); ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        
        <?php echo(!empty($loginErr)) ? $loginErr : ''; ?>

        <?php echo (!empty($usernameErr)) ? $usernameErr : ''; ?>
        <label for="username">Username</label>
        <input type="text" name="username">

        <?php echo (!empty($passwordErr)) ? $passwordErr : ''; ?>
        <label for="password">Password</label>
        <input type="password" name="password">

        <button type="submit">Login</button>
    </form>

    <?php include('templates/footer.php'); ?>

</html>