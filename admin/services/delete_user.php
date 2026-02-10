<?php
    include "conn.php";

    $id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : "";
    
    if(!empty($_POST['input_user_validate'])) {
        $query = mysqli_prepare($conn, "DELETE FROM tb_user WHERE id=?");
        mysqli_stmt_bind_param($query, "i", $id);
        $execute = mysqli_stmt_execute($query);

        if(mysqli_stmt_execute($query) === false) {
            $message = "<script>alert('Gagal menghapus data user.')</script>";
        } else {
            $message = "<script>
            alert('Berhasil menghapus data user.');
            window.location = '../user';
            </script>";
        }
    }

    echo $message; 
?>