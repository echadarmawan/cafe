<?php
    include "conn.php";

    $id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : "";

    if(!empty($_POST['input_user_validate'])) {
        $query = mysqli_prepare($conn, "UPDATE tb_user SET password=MD5(?) WHERE id=?");
        $default_pass = "12345";
        mysqli_stmt_bind_param($query, "si", $default_pass, $id);
        $execute = mysqli_stmt_execute($query);

        if($execute === false) {
            $message = "<script>alert('Gagal mereset password.')</script>";
        } else {
            $message = "<script>
            alert('Berhasil mereset password.');
            window.location = '../user';
            </script>";
        }
    }

    echo $message; 
?>