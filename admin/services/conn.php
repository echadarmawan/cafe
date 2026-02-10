<?php
    $conn = mysqli_connect("localhost", "root", "", "db_cafe");

    if(!$conn) {
        echo "Gagal koneksi";
    }
?>