<?php
include "services/conn.php";
$query = mysqli_query($conn, "SELECT * FROM tb_user ORDER BY id ASC");
$result = [];
while ($record = mysqli_fetch_array($query)) {
    $result[] = $record;
}
?>
<div class="col-lg-9 mt-2">
    <div class="card">
        <div class="card-header">
            Halaman User
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalTambahUser">Tambah User</button>
                </div>
            </div>
            <!-- Modal Tambah User Baru -->
            <div class="modal fade" id="ModalTambahUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah User Baru</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="services\input_user.php" method="POST">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInput" placeholder="Your Name" name="nama" required>
                                            <label for="floatingInput">Name</label>
                                            <div class="invalid-feedback">
                                                Masukkan nama.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" required>
                                            <label for="floatingInput">Email address</label>
                                            <div class="invalid-feedback">
                                                Masukkan email.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" aria-label="Default select example" name="level" required>
                                                <option selected hidden value="">Pilih Level User</option>
                                                <option value="1">Admin</option>
                                                <option value="2">Kasir</option>
                                                <option value="3">Pelayan</option>
                                                <option value="4">Dapur</option>
                                            </select>
                                            <label for="floatingInput">Level User</label>
                                            <div class="invalid-feedback">
                                                Masukkan level user.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-floating mb-3">
                                            <input type="tel" pattern="0[0-9]{9,12}" class="form-control" id="floatingInput" placeholder="08xxxxxxxxxx" name="nohp" required>
                                            <label for="floatingInput">Nomor Telepon</label>
                                            <div class="invalid-feedback">
                                                Masukkan nomor telepon.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="Tulis alamat lengkap." style="height:100px" id="floatingTextarea" name="alamat"></textarea>
                                    <label for="floatingTextarea">Alamat</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" readonly value="12345" name="pass">
                                    <label for="floatingPassword">Password</label>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="input_user_validate" value="12345">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Akhir Modal Tambah User Baru -->
            <?php
            foreach ($result as $row) {
            ?>
            <!-- Modal View -->
            <div class="modal fade" id="ModalView<?php echo $row['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Data User</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input disabled type="text" class="form-control" id="floatingInput" placeholder="Your Name" name="nama" value="<?php echo $row['nama']?>">
                                            <label for="floatingInput">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input disabled type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" value="<?php echo $row['email']?>">
                                            <label for="floatingInput">Email address</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-3">
                                            <input disabled type="type" class="form-control" id="floatingInput" placeholder="" name="nohp" value="<?php 
                                                if($row['level'] == 1) {
                                                    echo "Admin";
                                                } else if($row['level'] == 2) {
                                                    echo "Kasir";
                                                } else if($row['level'] == 3) {
                                                    echo "Pelayan";
                                                } else {
                                                    echo "Dapur";
                                                }?>">
                                            <label for="floatingInput">Level User</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-floating mb-3">
                                            <input disabled type="tel" pattern="0[0-9]{9,12}" class="form-control" id="floatingInput" placeholder="08xxxxxxxxxx" name="nohp" value="<?php echo $row['nohp']?>">
                                            <label for="floatingInput">Nomor Telepon</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="Tulis alamat lengkap." style="height:100px" id="floatingTextarea" name="alamat" disabled><?php echo $row['alamat']?></textarea>
                                    <label for="floatingTextarea">Alamat</label>
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
            <!-- Modal Edit User -->
            <div class="modal fade" id="ModalEditUser<?php echo $row['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="services\edit_user.php" method="POST">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="floatingInput" placeholder="Your Name" name="nama" value="<?php echo $row['nama']?>" required>
                                            <label for="floatingInput">Name</label>
                                            <div class="invalid-feedback">
                                                Masukkan nama.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-floating mb-3">
                                            <input <?php echo ($row['email'] == $_SESSION['email_cafe']) ? 'readonly' : ''; ?> type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" value="<?php echo $row['email']?>" required>
                                            <label for="floatingInput">Email address</label>
                                            <div class="invalid-feedback">
                                                Masukkan email.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" aria-label="Default select example" name="level" required>
                                                <option selected hidden value="">Pilih Level User</option>
                                                <option value="1"<?php echo ($row['level'] == 1) ? ' selected' : ''; ?>>Admin</option>
                                                <option value="2"<?php echo ($row['level'] == 2) ? ' selected' : ''; ?>>Kasir</option>
                                                <option value="3"<?php echo ($row['level'] == 3) ? ' selected' : ''; ?>>Pelayan</option>
                                                <option value="4"<?php echo ($row['level'] == 4) ? ' selected' : ''; ?>>Dapur</option>
                                            </select>
                                            <label for="floatingInput">Level User</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-floating mb-3">
                                            <input type="tel" pattern="0[0-9]{9,12}" class="form-control" id="floatingInput" placeholder="08xxxxxxxxxx" name="nohp" value="<?php echo $row['nohp']?>" required>
                                            <label for="floatingInput">Nomor Telepon</label>
                                            <div class="invalid-feedback">
                                                Masukkan nomor telepon.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="Tulis alamat lengkap." style="height:100px" id="floatingTextarea" name="alamat" ><?php echo $row['alamat']?></textarea>
                                    <label for="floatingTextarea">Alamat</label>
                                    <div class="invalid-feedback">
                                        Masukkan alamat.
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-warning" name="input_user_validate" value="12345">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Akhir Modal Edit User -->
            <!-- Modal Delete User -->
            <div class="modal fade" id="ModalDeleteUser<?php echo $row['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete User</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="services\delete_user.php" method="POST">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <div class="col-lg-12">
                                    <?php if ($row['email'] == $_SESSION['email_cafe']) { ?>
                                        <div class="alert alert-danger" role="alert">
                                            Anda tidak dapat menghapus user <strong><?php echo $row['nama']?></strong> karena sedang digunakan untuk login.
                                        </div>
                                    <?php } else { ?>
                                        Apa Anda yakin ingin menghapus user <strong><?php echo $row['nama']?></strong>?
                                    <?php } ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger" name="input_user_validate" value="12345" <?php if ($row['email'] == $_SESSION['email_cafe']) { echo "disabled"; } ?>>Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Akhir Modal Delete User -->
            <!-- Modal Reset Password -->
            <div class="modal fade" id="ModalResetPass<?php echo $row['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-fullscreen-md-down">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Reset Password</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate action="services\reset_password.php" method="POST">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <div class="col-lg-12">
                                    <?php if ($row['email'] == $_SESSION['email_cafe']) { ?>
                                        <div class="alert alert-danger" role="alert">
                                            Anda tidak dapat mereset password user <strong><?php echo $row['nama']?></strong> karena sedang digunakan untuk login.
                                        </div>
                                    <?php } else { ?>
                                        Apakah Anda yakin ingin mereset password user <strong><?php echo $row['nama']?></strong> menjadi <strong>12345</strong>?
                                    <?php } ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success" name="input_user_validate" value="12345" <?php if ($row['email'] == $_SESSION['email_cafe']) { echo "disabled"; } ?>>Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Akhir Modal Reset Password -->
            <?php
            }
            if (empty($result)) {
                echo "Data user tidak ada.";
            } else {
            ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">Level</th>
                                <th scope="col">No HP</th>
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
                                    <td><?php echo $row['nama'] ?></td>
                                    <td><?php echo $row['email'] ?></td>
                                    <td><?php 
                                                if($row['level'] == 1) {
                                                    echo "Admin";
                                                } else if($row['level'] == 2) {
                                                    echo "Kasir";
                                                } else if($row['level'] == 3) {
                                                    echo "Pelayan";
                                                } else {
                                                    echo "Dapur";
                                                }?></td>
                                    <td><?php echo $row['nohp'] ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <button class="btn btn-info btn-sm me-1" data-bs-toggle="modal" data-bs-target="#ModalView<?php echo $row['id']?>"><i class="bi bi-eye-fill"></i></button>
                                            <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#ModalEditUser<?php echo $row['id']?>"><i class="bi bi-pencil-square"></i></button>
                                            <button class="btn btn-danger btn-sm me-1" data-bs-toggle="modal" data-bs-target="#ModalDeleteUser<?php echo $row['id']?>"><i class="bi bi-trash"></i></button>
                                            <button class="btn btn-secondary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#ModalResetPass<?php echo $row['id']?>"><i class="bi bi-key"></i></button>
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