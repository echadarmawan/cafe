<?php
    include "conn.php";

    $id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : "";
    $jenis = (isset($_POST['jenis'])) ? htmlentities($_POST['jenis']) : "";
    $kategori = (isset($_POST['kategori'])) ? htmlentities($_POST['kategori']) : "";
    
    if(!empty($_POST['input_category_validate'])) {
        $select_query = mysqli_prepare($conn, "SELECT * FROM tb_jenis WHERE nama_jenis = ? AND kategori_id = ? AND id != ?");
        mysqli_stmt_bind_param($select_query, "ssi", $jenis, $kategori, $id);
        mysqli_stmt_execute($select_query);
        mysqli_stmt_store_result($select_query);

        if (mysqli_stmt_num_rows($select_query) > 0) {
            $message = "<script>
                alert('Jenis kategori sudah terdaftar, silahkan gunakan jenis kategori lain.');
                window.location = '../category';
                </script>";
        } else {
            $query = mysqli_prepare($conn, "UPDATE tb_jenis SET nama_jenis=?, kategori_id=? WHERE id=?");
            mysqli_stmt_bind_param($query, "ssi", $jenis, $kategori, $id);
            $execute = mysqli_stmt_execute($query);

            if($execute === false) {
                $message = "<script>alert('Gagal mengubah data jenis kategori.')</script>";
            } else {
                $message = "<script>
                alert('Berhasil mengubah data jenis kategori.');
                window.location = '../category';
                </script>";
            }
        }
    }

    echo $message; 
?>