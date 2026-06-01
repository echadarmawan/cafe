<?php

include "conn.php";

$id = $_POST['pesanan_id'];
$status = $_POST['status'];

mysqli_query($conn,"
    UPDATE tb_pesanan
    SET status_pesanan='$status'
    WHERE id='$id'
");

header("Location: ../detail?id=".$id);