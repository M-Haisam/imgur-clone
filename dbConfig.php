<?php

    $conn = mysqli_connect('localhost', 'Haisam', 'test1234', 'image_entry');

    if (!$conn) {
        echo 'Connection error: ' . mysqli_connect_error();
    }

?>
