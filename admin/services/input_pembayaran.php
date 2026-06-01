<?php
include "conn.php";

$pesanan_id = $_POST['pesanan_id'];

$pesanan = mysqli_fetch_assoc(mysqli_query(
    $conn,
    "SELECT * FROM tb_pesanan WHERE id='$pesanan_id'"
));

$total = $pesanan['total'];

$uang_diterima = $_POST['uang_diterima'];

$kembalian = $uang_diterima - $total;

$metode = $_POST['metode_bayar'];

$status = 0;

if($kembalian < 0){
    echo "<script>alert('Uang yang diterima kurang dari total tagihan.'); window.location.href='../detail?id=" . $pesanan_id . "';</script>";
} else {
    echo "<script>alert('Pembayaran berhasil. Kembalian: Rp " . number_format($kembalian, 0, ',', '.') . "')</script>";
    $status = 1;
}

mysqli_query($conn,"
    INSERT INTO tb_pembayaran
    (
        pesanan_id,
        waktu_bayar,
        metode_pembayaran,
        total_bayar,
        uang_diterima,
        kembalian,
        status_pembayaran
    )
    VALUES
    (
        '$pesanan_id',
        NOW(),
        '$metode',
        '$total',
        '$uang_diterima',
        '$kembalian',
        '$status'
    )
");

// if($status == 1){
//     mysqli_query($conn,"
//         UPDATE tb_pesanan
//         SET status='selesai'
//         WHERE id='$pesanan_id'
//     ");
// }

header("Location: ../detail?id=".$pesanan_id);