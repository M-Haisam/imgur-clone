<?php 

    session_start();

    if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
        header("location: login.php");
    }

    include 'dbConfig.php';

    $user_id = $_SESSION["id"];

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
                    if (isset($_SESSION["albumID"])) {
                        $album_id = $_SESSION["albumID"];
                    } else {
                        $insert_album = $conn -> query("INSERT INTO albums (created, user_id) VALUES (NOW(), '$user_id')");
                        $album_id = mysqli_insert_id($conn);
                    }
                    $insert_image = $conn -> query("INSERT INTO images (file_name, album_id) VALUES ('$target_file', '$album_id')");
                    if ($insert_image) {
                        header('location: details.php?album=' . $album_id);
                    } else {
                        echo "Upload failed";
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