<!DOCTYPE html>
<html lang="en">

    <?php include('templates/header.php'); ?>

    <form action="checklogin.php" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username">

        <label for="password">Password</label>
        <input type="password" name="password">

        <button type="submit">Submit</button>
    </form>

    <?php include('templates/header.php'); ?>

</html>