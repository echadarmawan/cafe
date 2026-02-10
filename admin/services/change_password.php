<?php
    session_start();
    include "conn.php";

    $id = (isset($_POST['id'])) ? htmlentities($_POST['id']) : "";
    $pass = (isset($_POST['oldpass'])) ? htmlentities($_POST['oldpass']) : "";
    $newpass = (isset($_POST['newpass'])) ? htmlentities($_POST['newpass']) : "";
    $confirmnewpass = (isset($_POST['confirmnewpass'])) ? htmlentities($_POST['confirmnewpass']) : "";

    if(!empty($_POST['change_pass_validate'])) {
        $query = mysqli_prepare($conn, "SELECT * FROM tb_user WHERE email=? AND password=MD5(?)");
        mysqli_stmt_bind_param($query, "is", $_SESSION["email_cafe"], $pass);
        mysqli_stmt_execute($query);
        $result = mysqli_fetch_assoc(mysqli_stmt_get_result($query));

        if($result) {
            if($newpass === $confirmnewpass) {
                $update_query = mysqli_prepare($conn, "UPDATE tb_user SET password=MD5(?) WHERE id=?");
                mysqli_stmt_bind_param($update_query, "si", $newpass, $id);
                $execute = mysqli_stmt_execute($update_query);

                if($execute === false) {
                    $message = "<script>alert('Gagal mengubah password.')</script>";
                } else {
                    $message = "<script>
                    alert('Berhasil mengubah password.');
                    window.location = '../user';
                    </script>";
                }
            } else {
                $message = "<script>
                alert('Password baru dan konfirmasi password baru tidak sesuai.')
                window.location='../user'
                </script>";
            }
        } else { ?>
            <script>
                alert('Password lama tidak sesuai.')
                window.location="../login"
            </script>
<?php
        }
    }

    echo $message; 
?>