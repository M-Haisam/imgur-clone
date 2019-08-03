<?php

        include('dbConfig.php');

        session_start();

        // $loginBool = (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) ? true : false;
        // echo $loginBool;

        
        // Delete an image
        if (isset($_POST['delete'])) {

            if (isset($_SESSION["albumID"])) {
                $album_id = $_SESSION["albumID"];
            }

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
                    unset($_SESSION["albumID"]);
                    header('Location: index.php');
                }
            } else {
                echo 'error deleting';
            }
        }

        // Display images
        if (isset($_GET['album'])) {
            
            // $action = "details.php?album=" . $_GET['album'];
            // echo $album_id;
            $album_id = mysqli_real_escape_string($conn, $_GET['album']);

            $_SESSION["albumID"] = $album_id;

            if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
                $sql = "SELECT user_id FROM albums WHERE album_id = $album_id";
                $result = $conn -> query($sql);
    
                if ($result -> num_rows > 0) {
                    while ($row = $result -> fetch_assoc()) {
                        $userID = $row["user_id"];
                        // echo $userID;
                    }
                    if ($userID == $_SESSION["id"]) {
                        $userVerified = true;
                        // echo $userVerified;
                    } else {
                        $userVerified = false;
                        // echo $userVerified;
                    }
                } else {
                    echo "No results for users";
                }
            }

            $sql = "SELECT images.id, images.file_name, images.description, albums.title, albums.created FROM images JOIN albums ON images.album_id = $album_id AND albums.album_id = $album_id";
                
            $result = mysqli_query($conn, $sql);
            

?>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
			integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
			crossorigin="anonymous"></script>
<script src="ajax.js"></script>

<!DOCTYPE html>
<html lang="en">

    <?php include('templates/header.php'); ?>

    <div>
            
        <?php
            
            $i = 0;

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $albumTitle = $row["title"];
                    $albumCreated = $row["created"];
                    $imageID = $row["id"];
                    $imageURL = $row["file_name"];
                    $imageDescription = $row["description"];
                    

        // Display/Edit title
                if (isset($userVerified) && $userVerified) {    
                    if (!$i++) { ?>

                        <input type="text" class="title" id="<?php echo $album_id; ?>" placeholder="Add a title" value="<?php echo $albumTitle; ?>">   

        <?php      } 

                } else { ?>

                        <h3><?php echo $albumTitle; ?></h3>

        <?php   } ?>



            <img src="<?php echo $imageURL; ?>" />
                    


        <!-- Display/Edit description -->
        <?php 
                
            if (isset($userVerified) && $userVerified) { ?>
                        
                <textarea name="description" class="description" id="<?php echo $imageID; ?>" placeholder="Add a description"><?php echo $imageDescription ?></textarea>
                        
        <?php } else { ?>
            
                <p><?php echo $imageDescription; ?> </p>

        <?php } ?>
        


        <!-- Delete image -->
        <?php
            if (isset($userVerified) && $userVerified) { ?>
                    <form action="details.php" method="POST">
                        <input type="hidden" name="image_id" value="<?php echo $imageID; ?>">
                        <input type="submit" name="delete" value="Delete">
                    </form>
        <?php } ?>

        <?php } ?>  


        <p><?php echo $albumCreated; ?></p>
            
        <?php } else {
            echo "The page you are looking for doesn't exist";
        }


        mysqli_free_result($result);
        mysqli_close($conn);

        // print_r($image);
    }

    ?>

    <?php
        if (isset($userVerified) && $userVerified) { ?>
            <a href="add.php">Add Image</a>
    <?php } ?>
            
    </div>

    <?php include('templates/footer.php'); ?>
</html>