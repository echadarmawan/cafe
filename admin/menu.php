<?php
include "services/conn.php";
$query = mysqli_query($conn, "SELECT tb_menu.*, j.nama_jenis, j.kategori_id, k.nama_kategori FROM tb_menu
JOIN tb_jenis AS j ON tb_menu.jenis_id = j.id
JOIN tb_kategori AS k ON j.kategori_id = k.id
WHERE j.status = 1 ORDER BY tb_menu.id ASC");
$result = [];
while ($record = mysqli_fetch_assoc($query)) {
    $result[] = $record;
}

$query_type = mysqli_query($conn, "SELECT tb_jenis.*, tb_kategori.nama_kategori FROM tb_jenis JOIN tb_kategori ON tb_jenis.kategori_id = tb_kategori.id ORDER BY tb_kategori.id ASC");

?>
<div class="col-lg-9 mt-2">
    <div class="card">
        <div class="card-header">
            Halaman Menu
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahMenu">Tambah Menu</button>
                </div>
            </div>
            <!-- Modal Tambah Menu Baru -->
            <div class="modal fade" id="ModalTambahMenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Menu Baru</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="services/input_menu.php" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input-group mb-3">
                                            <input type="file" class="form-control py-3" id="UploadFoto" name="foto" required>
                                            <label class="input-group-text rounded-end" for="UploadFoto">Max Menu Photo: 2MB</label>
                                            <div class="invalid-feedback">
                                                Masukkan foto.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInput" placeholder="Menu Name" name="nama" required>
                                            <label for="floatingInput">Menu Name</label>
                                            <div class="invalid-feedback">
                                                Masukkan nama menu.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="Tulis keterangan menu." style="height:100px" id="floatingTextarea" name="keterangan"></textarea>
                                    <label for="floatingTextarea">Description</label>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" aria-label="Default select example" name="jenis_kategori" required>
                                                <option selected hidden value="">Choose a Menu Category - Type</option>
                                                <?php
                                                foreach ($query_type as $row_type) {
                                                    echo "<option value=" . $row_type['id'] . ">" . $row_type['nama_kategori'] . " - " . $row_type['nama_jenis'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Masukkan kategori menu dan jenisnya.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-3">
                                            <input type="number" min="1000" class="form-control" id="floatingInput" placeholder="Masukkan harga" name="harga" required>
                                            <label for="floatingInput">Harga</label>
                                            <div class="invalid-feedback">
                                                Masukkan harga menu.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-3">
                                            <input type="number" min="0" class="form-control" id="floatingInput" placeholder="Masukkan stok" name="stok" required>
                                            <label for="floatingInput">Stok</label>
                                            <div class="invalid-feedback">
                                                Masukkan stok menu.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="input_menu_validate" value="12345">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Akhir Modal Tambah Menu Baru -->
            <?php
            foreach ($result as $row) {
            ?>
                <!-- Modal View -->
                <div class="modal fade" id="ModalView<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Data Menu</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="needs-validation" novalidate action="" method="POST" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="input-group mb-3">
                                                <img src="assets\images\<?php echo $row['foto'] ?>" class="img-thumbnail" alt="...">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-floating mb-3">
                                                <input disabled type="text" class="form-control" id="floatingInput" placeholder="Menu Name" name="nama" value="<?php echo $row['nama']; ?>">
                                                <label for="floatingInput">Menu Name</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <textarea disabled class="form-control" placeholder="Tulis keterangan menu." style="height:100px" id="floatingTextarea" name="keterangan"><?php echo $row['keterangan']; ?></textarea>
                                        <label for="floatingTextarea">Description</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-floating mb-3">
                                                <input disabled type="text" class="form-control" id="floatingInput" placeholder="Kategori Menu dan Jenisnya" name="jenis_kategori" value="<?php echo $row['nama_kategori'] . " - " . $row['nama_jenis']; ?>">
                                                <label for="floatingInput">Menu Category - Type</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-floating mb-3">
                                                <input disabled type="number" min="1000" class="form-control" id="floatingInput" placeholder="Masukkan harga" name="harga" value="<?php echo $row['harga']; ?>">
                                                <label for="floatingInput">Harga</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-floating mb-3">
                                                <input disabled type="number" min="0" class="form-control" id="floatingInput" placeholder="Masukkan stok" name="stok" value="<?php echo $row['stok']; ?>">
                                                <label for="floatingInput">Stok</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Akhir Modal View -->
                <!-- Modal Edit Menu -->
                <div class="modal fade" id="ModalEditMenu<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Menu</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="needs-validation" novalidate action="services/edit_menu.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <!-- Tampilkan foto lama -->
                                            <div class="mb-3">
                                                <img src="../assets/images/<?php echo $row['foto'] ?>" alt="Foto Menu" class="img-thumbnail" style="max-width: 200px;">
                                                <small class="text-muted">Kosongkan jika tidak ingin mengganti foto</small>
                                            </div>
                                            <div class="input-group mb-3">
                                                <input type="hidden" name="foto_lama" value="<?php echo $row['foto'] ?>">
                                                <input type="file" class="form-control py-3" id="UpdateFoto<?php echo $row['id']; ?>" name="foto_baru">
                                                <label class="input-group-text rounded-end" for="UpdateFoto<?php echo $row['id']; ?>">Max Menu Photo: 2MB</label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="floatingInput" placeholder="Menu Name" name="nama" value="<?php echo $row['nama'] ?>" required>
                                                <label for="floatingInput">Menu Name</label>
                                                <div class="invalid-feedback">
                                                    Masukkan nama menu.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" placeholder="Tulis keterangan menu." style="height:100px" id="floatingTextarea" name="keterangan"><?php echo $row['keterangan'] ?></textarea>
                                        <label for="floatingTextarea">Description</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-floating mb-3">
                                                <select class="form-select" aria-label="Default select example" name="jenis_kategori" required>
                                                    <option selected hidden value="">Choose a Menu Category - Type</option>
                                                    <?php
                                                    foreach ($query_type as $row_type) {
                                                        echo "<option value=" . $row_type['id'] . "";
                                                        if ($row_type['id'] == $row['jenis_id']) {
                                                            echo " selected";
                                                        }
                                                        echo ">" . $row_type['nama_kategori'] . " - " . $row_type['nama_jenis'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <label for="floatingInput">Menu Category - Type</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-floating mb-3">
                                                <input type="number" min="1000" class="form-control" id="floatingInput" placeholder="Masukkan harga" name="harga" value="<?php echo $row['harga'] ?>" required>
                                                <label for="floatingInput">Harga</label>
                                                <div class="invalid-feedback">
                                                    Masukkan harga menu.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-floating mb-3">
                                                <input type="number" min="0" class="form-control" id="floatingInput" placeholder="Masukkan stok" name="stok" value="<?php echo $row['stok'] ?>" required>
                                                <label for="floatingInput">Stok</label>
                                                <div class="invalid-feedback">
                                                    Masukkan stok menu.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="input_menu_validate" value="12345">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Akhir Modal Edit Menu -->
                <!-- Modal Delete Menu -->
                <div class="modal fade" id="ModalDeleteMenu<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Menu</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="needs-validation" novalidate action="services\delete_menu.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <input type="hidden" name="foto_lama" value="<?php echo $row['foto'] ?>">
                                    <div class="col-lg-12">
                                        Apa Anda yakin ingin menghapus menu <strong><?php echo $row['nama'] ?></strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger" name="input_menu_validate" value="12345">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Akhir Modal Delete Menu -->
            <?php
            }
            if (empty($result)) {
                echo "Data menu tidak ada.";
            } else {
            ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Foto</th>
                                <th scope="col">Nama Menu</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Jenis Kategori</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Stok</th>
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
                                    <td><img src="assets\images\<?php echo $row['foto'] ?>" class="img-thumbnail" alt="<?php echo $row['keterangan'] ?>"></td>
                                    <td><?php echo $row['nama'] ?></td>
                                    <td><?php echo $row['nama_kategori'] ?></td>
                                    <td><?php echo $row['nama_jenis'] ?></td>
                                    <td>Rp<?php echo number_format($row['harga'], 0, ',', '.') ?></td>
                                    <td><?php echo $row['stok'] ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-info btn-sm me-1" data-bs-toggle="modal" data-bs-target="#ModalView<?php echo $row['id']; ?>"><i class="bi bi-eye-fill"></i></button>
                                            <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#ModalEditMenu<?php echo $row['id'] ?>"><i class="bi bi-pencil-square"></i></button>
                                            <button class="btn btn-danger btn-sm me-1" data-bs-toggle="modal" data-bs-target="#ModalDeleteMenu<?php echo $row['id'] ?>"><i class="bi bi-trash"></i></button>
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