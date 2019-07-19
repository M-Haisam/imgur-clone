<?php

    session_start();

    if (isset($_SESSION["albumID"])) {
        unset($_SESSION["albumID"]);
    }

    include('dbConfig.php');
    
    $query = $conn -> query("SELECT * FROM images");

    if ($query -> num_rows > 0) {
        while ($row = $query -> fetch_assoc()) {
            $imageURL = $row["file_name"];
?>
        <img src="<?php echo $imageURL; ?>" />

<?php

        }
    } else {
        echo "No images found";
    }
?>

<!DOCTYPE html>
<html lang="en">

    <?php include('templates/header.php'); ?>
    
    <?php include('templates/footer.php'); ?>

</html>