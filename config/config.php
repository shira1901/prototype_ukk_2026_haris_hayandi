<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "db_aspirasi";

    $conn = mysqli_connect($hostname, $username, $password, $database) or die("Koneksi ke database gagal: " . mysqli_connect_error());
?>