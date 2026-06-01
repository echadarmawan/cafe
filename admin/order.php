<?php
include "services/conn.php";

// Mengatur zona waktu ke Waktu Indonesia Barat (WIB)
date_default_timezone_set("Asia/Jakarta"); 

$query = mysqli_query($conn, "
SELECT
    p.*,
    u.nama,
    GROUP_CONCAT(m.nama SEPARATOR ', ') AS nama_menu
FROM tb_pesanan AS p
LEFT JOIN tb_user AS u ON p.pelayan_id = u.id
LEFT JOIN tb_detail AS dp ON p.id = dp.pesanan_id
LEFT JOIN tb_menu AS m ON dp.menu_id = m.id
GROUP BY p.id
ORDER BY p.id DESC
");

$result = [];
while ($record = mysqli_fetch_assoc($query)) {
    $result[] = $record;
}

$menu_query = mysqli_query($conn, "SELECT * FROM tb_menu WHERE stok > 0 ORDER BY nama");
$menu_data = [];

while($menu = mysqli_fetch_assoc($menu_query)){
    $menu_data[] = $menu;
}
?>


<div class="col-lg-9 mt-2">
    <div class="card">
        <div class="card-header">
            Halaman Pesanan
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahPesanan">Tambah Pesanan</button>
                </div>
            </div>
            <!-- Modal Tambah Pesanan Baru -->
            <div class="modal fade" id="ModalTambahPesanan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Pesanan Baru</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="services\input_order.php" method="POST">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInput" placeholder="Kode Pesanan" name="kode_pesanan" value="<?php echo "ORD" . date("YmdHis") . rand(100, 999) ?>" readonly>
                                            <label for="floatingInput">Kode Pesanan</label>
                                            <div class="invalid-feedback">
                                                Masukkan kode pesanan.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInput" name="waktu" placeholder="yyyy-MM-dd HH:mm:ss" value="<?php echo date("Y-m-d H:i:s") ?>" readonly>
                                            <label for="floatingInput">Waktu</label>
                                            <div class="invalid-feedback">
                                                Masukkan waktu.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInput" name="pelayan" placeholder="Pelayan" value="<?php echo $_SESSION['pelayan'] ?>" readonly>
                                            <label for="floatingInput">Pelayan</label>
                                            <div class="invalid-feedback">
                                                Masukkan pelayan.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                           <input type="text" class="form-control" id="floatingInput" name="pelanggan" placeholder="Pelanggan" required>
                                            <label for="floatingInput">Pelanggan</label>
                                            <div class="invalid-feedback">
                                                Masukkan pelanggan.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                           <input type="number" class="form-control" id="floatingInput" name="meja" placeholder="Meja" required>
                                            <label for="floatingInput">Meja</label>
                                            <div class="invalid-feedback">
                                                Masukkan meja.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="pelayan_id" value="<?php echo $_SESSION['id_user'] ?>">
                                <!-- TAMBAH PESANAN -->
                                <div class="row mb-3">
                                    <div class="col">
                                        <h5>Detail Pesanan</h5>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-5 mb-2">
                                        <select id="menuSelect" class="form-select">
                                            <option value="">Pilih Menu</option>
                                            <?php foreach($menu_data as $menu){ ?>
                                                <option
                                                    value="<?= $menu['id'] ?>"
                                                    data-harga="<?= $menu['harga'] ?>">
                                                    <?= $menu['nama'] ?> -
                                                    Rp <?= number_format($menu['harga']) ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-3 mb-2">
                                        <input type="number"
                                            id="qty"
                                            min="1"
                                            value="1"
                                            class="form-control">
                                    </div>

                                    <div class="col-lg-2 mb-2">
                                         <button type="button"
                                                class="btn btn-success w-100"
                                                onclick="tambahItem()">
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                                 <!-- END TAMBAH PESANAN -->
                                <!-- DETAIL PESANAN -->
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle">
                                        <thead>
                                            <tr>
                                                <th>Nama Menu</th>
                                                <th>Harga</th>
                                                <th width="120">Qty</th>
                                                <th>Subtotal</th>
                                                <th width="100">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detailBody">

                                        </tbody>
                                    </table>
                                </div>
                                 <!-- END DETAIL PESANAN -->
                                <div class="row">
                                    <div class="col-md-12 text-end">
                                        <h5>
                                            Total Pesanan :
                                            Rp <span id="grandTotal">0</span>
                                        </h5>

                                        <input type="hidden"
                                            name="total_pesanan"
                                            id="total_pesanan">

                                        <div id="detailInputs"></div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="input_order_validate" value="12345">Save order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Akhir Modal Tambah Pesanan Baru -->
            <?php
            if (empty($result)) {
                echo "Data pesanan tidak ada.";
            } else {
            ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Kode Order</th>
                                <th scope="col">Waktu</th>
                                <th scope="col">Pelanggan</th>
                                <th scope="col">Meja</th>
                                <th scope="col">Total Harga</th>
                                <th scope="col">Pelayan</th>
                                <th scope="col">Status Pesanan</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($result as $row) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $no++ ?></th>
                                    <td><?php echo $row['kode_pesanan'] ?></td>
                                    <td><?php echo $row['waktu'] ?></td>
                                    <td><?php echo $row['nama_pelanggan'] ?></td>
                                    <td><?php echo $row['meja'] ?></td>
                                    <td>Rp<?=number_format($row['total'], 0, ',', '.')?></td>
                                    <td><?php echo $row['nama'] ?></td>
                                    <td>
                                        <?php
                                        if ($row['status_pesanan'] == 0) {
                                            echo '<span class="badge bg-secondary">Diproses</span>';
                                        } else if ($row['status_pesanan'] == 1) {
                                            echo '<span class="badge bg-success">Selesai</span>';
                                        } else {
                                            echo '<span class="badge bg-danger">Dibatalkan</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-warning btn-sm me-1" onclick="location.href='detail?id=<?php echo $row['id'] ?>'"><i class="bi bi-pencil-square"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php
            }
            ?>
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