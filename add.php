<?php 

    if (isset($_GET['album'])) {
        // if (empty($_POST['image'])) {
        //     echo "Image is required";
        // }
        echo $_GET['album'];
        $action = "upload.php?album=" . $_GET['album'];
        // if (empty($_POST['title'])) {
        //     echo "Title is required";
        // }

        // header('location: index.php');
    } else {
        $action = "upload.php";
    }

?>


<!DOCTYPE html>
<html>
    <?php include('templates/header.php'); ?>

    <section>
        <h4>Upload Image</h4>
        <form action=<?php echo $action; ?> method="POST" enctype="multipart/form-data">
            <input type="hidden" name="MAX_FILE_SIZE" value="500000">
            <input type="file" name="image" accept="image/png, image/jpeg" required>
            
            <!-- <label for="title">Image Title</label>
            <input type="text" name="title" required> -->

            <button type="submit" name="submit">Upload</button>
        </form>
    </section>

    <?php include('templates/footer.php'); ?>

</html>