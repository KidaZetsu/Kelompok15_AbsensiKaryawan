<?php

include_once __DIR__ . '/../koneksi.php'; 


?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : "Sistem Absensi"; ?> - Bengkel BDL</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">

</head>
<body class="bg-light">

    <div class="d-flex" id="wrapper">
        <div class="bg-dark border-end" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-dark text-white">
                <i class="bi bi-calendar-check-fill me-2"></i>Absensi BDL
            </div>
            <div class="list-group list-group-flush">
                <a href="<?php echo BASE_URL; ?>index.php" class="list-group-item list-group-item-action list-group-item-dark p-3"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                <a href="<?php echo BASE_URL; ?>karyawan/data.php" class="list-group-item list-group-item-action list-group-item-dark p-3"><i class="bi bi-people-fill me-2"></i>Data Karyawan</a>
                <a href="<?php echo BASE_URL; ?>absensi/data.php" class="list-group-item list-group-item-action list-group-item-dark p-3"><i class="bi bi-clipboard-data-fill me-2"></i>Kelola Absensi</a>
                <a href="<?php echo BASE_URL; ?>laporan/bulanan.php" class="list-group-item list-group-item-action list-group-item-dark p-3"><i class="bi bi-file-earmark-bar-graph-fill me-2"></i>Laporan</a>
            </div>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle"><i class="bi bi-list"></i></button>
                    <div class="ms-auto fw-bold">
                        Selamat Datang, Admin!
                    </div>
                </div>
            </nav>

            <div class="container-fluid p-4">