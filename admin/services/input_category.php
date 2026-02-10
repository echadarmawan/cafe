<?php
include "conn.php";

$jenis = (isset($_POST['jenis'])) ? htmlentities($_POST['jenis']) : "";
$kategori = (isset($_POST['kategori'])) ? htmlentities($_POST['kategori']) : "";

if (!empty($_POST['input_category_validate'])) {
    $select_query = mysqli_prepare($conn, "SELECT * FROM tb_jenis WHERE nama_jenis = ? AND kategori_id = ? AND status = 1");
    mysqli_stmt_bind_param($select_query, "si", $jenis, $kategori);
    mysqli_stmt_execute($select_query);
    mysqli_stmt_store_result($select_query);

    if (mysqli_stmt_num_rows($select_query) > 0) {
        $message = "<script>
            alert('Jenis kategori sudah terdaftar, silahkan gunakan jenis kategori lain.');
            window.location = '../category';
            </script>";
    } else {
        // Memulihknan data yang sebelumnya dihapus secara logis
        $restore_query = mysqli_prepare($conn, "UPDATE tb_jenis SET status = 1 WHERE nama_jenis = ? AND kategori_id = ? AND status = 0");
        mysqli_stmt_bind_param($restore_query, "si", $jenis, $kategori);
        mysqli_stmt_execute($restore_query);
        if (mysqli_stmt_affected_rows($restore_query) > 0) {
            $message = "<script>
            alert('Data jenis kategori yang sebelumnya dihapus berhasil dipulihkan.');
            window.location = '../category';
            </script>";
        } else {
            // Menambahkan data baru jika tidak ada data yang dipulihkan
            $query = mysqli_prepare($conn, "INSERT INTO tb_jenis (nama_jenis, kategori_id) VALUES (?, ?)");
            mysqli_stmt_bind_param($query, "si", $jenis, $kategori);
            $execute = mysqli_stmt_execute($query);

            if (!$execute) {
                $message = "<script>alert('Gagal menambahkan data jenis kategori.')</script>";
            } else {
                $message = "<script>
                alert('Berhasil menambahkan data jenis kategori.');
                window.location = '../category';
                </script>";
            }
        }
    }
}

echo $message;
?>