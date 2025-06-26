<?php 
$page_title = "Laporan Absensi Bulanan";
include '../template/header.php';


$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$nama_bulan = DateTime::createFromFormat('!m', $bulan)->format('F');


$query_hadir = "SELECT COUNT(*) as total FROM absensi WHERE status_kehadiran = 'Hadir' AND MONTH(waktu_masuk) = '$bulan' AND YEAR(waktu_masuk) = '$tahun'";
$total_hadir = mysqli_fetch_assoc(mysqli_query($koneksi, $query_hadir))['total'];

$query_izin = "SELECT COUNT(*) as total FROM absensi WHERE status_kehadiran = 'Izin' AND MONTH(waktu_masuk) = '$bulan' AND YEAR(waktu_masuk) = '$tahun'";
$total_izin = mysqli_fetch_assoc(mysqli_query($koneksi, $query_izin))['total'];

$query_sakit = "SELECT COUNT(*) as total FROM absensi WHERE status_kehadiran = 'Sakit' AND MONTH(waktu_masuk) = '$bulan' AND YEAR(waktu_masuk) = '$tahun'";
$total_sakit = mysqli_fetch_assoc(mysqli_query($koneksi, $query_sakit))['total'];



$query_laporan = "SELECT * FROM v_rekap_absensi WHERE MONTH(waktu_masuk) = '$bulan' AND YEAR(waktu_masuk) = '$tahun'";
$result_laporan = mysqli_query($koneksi, $query_laporan);


$data_absensi = [];
while($row = mysqli_fetch_assoc($result_laporan)) {
    $tanggal = date('j', strtotime($row['waktu_masuk'])); // Ambil tanggalnya saja (angka 1-31)
    $data_absensi[$row['id_karyawan']][$tanggal] = $row['status_kehadiran'];
}


$jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
?>

<div class="container-fluid">
    <h1 class="mt-4 mb-4" data-aos="fade-right">Laporan Bulanan</h1>

    <div class="card shadow-sm mb-4" data-aos="fade-up">
        <div class="card-body">
            <form method="GET" action="bulanan.php" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="bulan" class="form-label">Pilih Bulan</label>
                    <select name="bulan" id="bulan" class="form-select">
                        <?php for ($i = 1; $i <= 12; $i++) {
                            $selected = ($i == $bulan) ? 'selected' : '';
                            echo "<option value='" . str_pad($i, 2, '0', STR_PAD_LEFT) . "' $selected>" . DateTime::createFromFormat('!m', $i)->format('F') . "</option>";
                        } ?>
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="tahun" class="form-label">Pilih Tahun</label>
                    <select name="tahun" id="tahun" class="form-select">
                        <?php for ($i = date('Y'); $i >= date('Y') - 5; $i--) {
                            $selected = ($i == $tahun) ? 'selected' : '';
                            echo "<option value='$i' $selected>$i</option>";
                        } ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="row" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-4 mb-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body"><i class="bi bi-check-circle-fill me-2"></i>Total Kehadiran Bulan Ini: <strong><?php echo $total_hadir; ?></strong></div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card bg-info text-dark shadow">
                <div class="card-body"><i class="bi bi-info-circle-fill me-2"></i>Total Izin Bulan Ini: <strong><?php echo $total_izin; ?></strong></div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card bg-warning text-dark shadow">
                <div class="card-body"><i class="bi bi-bandaid-fill me-2"></i>Total Sakit Bulan Ini: <strong><?php echo $total_sakit; ?></strong></div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm" data-aos="fade-up" data-aos-delay="200">
        <div class="card-header">
            <h5 class="mb-0">Detail Laporan Bulan: <?php echo $nama_bulan . " " . $tahun; ?></h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center report-table">
                    <thead class="table-dark">
                        <tr>
                            <th rowspan="2" class="align-middle">Nama Karyawan</th>
                            <th colspan="<?php echo $jumlah_hari; ?>">Tanggal</th>
                            <th colspan="4" class="bg-secondary">Total</th>
                        </tr>
                        <tr>
                            <?php for ($i = 1; $i <= $jumlah_hari; $i++) echo "<th>$i</th>"; ?>
                            <th class="bg-success text-white">H</th>
                            <th class="bg-info text-dark">I</th>
                            <th class="bg-warning text-dark">S</th>
                            <th class="bg-danger text-white">A</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $karyawan_query = "SELECT id_karyawan, nama_lengkap FROM karyawan ORDER BY nama_lengkap";
                        $karyawan_result = mysqli_query($koneksi, $karyawan_query);
                        while ($karyawan = mysqli_fetch_assoc($karyawan_result)) {
                            $id_karyawan = $karyawan['id_karyawan'];
                            $total_H = 0; $total_I = 0; $total_S = 0; $total_A = 0;
                            echo "<tr><td class='text-start'>" . htmlspecialchars($karyawan['nama_lengkap']) . "</td>";
                            for ($hari = 1; $hari <= $jumlah_hari; $hari++) {
                                $nama_hari = date('N', strtotime("$tahun-$bulan-$hari"));
                                $status = '-';
                                if (isset($data_absensi[$id_karyawan][$hari])) {
                                    $status = substr($data_absensi[$id_karyawan][$hari], 0, 1);
                                    if($status == 'H') $total_H++;
                                    if($status == 'I') $total_I++;
                                    if($status == 'S') $total_S++;
                                } else if ($nama_hari < 6) { 
                                    $status = 'A'; 
                                    $total_A++;
                                }
                                echo "<td class='status-cell-$status'>$status</td>";
                            }
                            echo "<td>$total_H</td><td>$total_I</td><td>$total_S</td><td>$total_A</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <strong>Keterangan:</strong>
                <span class="badge bg-success">H: Hadir</span>
                <span class="badge bg-info text-dark">I: Izin</span>
                <span class="badge bg-warning text-dark">S: Sakit</span>
                <span class="badge bg-danger">A: Alpha</span>
                <span class="badge bg-light text-dark border">-: Libur</span>
            </div>
        </div>
    </div>
</div>

<?php include '../template/footer.php'; ?>