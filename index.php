<?php 
$page_title = "Dashboard";
include 'template/header.php'; 

// Nanti di sini kita akan ambil data dinamis dari database
$total_karyawan = 15;
$hadir_hari_ini = 12;
$izin_sakit_hari_ini = 3;
?>

<h1 class="mt-4 mb-4" data-aos="fade-right">Dashboard</h1>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Karyawan Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_karyawan; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people-fill fs-1 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hadir Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $hadir_hari_ini; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-person-check-fill fs-1 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Izin / Sakit Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $izin_sakit_hari_ini; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-person-x-fill fs-1 text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row align-items-center" data-aos="fade-up" data-aos-delay="400">
    <div class="col-lg-6">
        <h3 class="mb-3">Kelola Data dengan Mudah</h3>
        <p class="text-muted">Gunakan sistem ini untuk memantau kehadiran karyawan secara efisien, menambah data karyawan baru, dan mencetak laporan bulanan hanya dengan beberapa klik.</p>
        <a href="<?php echo BASE_URL; ?>karyawan/data.php" class="btn btn-primary">Lihat Data Karyawan <i class="bi bi-arrow-right-short"></i></a>
    </div>
    <div class="col-lg-6 text-center">
        <img src="<?php echo BASE_URL; ?>assets/img/nama_ilustrasi.svg" alt="Ilustrasi Manajemen Data" class="img-fluid">
    </div>
</div>

<?php include 'template/footer.php'; ?>