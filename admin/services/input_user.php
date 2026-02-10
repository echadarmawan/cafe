<?php
include "conn.php";

$nama = (isset($_POST['nama'])) ? htmlentities($_POST['nama']) : "";
$email = (isset($_POST['email'])) ? htmlentities($_POST['email']) : "";
$level = (isset($_POST['level'])) ? htmlentities($_POST['level']) : "";
$nohp = (isset($_POST['nohp'])) ? htmlentities($_POST['nohp']) : "";
$alamat = (isset($_POST['alamat'])) ? htmlentities($_POST['alamat']) : "";
$pass = (isset($_POST['pass'])) ? md5($_POST['pass']) : "";

if (!empty($_POST['input_user_validate'])) {
    $select_query = mysqli_prepare($conn, "SELECT * FROM tb_user WHERE email = ?");
    mysqli_stmt_bind_param($select_query, "s", $email);
    mysqli_stmt_execute($select_query);
    mysqli_stmt_store_result($select_query);

    if (mysqli_stmt_num_rows($select_query) > 0) {
        $message = "<script>
            alert('Email sudah terdaftar, silahkan gunakan email lain.');
            window.location = '../user';
            </script>";
    } else {
        $query = mysqli_prepare($conn, "INSERT INTO tb_user (nama, email, password, level, nohp, alamat) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($query, "sssiss", $nama, $email, $pass, $level, $nohp, $alamat);
        $execute = mysqli_stmt_execute($query);

        if (!$execute) {
            $message = "<script>alert('Gagal menambahkan data user.')</script>";
        } else {
            $message = "<script>
            alert('Berhasil menambahkan data user.');
            window.location = '../user';
            </script>";
        }
    }
}

echo $message;
?>