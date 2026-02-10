<?php
    include "conn.php";

    $id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : "";
    
    if(!empty($_POST['input_category_validate'])) {
        // Melakukan soft delete dengan menghapus data dari tabel
        $query = mysqli_prepare($conn, "UPDATE tb_jenis SET status = 0 WHERE id = ?");
        mysqli_stmt_bind_param($query, "i", $id);
        $execute = mysqli_stmt_execute($query);

        if(mysqli_stmt_execute($query) === false) {
            $message = "<script>alert('Gagal menghapus data jenis kategori.')</script>";
        } else {
            $message = "<script>
            alert('Berhasil menghapus data jenis kategori.');
            window.location = '../category';
            </script>";
        }
    }

    echo $message; 
?>