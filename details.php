<?php

        include('dbConfig.php');

        $album_id = mysqli_real_escape_string($conn, $_GET['album']);

        // Deleting an image
        if (isset($_POST['delete'])) {
            $deleteID = mysqli_real_escape_string($conn, $_POST['image_id']);
            
            $sql = "DELETE FROM images WHERE id = $deleteID";

            if (mysqli_query($conn, $sql)) {
                $query = $conn -> query("SELECT COUNT(*) AS results FROM images WHERE album_id = $album_id");
                $row = $query->fetch_assoc();
                // echo $row['results'];
                // print_r($query);
                if ($row['results'] > 0) {
                    header('Location: details.php?album='. $album_id);
                } else {
                    $delete = $conn -> query("DELETE FROM albums WHERE album_id = $album_id");
                    header('Location: index.php');
                }
            } else {
                echo 'error deleting';
            }
        }

        // Displaying images
        if (isset($_GET['album'])) {
            
            $action = "details.php?album=" . $_GET['album'];
            // echo $album_id;
            $sql = "SELECT images.id, images.file_name, images.description, albums.created FROM images JOIN albums ON images.album_id = $album_id AND albums.album_id = $album_id";
                
            $result = mysqli_query($conn, $sql);
            

?>


<!DOCTYPE html>
<html lang="en">

    <?php include('templates/header.php'); ?>

    <div>

        <?php

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $imageID = $row["id"];
                    $imageURL = $row["file_name"];
                    $imageDescription = $row["description"];
                    $albumCreated = $row["created"];

                ?>  
                    <img src="<?php echo $imageURL; ?>" />
                    <form action="<?php echo $action; ?>" method="POST">
                        <input type="hidden" name="image_id" value="<?php echo $imageID; ?>">
                        <input type="submit" name="delete" value="Delete">
                    </form>
                            

        <?php

            } ?>  

            <p><?php echo $albumCreated; ?></p>
            
        <?php
        } else {
            echo "Wrong page";
        }


        mysqli_free_result($result);
        mysqli_close($conn);

        // print_r($image);
    }

    ?>

        <a href="add.php?album=<?php echo $album_id; ?>">Add Image</a>

            
    </div>

    <?php include('templates/footer.php'); ?>
</html>