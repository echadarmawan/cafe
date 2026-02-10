<?php
include "conn.php";

$nama = isset($_POST['nama']) ? trim($_POST['nama']) : "";
$keterangan = isset($_POST['keterangan']) ? trim($_POST['keterangan']) : "";
$jenis_kategori = isset($_POST['jenis_kategori']) ? $_POST['jenis_kategori'] : "";
$harga = isset($_POST['harga']) ? $_POST['harga'] : "";
$stok = isset($_POST['stok']) ? $_POST['stok'] : "";

$target_dir = "../assets/images/";
// Sanitasi nama menu → jadi nama file
$nama_file = strtolower(preg_replace('/[^a-z0-9]/i', '_', $nama));

// Ambil ekstensi file
$imageType = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));

// Gabungkan nama menu + ekstensi
$new_file_name = $nama_file . "." . $imageType;
$target_file = $target_dir . $new_file_name;

if (!empty($_POST['input_menu_validate'])) {
    // Cek apakah gambar
    $check = getimagesize($_FILES["foto"]["tmp_name"]);
    if ($check === false) {
        echo "<script>
        alert('File yang diupload bukan gambar.');
        window.location='../menu';
        </script>";
        exit;
    }

    // Cek ukuran
    if ($_FILES["foto"]["size"] > 2000000) {
        echo "<script>
        alert('Ukuran gambar terlalu besar. Maksimal 2MB.');
        window.location='../menu';
        </script>";
        exit;
    }

    // Cek ekstensi
    if (!in_array($imageType, ["jpg", "jpeg", "png", "gif"])) {
        echo "<script>
        alert('Hanya file JPG, JPEG, PNG & GIF yang diizinkan.');
        window.location='../menu';
        </script>";
        exit;
    }

    // Upload file
    if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
        echo "<script>
        alert('Gagal mengupload gambar.');
        window.location='../menu';
        </script>";
        exit;
    }

    // Cek apakah nama menu sudah ada
    $select_query = mysqli_prepare($conn, "SELECT nama FROM tb_menu WHERE nama = ?");
    mysqli_stmt_bind_param($select_query, "s", $nama);
    mysqli_stmt_execute($select_query);
    mysqli_stmt_store_result($select_query);

    if (mysqli_stmt_num_rows($select_query) > 0) {
        $message = "<script>
            alert('Nama menu sudah terdaftar, silahkan gunakan nama lain.');
            window.location = '../menu';
            </script>";
    } else {
        // insert data menu
        $query = mysqli_prepare($conn, "INSERT INTO tb_menu (foto, nama, keterangan, jenis_id, harga, stok) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($query, "sssiii", $new_file_name, $nama, $keterangan, $jenis_kategori, $harga, $stok);
        $execute = mysqli_stmt_execute($query);

        if (!$execute) {
            $message = "<script>alert('Gagal menambahkan data menu.')</script>";
        } else {
            $message = "<script>
                alert('Berhasil menambahkan data menu.');
                window.location = '../menu';
                </script>";
        }
    }
}

echo $message;
?>