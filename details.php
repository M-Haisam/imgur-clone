<?php

    include('dbConfig.php');

    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        // echo $id;
        $sql = "SELECT * FROM images WHERE id=$id";
        
        $result = mysqli_query($conn, $sql);
        
        $image = mysqli_fetch_assoc($result);
        // print_r($image);
        $imageURL = $image["file_name"];


        mysqli_free_result($result);
        mysqli_close($conn);

        // print_r($image);
    }

?>


<!DOCTYPE html>
<html lang="en">

    <?php include('templates/header.php'); ?>

    <div>
        <?php if ($image): ?>

            <h4><?php echo htmlspecialchars($image['title']); ?></h4>
            <img src="<?php echo $imageURL; ?>">

        <?php else: ?>

            <h4>No Images</h4>

        <?php endif; ?>
            
    </div>

    <?php include('templates/footer.php'); ?>
</html>