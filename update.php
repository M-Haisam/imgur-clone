<?php

    include('dbConfig.php');

    if (isset($_POST['desc'])) {

        $id = $_POST['id'];
        $desc = mysqli_real_escape_string($conn, $_POST['desc']);
        // echo $id;
        // echo $desc;

        $sql = "UPDATE images SET description='$desc' WHERE id='$id'";

        if (!$conn -> query($sql)) {
            echo "Failed";
        } 
        
    } elseif(isset($_POST['title'])) {

        $id = $_POST['id'];
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        // echo $title;
        $sql = "UPDATE albums SET title='$title' WHERE album_id='$id'";

        if (!$conn -> query($sql)) {
            echo "Failed";
        }

    }   