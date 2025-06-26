<?php 
$page_title = "Kelola Absensi Harian";
include '../template/header.php'; 


$tanggal_dipilih = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-right">
        <h1 class="mt-4">Kelola Absensi</h1>
        <form method="GET" action="data.php" class="d-flex align-items-center">
            <input type="date" name="tanggal" class="form-control me-2" value="<?php echo $tanggal_dipilih; ?>">
            <button type="submit" class="btn btn-info text-white">Tampilkan</button>
        </form>
    </div>

    <div class="card shadow-sm" data-aos="fade-up" data-aos-delay="200">
        <div class="card-header">
            <h5 class="mb-0">Daftar Kehadiran Tanggal: <?php echo date('d F Y', strtotime($tanggal_dipilih)); ?></h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama Karyawan</th>
                            <th>Jabatan</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        $query = "SELECT k.id_karyawan, k.nama_lengkap, k.jabatan, a.id_absensi, a.waktu_masuk, a.waktu_keluar, a.status_kehadiran
                                  FROM karyawan k
                                  LEFT JOIN absensi a ON k.id_karyawan = a.id_karyawan AND DATE(a.waktu_masuk) = '$tanggal_dipilih'
                                  ORDER BY k.nama_lengkap ASC";
                        
                        $result = mysqli_query($koneksi, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($data = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($data['nama_lengkap']); ?></td>
                                <td><?php echo htmlspecialchars($data['jabatan']); ?></td>
                                <td><?php echo $data['waktu_masuk'] ? date('H:i:s', strtotime($data['waktu_masuk'])) : '-'; ?></td>
                                <td><?php echo $data['waktu_keluar'] ? date('H:i:s', strtotime($data['waktu_keluar'])) : '-'; ?></td>
                                <td class="text-center">
                                    <?php
                                    
                                    if ($data['status_kehadiran'] == 'Hadir') {
                                        echo '<span class="badge bg-success">Hadir</span>';
                                    } elseif ($data['status_kehadiran'] == 'Sakit') {
                                        echo '<span class="badge bg-warning text-dark">Sakit</span>';
                                    } elseif ($data['status_kehadiran'] == 'Izin') {
                                        echo '<span class="badge bg-info text-dark">Izin</span>';
                                    } else {
                                        echo '<span class="badge bg-danger">Alpha</span>';
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    
                                    if (!$data['id_absensi']) { 
                                    ?>
                                        <form action="proses_absensi.php" method="POST" class="d-inline">
                                            <input type="hidden" name="id_karyawan" value="<?php echo $data['id_karyawan']; ?>">
                                            <button type="submit" name="catat_hadir" class="btn btn-success btn-sm">Catat Hadir</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary btn-sm keterangan-btn" data-bs-toggle="modal" data-bs-target="#keteranganModal" data-id="<?php echo $data['id_karyawan']; ?>" data-nama="<?php echo htmlspecialchars($data['nama_lengkap']); ?>">
                                            Izin/Sakit
                                        </button>
                                    <?php
                                    } elseif ($data['status_kehadiran'] == 'Hadir' && !$data['waktu_keluar']) { 
                                    ?>
                                        <form action="proses_absensi.php" method="POST" class="d-inline">
                                            <input type="hidden" name="id_absensi" value="<?php echo $data['id_absensi']; ?>">
                                            <button type="submit" name="catat_keluar" class="btn btn-warning btn-sm">Catat Keluar</button>
                                        </form>
                                    <?php
                                    } else { 
                                        echo '<span>-</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>Tidak ada data karyawan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="keteranganModal" tabindex="-1" aria-labelledby="keteranganModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-secondary text-white">
        <h1 class="modal-title fs-5" id="keteranganModalLabel">Input Keterangan</h1>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="proses_absensi.php" method="POST">
        <div class="modal-body">
            <input type="hidden" name="id_karyawan" id="keterangan_id_karyawan">
            <div class="mb-3">
                <label class="form-label">Nama Karyawan</label>
                <input type="text" class="form-control" id="keterangan_nama_karyawan" readonly>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="Izin">Izin</option>
                    <option value="Sakit">Sakit</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="keterangan_text" class="form-label">Keterangan</label>
                <textarea name="keterangan_text" class="form-control" rows="3" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Batal</button>
          <button type="submit" name="simpan_keterangan" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include '../template/footer.php'; ?>