<?php 

    include 'dbConfig.php';

    $target_dir = "uploads/";
    $file_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $title = mysqli_real_escape_string($conn, $_POST["title"]);

    if(isset($_POST["submit"]) && !empty($_FILES["image"]["name"])) {
        $allowTypes = array('jpg', 'jpeg', 'png');
        if (in_array($imageFileType, $allowTypes)) {
            if ($_FILES["image"]["size"] < 500000) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $insert = $conn -> query("INSERT INTO images (file_name, title, uploaded_on) VALUES ('$target_file', '$title' , NOW())");
                    $id = mysqli_insert_id($conn);
                    if ($insert) {
                        header('location: details.php?id=' . $id);
                    } else {
                        echo "Upload Failed";
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

    if ($_FILES["image"]["size"] > 500000) {
        echo "Image too large";
    }

    if ($imageFileType !== "jpg" && $imageFileType !== "png" && $imageFileType !== "jpeg") {
        echo "Only JPG, JPEG, and PNG formats allowed.";
    }