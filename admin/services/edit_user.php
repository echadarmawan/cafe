<?php
    include "conn.php";

    $id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : "";
    $nama = (isset($_POST['nama'])) ? htmlentities($_POST['nama']) : "";
    $email = (isset($_POST['email'])) ? htmlentities($_POST['email']) : "";
    $level = (isset($_POST['level'])) ? htmlentities($_POST['level']) : "";
    $nohp = (isset($_POST['nohp'])) ? htmlentities($_POST['nohp']) : "";
    $alamat = (isset($_POST['alamat'])) ? htmlentities($_POST['alamat']) : "";
    
    if(!empty($_POST['input_user_validate'])) {
        $select_query = mysqli_prepare($conn, "SELECT * FROM tb_user WHERE email = ? AND id != ?");
        mysqli_stmt_bind_param($select_query, "si", $email, $id);
        mysqli_stmt_execute($select_query);
        mysqli_stmt_store_result($select_query);

        if (mysqli_stmt_num_rows($select_query) > 0) {
            $message = "<script>
                alert('Email sudah terdaftar, silahkan gunakan email lain.');
                window.location = '../user';
                </script>";
        } else {
            $query = mysqli_prepare($conn, "UPDATE tb_user SET nama=?, email=?, level=?, nohp=?, alamat=? WHERE id=?");
            mysqli_stmt_bind_param($query, "ssissi", $nama, $email, $level, $nohp, $alamat, $id);
            $execute = mysqli_stmt_execute($query);

            if($execute === false) {
                $message = "<script>alert('Gagal mengubah data user.')</script>";
            } else {
                $message = "<script>
                alert('Berhasil mengubah data user.');
                window.location = '../user';
                </script>";
            }
        }
    }

    echo $message; 
?>