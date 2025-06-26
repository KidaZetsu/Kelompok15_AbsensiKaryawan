<?php
include '../koneksi.php';


if (isset($_POST['catat_hadir'])) {
    $id_karyawan = $_POST['id_karyawan'];

    
    $query = "CALL sp_catat_absensi_masuk($id_karyawan)";
    
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Absensi masuk berhasil dicatat!');</script>";
    } else {
        echo "<script>alert('Gagal mencatat absensi. Error: " . mysqli_error($koneksi) . "');</script>";
    }
   
    echo "<script>window.history.back();</script>";
}


if (isset($_POST['catat_keluar'])) {
    $id_absensi = $_POST['id_absensi'];
    
    
    $query = "UPDATE absensi SET waktu_keluar = NOW() WHERE id_absensi = '$id_absensi'";
    
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Absensi keluar berhasil dicatat!');</script>";
    } else {
        echo "<script>alert('Gagal mencatat absensi keluar. Error: " . mysqli_error($koneksi) . "');</script>";
    }
    echo "<script>window.history.back();</script>";
}


if (isset($_POST['simpan_keterangan'])) {
    $id_karyawan = $_POST['id_karyawan'];
    $status = $_POST['status'];
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan_text']);
    $tanggal_sekarang = date('Y-m-d H:i:s');

    
    $query = "INSERT INTO absensi (id_karyawan, waktu_masuk, status_kehadiran, keterangan) 
              VALUES ('$id_karyawan', '$tanggal_sekarang', '$status', '$keterangan')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Keterangan berhasil disimpan!');</script>";
    } else {
        echo "<script>alert('Gagal menyimpan keterangan. Error: " . mysqli_error($koneksi) . "');</script>";
    }
    echo "<script>window.history.back();</script>";
}
?>