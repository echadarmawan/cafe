<?php
    include "conn.php";

    $id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : "";
    $foto_lama = (isset($_POST['foto_lama'])) ? $_POST['foto_lama'] : "";

    
    if(!empty($_POST['input_menu_validate'])) {
        $query = mysqli_prepare($conn, "DELETE FROM tb_menu WHERE id=?");
        mysqli_stmt_bind_param($query, "i", $id);
        $execute = mysqli_stmt_execute($query);

        if(mysqli_stmt_execute($query) === false) {
            $message = "<script>alert('Gagal menghapus data menu.')</script>";
        } else {
            unlink("../assets/images/" . $foto_lama);
            $message = "<script>
            alert('Berhasil menghapus data menu.');
            window.location = '../menu';
            </script>";
        }
    }

    echo $message; 
?>