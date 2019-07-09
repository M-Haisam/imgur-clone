<?php 

    include 'dbConfig.php';

    $target_dir = "uploads/";
    $file_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // $title = mysqli_real_escape_string($conn, $_POST["title"]);

    if(isset($_POST["submit"]) && !empty($_FILES["image"]["name"])) {
        $allowTypes = array('jpg', 'jpeg', 'png');
        if (in_array($imageFileType, $allowTypes)) {
            if ($_FILES["image"]["size"] < 500000) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    if (isset($_GET['album'])) {
                        $album_id = $_GET['album'];
                    } else {
                        $insert_album = $conn -> query("INSERT INTO albums (created) VALUE (NOW())");
                        $album_id = mysqli_insert_id($conn);
                    }
                    $insert_image = $conn -> query("INSERT INTO images (file_name, album_id) VALUES ('$target_file', '$album_id')");
                    if ($insert_image) {
                        header('location: details.php?album=' . $album_id);
                    } else {
                        echo "Update failed";
                        }
                } else {
                    echo "Error uploading file";
                }
            } else {
                echo "Image too large";
            }
        } else {
            echo "Unsupported Format";
        }
    } else {
        echo "Select Image";
    }