<?php

    $conn = new mysqli('localhost', 'Haisam', 'test1234', 'image_entry');

    if (!$conn) {
        echo 'Connection error: ' . mysqli_connect_error();
    }

?>
