<?php
    if (!isset($_SESSION)) {
        session_start();
    }
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="#">
    <title>Image</title>
</head>
<body>
    <nav>
        <div>
            <a href="index.php">Image</a>
            <ul>
                <li><a href="add.php">New Post</a></li>
        <?php 
            if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) { ?>
                
                <li>Hello <?php echo htmlspecialchars($_SESSION["username"]); ?> </li>
                <li><a href="logout.php">Sign out</a></li>
        <?php } else { ?>
                <li><a href="register.php">Sign Up</a></li>
                <li><a href="login.php">Login</a></li>
        <?php } ?>
            </ul>

            

        </div>
    </nav>
    