<?php
    $con = mysqli_connect("localhost", "root", "", "db_php");

    if (!$con) {
        echo "Database não conectada!";
    }
?>
