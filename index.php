<?php

    include('dbConfig.php');

    $query = $conn -> query("SELECT * FROM images ORDER BY uploaded_on DESC");

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