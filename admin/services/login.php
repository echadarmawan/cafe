<?php
    session_start();
    include "conn.php";

    $email = (isset($_POST['email'])) ? htmlentities($_POST['email']) : "";
    $pass = (isset($_POST['pass'])) ? md5(htmlentities($_POST['pass'])) : "";
    
    if(!empty($_POST['submit_validate'])) {
        $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE email = '$email' && password = '$pass'");
        $result = mysqli_fetch_array($query);

        if($result) {
            $_SESSION["email_cafe"] = $email;
            $_SESSION["level_cafe"] = $result['level'];
            header('location:../home');
        } else { ?>
            <script>
                alert('Email dan password yang Anda masukkan salah.')
                window.location="../login"
            </script>
<?php
        }
    }
?>
