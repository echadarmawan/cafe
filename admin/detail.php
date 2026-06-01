<?php
include "services/conn.php";
// Pastikan parameter 'id' ada di URL untuk menghindari error
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ambil dan amankan ID dari URL
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

<div class="col-lg-9 mt-2">
    <div class="card">
        <div class="card-header">
            Halaman Detail Pesanan
        </div>
        <div class="card-body">
            <!-- Tombol Bayar dan Cetak -->
            <div class="row">
                <div class="col d-flex justify-content-end">
                    <?php if($header['status_pesanan'] != 1 && $header['status_pesanan'] != 2){ ?>
                        <button
                            class="btn btn-success me-2"
                            data-bs-toggle="modal"
                            data-bs-target="#ModalBayar">
                            <i class="bi bi-wallet2"></i> Bayar
                        </button>
                    <?php } ?>
                    <a href="cetak.php?id=<?=$id?>"
                    target="_blank"
                    class="btn btn-secondary">
                        <i class="bi bi-printer"></i> Cetak
                    </a>
                </div>
            </div>
            <!-- Akhir Tombol Bayar dan Cetak -->
            <!-- Modal Bayar -->
            <div class="modal fade" id="ModalBayar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Bayar</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="services/input_pembayaran.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="pesanan_id" value="<?=$header['id']?>">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInput" placeholder="Total Tagihan" name="kode-pesanan" value="<?php echo $header['kode_pesanan']?>" readonly>
                                            <label for="floatingInput">Kode Pesanan</label>
                                            <div class="invalid-feedback">
                                                Pilih kode pesanan.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInput" placeholder="Total Tagihan" name="total-tagihan" value="<?php echo $header['total']?>" readonly>
                                            <label for="floatingInput">Total Tagihan</label>
                                            <div class="invalid-feedback">
                                                Pilih total tagihan.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" aria-label="Default select example" name="metode_bayar" required>
                                                <option selected hidden value="">Pilih Metode Pembayaran</option>
                                                <option value="0">Tunai</option>
                                                <option value="1">Non-Tunai</option>
                                            </select>
                                            <label for="floatingInput">Metode Pembayaran</label>
                                            <div class="invalid-feedback">
                                                Pilih metode pembayaran.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-floating mb-3">
                                                <input type="number" class="form-control" id="floatingInput" placeholder="Uang Diterima" name="uang_diterima" required>
                                                <label for="floatingInput">Uang Diterima</label>
                                                <div class="invalid-feedback">
                                                    Masukkan uang yang diterima.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="input_payment_validate" value="12345">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Akhir Modal Bayar -->
            <!-- Informasi Pesanan -->
            <div class="row mt-3">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input class="form-control"
                            value="<?=$header['kode_pesanan']?>"
                            readonly>
                        <label>Kode Pesanan</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input class="form-control"
                            value="<?=$header['waktu']?>"
                            readonly>
                        <label>Waktu</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input class="form-control"
                            value="<?=$header['nama_pelanggan']?>"
                            readonly>
                        <label>Pelanggan</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input class="form-control"
                            value="<?=$header['nama_pelayan']?>"
                            readonly>
                        <label>Pelayan</label>
                    </div>
                </div>
            </div>
            <!-- Akhir Informasi Pesanan -->
            <!-- Status Pesanan -->
            <form action="services/edit_status_pesanan.php" method="POST">
                <input type="hidden"
                    name="pesanan_id"
                    value="<?=$header['id']?>">
                <div class="row mb-3">
                    <div class="col-md-4 mb-2">
                        <select class="form-select" name="status">
                            <option value="0"<?php echo ($header['status_pesanan'] == 0) ? ' selected' : ''; ?>>Diproses</option>
                            <option value="1"<?php echo ($header['status_pesanan'] == 1) ? ' selected' : ''; ?>>Selesai</option>
                            <option value="2"<?php echo ($header['status_pesanan'] == 2) ? ' selected' : ''; ?>>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </div>
            </form>
            <!-- Akhir Status Pesanan -->
            <!-- Detail Pesanan -->
            <h5 class="mt-4">Detail Pesanan</h5>
            <?php
            if (empty($detail)) {
                echo "Data detail pesanan tidak ada.";
            } else {
            ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Menu</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($detail as $row) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $no++ ?></th>
                                    <td><?php echo $row['nama_menu'] ?></td>
                                    <td>Rp<?=number_format($row['harga'], 0, ',', '.')?></td>
                                    <td><?php echo $row['kuantitas'] ?></td>
                                    <td>Rp<?=number_format($row['subtotal'], 0, ',', '.')?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4">Total</th>
                                <th>
                                    Rp<?=number_format($header['total'], 0, ',', '.')?>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php
            }
            ?>
            <!-- Akhir Detail Pesanan -->
             <!-- Detail Pembayaran -->
            <h5 class="mt-4">Detail Pembayaran</h5>

            <div class="table-responsive">
            <table class="table table-hover">
                <tbody>
                    <?php if($pembayaran){ ?>
                    <tr>
                        <th>Waktu Bayar</th>
                        <td><?=$pembayaran['waktu_bayar']?></td>
                    </tr>
                    <tr>
                        <th>Metode Pembayaran</th>
                        <td><?=$pembayaran['metode_pembayaran']==0 ? 'Tunai' : 'Non-Tunai'?></td>
                    </tr>
                    <tr>
                        <th>Total Bayar</th>
                        <td>Rp<?=number_format($pembayaran['total_bayar'], 0, ',', '.')?></td>
                    </tr>
                    <tr>
                        <th>Uang Diterima</th>
                        <td>Rp<?=number_format($pembayaran['uang_diterima'], 0, ',', '.')?></td>
                    </tr>
                    <tr>
                        <th>Kembalian</th>
                        <td>Rp<?=number_format($pembayaran['kembalian'], 0, ',', '.')?></td>
                    </tr>
                    <tr>
                        <th>Status Pembayaran</th>
                        <td><?=$pembayaran['status_pembayaran']==0 ? 'Belum Dibayar' : 'Sudah Dibayar'?></td>
                    </tr>
                    <?php }else{ ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada pembayaran
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
            <!-- Akhir Detail Pembayaran -->
        </div>
    </div>
</div>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>