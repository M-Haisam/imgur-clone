<?php

    include('dbConfig.php');

    session_start();

    if(!session_is_registered(username)) {
        header('location: login.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

    <?php include('templates/header'); ?>

    <p>Login Successful</p>

    <?php include('templates/footer'); ?>

</html>