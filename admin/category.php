<?php
include "services/conn.php";
$query = mysqli_query($conn, "SELECT tb_jenis.*, k.nama_kategori FROM tb_jenis
JOIN tb_kategori AS k ON tb_jenis.kategori_id = k.id WHERE tb_jenis.status = 1 ORDER BY tb_jenis.kategori_id ASC");
$result = [];
while ($record = mysqli_fetch_assoc($query)) {
    $result[] = $record;
}
?>

<div class="col-lg-9 mt-2">
    <div class="card">
        <div class="card-header">
            Jenis Kategori Menu
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahJenis">Tambah Jenis Kategori</button>
                </div>
            </div>
            <!-- Modal Tambah Jenis Kategori Baru -->
            <div class="modal fade" id="ModalTambahJenis" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Jenis Baru</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="services/input_category.php" method="POST">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" aria-label="Default select example" name="kategori" required>
                                                <option selected hidden value="">Pilih Kategori Menu</option>
                                                <option value="1">Makanan Pembuka</option>
                                                <option value="2">Makanan Utama</option>
                                                <option value="3">Makanan Penutup</option>
                                                <option value="4">Minuman</option>
                                            </select>
                                            <label for="floatingInput">Kategori Menu</label>
                                            <div class="invalid-feedback">
                                                Masukkan kategori menu.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInput" placeholder="Type Category" name="jenis" required>
                                            <label for="floatingInput">Nama Jenis Kategori</label>
                                            <div class="invalid-feedback">
                                                Masukkan nama jenis kategori.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="input_category_validate" value="12345">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Akhir Modal Tambah Jenis Kategori Baru -->
            <?php
            foreach ($result as $row) {
            ?>
                <!-- Modal Edit Jenis Kategori -->
                <div class="modal fade" id="ModalEditJenis<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Jenis Kategori</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="needs-validation" novalidate action="services\edit_category.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-floating mb-3">
                                                <select class="form-select" aria-label="Default select example" name="kategori" required>
                                                    <option selected hidden value="">Pilih Kategori Menu</option>
                                                    <option value="1" <?php echo ($row['kategori_id'] == 1) ? ' selected' : ''; ?>>Makanan Pembuka</option>
                                                    <option value="2" <?php echo ($row['kategori_id'] == 2) ? ' selected' : ''; ?>>Makanan Utama</option>
                                                    <option value="3" <?php echo ($row['kategori_id'] == 3) ? ' selected' : ''; ?>>Makanan Penutup</option>
                                                    <option value="4" <?php echo ($row['kategori_id'] == 4) ? ' selected' : ''; ?>>Minuman</option>
                                                </select>
                                                <label for="floatingInput">Kategori Menu</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="floatingInput" placeholder="Type Category" name="jenis" value="<?= $row['nama_jenis']; ?>" required>
                                                <label for="floatingInput">Nama Jenis Kategori</label>
                                                <div class="invalid-feedback">
                                                    Masukkan nama jenis kategori.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-warning" name="input_category_validate" value="12345">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Akhir Modal Edit Jenis Kategori -->
                <!-- Modal Delete Jenis Kategori -->
                <div class="modal fade" id="ModalDeleteJenis<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Jenis Kategori</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="needs-validation" novalidate action="services\delete_category.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <div class="col-lg-12">
                                        Apa Anda yakin ingin menghapus jenis <strong><?php echo $row['nama_jenis'] ?> dari kategori <em><?php echo $row['nama_kategori'] ?></em></strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger" name="input_category_validate" value="12345">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Akhir Modal Delete Jenis Kategori -->
            <?php
            }
            if (empty($result)) {
                echo "Data jenis kategori tidak ada.";
            } else {
            ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Jenis Kategori</th>
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
                                    <td><?php echo $row['nama_kategori'] ?></td>
                                    <td><?php echo $row['nama_jenis'] ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#ModalEditJenis<?php echo $row['id'] ?>"><i class="bi bi-pencil-square"></i></button>
                                            <button class="btn btn-danger btn-sm me-1" data-bs-toggle="modal" data-bs-target="#ModalDeleteJenis<?php echo $row['id'] ?>"><i class="bi bi-trash"></i></button>
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