<?php
$page_title = "Data Karyawan";

include '../template/header.php';


?>

<div class="container-fluid">
    <div class="d-  flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4" data-aos="fade-right">Data Karyawan</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal"
            data-aos="fade-left">
            <i class="bi bi-plus-circle-fill me-2"></i>Tambah Karyawan
        </button>
    </div>

    <div class="card shadow-sm" data-aos="fade-up" data-aos-delay="200">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Jabatan</th>
                            <th>No. Telepon</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM karyawan ORDER BY nama_lengkap ASC";
                        $result = mysqli_query($koneksi, $query);
                        $no = 1;

                        if (mysqli_num_rows($result) > 0) {
                            while ($data = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <img src="<?php echo BASE_URL; ?>assets/uploads/<?php echo htmlspecialchars($data['foto']); ?>"
                                            alt="Foto <?php echo htmlspecialchars($data['nama_lengkap']); ?>"
                                            class="img-thumbnail" width="60">
                                    </td>
                                    <td><?php echo htmlspecialchars($data['nik']); ?></td>
                                    <td><?php echo htmlspecialchars($data['nama_lengkap']); ?></td>
                                    <td><?php echo htmlspecialchars($data['jabatan']); ?></td>
                                    <td><?php echo htmlspecialchars($data['nomor_telepon']); ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal"
                                            data-bs-target="#editModal" data-id="<?php echo $data['id_karyawan']; ?>"
                                            data-nik="<?php echo htmlspecialchars($data['nik']); ?>"
                                            data-nama="<?php echo htmlspecialchars($data['nama_lengkap']); ?>"
                                            data-jabatan="<?php echo htmlspecialchars($data['jabatan']); ?>"
                                            data-telepon="<?php echo htmlspecialchars($data['nomor_telepon']); ?>"
                                            data-foto="<?php echo htmlspecialchars($data['foto']); ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <a href="hapus.php?id=<?php echo $data['id_karyawan']; ?>" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Anda yakin ingin menghapus data karyawan ini? Seluruh data absensi yang terkait juga akan terhapus.');">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>Belum ada data karyawan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="tambahModalLabel"><i class="bi bi-person-plus-fill me-2"></i>Form
                    Tambah Karyawan Baru</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK (Nomor Induk Karyawan)</label>
                                <input type="text" class="form-control" id="nik" name="nik" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="nomor_telepon" name="nomor_telepon">
                            </div>
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto Karyawan</label>
                                <input type="file" class="form-control" id="foto" name="foto"
                                    accept="image/png, image/jpeg, image/jpg">
                                <div class="form-text">Pilih file gambar (JPG, JPEG, PNG). Maksimal 2MB.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h1 class="modal-title fs-5" id="editModalLabel"><i class="bi bi-pencil-square me-2"></i>Form Edit Data
                    Karyawan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_karyawan" id="edit_id_karyawan">
                <input type="hidden" name="foto_lama" id="edit_foto_lama">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="edit_nik" name="nik" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="edit_nama_lengkap" name="nama_lengkap"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_jabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control" id="edit_jabatan" name="jabatan" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_nomor_telepon" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="edit_nomor_telepon" name="nomor_telepon">
                            </div>
                            <div class="mb-3">
                                <label for="edit_foto" class="form-label">Ganti Foto (Opsional)</label>
                                <input type="file" class="form-control" id="edit_foto" name="foto"
                                    accept="image/png, image/jpeg, image/jpg">
                                <div class="form-text">Biarkan kosong jika tidak ingin mengganti foto.</div>
                            </div>
                            <div>
                                <img src="" id="preview_foto_lama" class="img-thumbnail" width="120"
                                    alt="Foto saat ini">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="update" class="btn btn-warning">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php

include '../template/footer.php';
?>