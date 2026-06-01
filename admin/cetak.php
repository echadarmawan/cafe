<?php
include "services/conn.php";
// Pastikan parameter 'id' ada di URL untuk menghindari error
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Keamanan: Validasi agar id harus berupa angka (jika id Anda integer)
    $id = intval($id); 

    // echo "ID yang diterima adalah: " . $id;
    
    $header = mysqli_fetch_assoc(mysqli_query($conn,"
        SELECT
            p.*,
            u.nama AS nama_pelayan
        FROM tb_pesanan p
        LEFT JOIN tb_user u ON u.id = p.pelayan_id
        WHERE p.id = '$id'
    "));

    $detail = mysqli_query($conn,"
        SELECT
            dp.*,
            m.nama AS nama_menu
        FROM tb_detail dp
        JOIN tb_menu m ON m.id = dp.menu_id
        WHERE dp.pesanan_id = '$id'
    ");

    $pembayaran = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT *
    FROM tb_pembayaran
    WHERE pesanan_id = '$id'
    "));

    // $result = [];
    // while ($record = mysqli_fetch_assoc($query)) {
    //     $result[] = $record;
    // }
} else {
    echo "ID tidak ditemukan!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nota Pesanan - <?=$header['kode_pesanan']?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Gaya khusus untuk mode cetak kertas/PDF */
        @media print {
            /* Sembunyikan tombol cetak saat diprint */
            .no-print {
                display: none !important;
            }
            /* Memastikan background warna tabel tetap muncul saat dicetak */
            body {
                background-color: #fff !important;
                color: #000 !important;
            }
            .table th {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        /* Gaya tambahan agar tampilan nota lebih rapi */
        .nota-header {
            border-bottom: 2px double #333;
            padding-bottom: 15px;
        }
    </style>
</head>
<body onload="window.print();"> <div class="container my-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <button class="btn btn-secondary btn-sm" onclick="window.close();">
            ✕ Tutup Halaman
        </button>
        <button class="btn btn-primary" onclick="window.print();">
            🖨️ Cetak Nota
        </button>
    </div>

    <div class="text-center nota-header mb-4">
        <h2>DAPUR BUNDA BAHAGIA</h2>
        <p class="mb-0">Alamat: Jln. Sulit No. 420 | Telp: 08123456789</p>
        <small class="text-muted">Nota Transaksi Penjualan</small>
    </div>

    <div class="row g-3">
        <div class="col-6 col-md-3">
            <span class="text-muted d-block small">Kode Pesanan</span>
            <strong><?=$header['kode_pesanan']?></strong>
        </div>
        <div class="col-6 col-md-3">
            <span class="text-muted d-block small">Waktu</span>
            <strong><?=$header['waktu']?></strong>
        </div>
        <div class="col-6 col-md-3">
            <span class="text-muted d-block small">Pelanggan</span>
            <strong><?=$header['nama_pelanggan']?></strong>
        </div>
        <div class="col-6 col-md-3">
            <span class="text-muted d-block small">Pelayan</span>
            <strong><?=$header['nama_pelayan']?></strong>
        </div>
    </div>
    <hr>

    <h5 class="mt-4 mb-2">Detail Pesanan</h5>
    <?php if (empty($detail)) { ?>
        <div class="alert alert-warning">Data detail pesanan tidak ada.</div>
    <?php } else { ?>
        <table class="table table-bordered table-striped table-sm">
            <thead class="table-light">
                <tr>
                    <th scope="col" style="width: 5%">No</th>
                    <th scope="col">Nama Menu</th>
                    <th scope="col" class="text-end" style="width: 20%">Harga</th>
                    <th scope="col" class="text-center" style="width: 10%">Qty</th>
                    <th scope="col" class="text-end" style="width: 25%">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($detail as $row) {
                ?>
                    <tr>
                        <th scope="row" class="text-center"><?php echo $no++ ?></th>
                        <td><?php echo $row['nama_menu'] ?></td>
                        <td class="text-end">Rp<?=number_format($row['harga'], 0, ',', '.')?></td>
                        <td class="text-center"><?php echo $row['kuantitas'] ?></td>
                        <td class="text-end">Rp<?=number_format($row['subtotal'], 0, ',', '.')?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Total</th>
                    <th class="text-end">
                        Rp<?=number_format($header['total'], 0, ',', '.')?>
                    </th>
                </tr>
            </tfoot>
        </table>
    <?php } ?>
    <h5 class="mt-4 mb-2">Detail Pembayaran</h5>
    <div class="row">
        <div class="col-md-6 ms-auto"> <table class="table table-sm table-borderless">
                <tbody>
                    <?php if($pembayaran){ ?>
                    <tr>
                        <th scope="row" class="text-muted fw-normal">Waktu Bayar</th>
                        <td class="text-end"><?=$pembayaran['waktu_bayar']?></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-muted fw-normal">Metode Pembayaran</th>
                        <td class="text-end"><?=$pembayaran['metode_pembayaran'] == 0 ? 'Tunai' : 'Non-Tunai'?></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-muted fw-normal">Total Bayar</th>
                        <td class="text-end fw-bold">Rp<?=number_format($pembayaran['total_bayar'], 0, ',', '.')?></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-muted fw-normal">Uang Diterima</th>
                        <td class="text-end">Rp<?=number_format($pembayaran['uang_diterima'], 0, ',', '.')?></td>
                    </tr>
                    <tr class="border-top">
                        <th scope="row">Kembalian</th>
                        <td class="text-end fw-bold text-success">Rp<?=number_format($pembayaran['kembalian'], 0, ',', '.')?></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-muted fw-normal">Status Pembayaran</th>
                        <td class="text-end">
                            <span class="badge <?=$pembayaran['status_pembayaran'] == 0 ? 'bg-danger' : 'bg-success'?>">
                                <?=$pembayaran['status_pembayaran'] == 0 ? 'Belum Dibayar' : 'Sudah Dibayar'?>
                            </span>
                        </td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                        <td colspan="2" class="text-center text-muted py-3">
                            Belum ada riwayat pembayaran.
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="text-center mt-5">
        <p class="small text-muted">~ Terima Kasih Atas Kunjungan Anda ~</p>
    </div>

</div>

</body>
</html>