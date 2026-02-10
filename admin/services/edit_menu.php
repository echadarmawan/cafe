<?php
include "conn.php";

$id = (isset($_POST['id'])) ? $_POST['id'] : "";
$nama = isset($_POST['nama']) ? trim($_POST['nama']) : "";
$keterangan = isset($_POST['keterangan']) ? trim($_POST['keterangan']) : "";
$jenis_kategori = isset($_POST['jenis_kategori']) ? $_POST['jenis_kategori'] : "";
$harga = isset($_POST['harga']) ? $_POST['harga'] : "";
$stok = isset($_POST['stok']) ? $_POST['stok'] : "";

// Data foto lama
$old_file = isset($_POST['foto_lama']) ? $_POST['foto_lama'] : "";

$target_dir = "../assets/images/";
// Default tetap foto lama
$new_file_name = $old_file;

// 🔎 Cek nama menu duplikat (kecuali data yang sedang diedit)
$cek = mysqli_prepare($conn, "SELECT id FROM tb_menu WHERE nama = ? AND id != ?");
mysqli_stmt_bind_param($cek, "si", $nama, $id);
mysqli_stmt_execute($cek);
mysqli_stmt_store_result($cek);

if (mysqli_stmt_num_rows($cek) > 0) {
    echo "<script>
        alert('Nama menu sudah digunakan, silakan gunakan nama lain.');
        window.location='../menu';
    </script>";
    exit;
}

// Cek jika ada foto baru yang diupload
if (!empty($_FILES['foto_baru']['name'])) {
    // Cek apakah gambar
    $check = getimagesize($_FILES["foto_baru"]["tmp_name"]);
    if ($check === false) {
        echo "<script>
        alert('File yang diupload bukan gambar.');
        window.location='../menu';
        </script>";
        exit;
    }

    // Cek ukuran
    if ($_FILES["foto_baru"]["size"] > 2000000) {
        echo "<script>
        alert('Ukuran gambar terlalu besar. Maksimal 2MB.');
        window.location='../menu';
        </script>";
        exit;
    }

    // Dapatkan ekstensi file
    $imageFileType = strtolower(pathinfo($_FILES["foto_baru"]["name"], PATHINFO_EXTENSION));
    $imageType = $imageFileType;

    // Cek ekstensi
    if (!in_array($imageType, ["jpg", "jpeg", "png", "gif"])) {
        echo "<script>
        alert('Hanya file JPG, JPEG, PNG & GIF yang diizinkan.');
        window.location='../menu';
        </script>";
        exit;
    }

    // Rename file sesuai nama menu
    $nama_file_sanitized = strtolower(preg_replace('/[^a-z0-9]/i', '_', $nama));
    $new_file_name = $nama_file_sanitized . "." . $imageType;
    $target_file = $target_dir . $new_file_name;

    // 🔒 Proteksi bentrok nama file
    if (file_exists($target_file)) {
        $unique = time() . "_" . substr(md5(rand()), 0, 5);
        $new_file_name = $nama_file_sanitized . "_" . $unique . "." . $imageType;
        $target_file = $target_dir . $new_file_name;
    }

    // Hapus foto lama jika berbeda
    if (!empty($old_file) && file_exists($target_dir . $old_file) && $old_file !== $new_file_name) {
        unlink($target_dir . $old_file);
    }

    // Upload file baru
    if (!move_uploaded_file($_FILES["foto_baru"]["tmp_name"], $target_file)) {
        echo "<script>
        alert('Upload gambar gagal.');
        window.location='../menu';
        </script>";
        exit;
    }
}

// Update data menu
$query = mysqli_prepare($conn, "UPDATE tb_menu SET foto=?, nama=?, keterangan=?, jenis_id=?, harga=?, stok=? WHERE id=?");
mysqli_stmt_bind_param($query, "sssiiii", $new_file_name, $nama, $keterangan, $jenis_kategori, $harga, $stok, $id);
$execute = mysqli_stmt_execute($query);

if (!$execute) {
    echo "<script>alert('Gagal mengupdate data menu.')</script>";
} else {
    echo "<script>
    alert('Berhasil mengupdate data menu.');
    window.location = '../menu';
    </script>";
}
