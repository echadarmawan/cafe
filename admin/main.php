<?php
    //session_start();
    if(empty($_SESSION['email_cafe'])) {
        header('location:login');
    }

    include "services/conn.php";
    $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE email = '$_SESSION[email_cafe]'");
    $result = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CafeKu - Aplikasi Pemesanan Makanan dan Minuman Cafe</title>
    <link rel="stylesheet" href="../vendor/bootstrap-5.3.8/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://unpkg.com">
    <script src="https://unpkg.com"></script>
</head>
<body>
    <!-- HEADER -->
    <?php include "header.php" ?>
    <!-- END HEADER -->
    <!-- SIDEBAR / CONTENT -->
     <div class="container-lg">
        <div class="row">
            <!-- SIDEBAR -->
            <?php include "sidebar.php"?>
            <!-- END SIDEBAR -->
            <!-- CONTENT -->
            <?php 
            include $page;
            ?>
            <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR/CONTENT -->
         <div class="bg-body-tertiary text-center text-lg-start mt-4">
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2026 Copyright:
                <a class="text-body" href="#">CafeKu</a>
            </div>
         </div>
     </div>
    <script src="../vendor/bootstrap-5.3.8/js/bootstrap.bundle.min.js"></script>
</body>
</html>