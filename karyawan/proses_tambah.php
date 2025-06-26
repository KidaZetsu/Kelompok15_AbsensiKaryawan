<?php
// Panggil file koneksi
include '../koneksi.php';

// Cek apakah tombol 'simpan' telah ditekan
if (isset($_POST['simpan'])) {

    // Ambil data dari form
    $nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $nomor_telepon = mysqli_real_escape_string($koneksi, $_POST['nomor_telepon']);

    // --- LOGIKA UNTUK UPLOAD FOTO ---
    $foto_nama = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $nama_file_unik = "";

    // Cek apakah pengguna mengupload gambar atau tidak
    if ($foto_nama) {
        // Buat nama file yang unik untuk menghindari nama file yang sama
        // Contoh: 167888999_nama_fotonya.jpg
        $nama_file_unik = time() . '_' . $foto_nama;
        
        // Tentukan folder tujuan upload
        $tujuan_upload = '../assets/uploads/' . $nama_file_unik;
        
        // Pindahkan file yang diupload dari folder temporary ke folder tujuan
        if (move_uploaded_file($foto_tmp, $tujuan_upload)) {
            // File berhasil diupload
        } else {
            // Gagal upload, beri pesan error dan kembali
            echo "<script>alert('Gagal mengupload foto.'); window.history.back();</script>";
            exit;
        }
    } else {
        // Jika pengguna tidak mengupload foto, gunakan foto default
        $nama_file_unik = 'default.png'; 
    }

    // Buat query INSERT untuk menyimpan data ke database
    $query = "INSERT INTO karyawan (nik, nama_lengkap, jabatan, nomor_telepon, foto) 
              VALUES ('$nik', '$nama_lengkap', '$jabatan', '$nomor_telepon', '$nama_file_unik')";

    // Eksekusi query
    $result = mysqli_query($koneksi, $query);

    // Cek apakah query berhasil
    if ($result) {
        // Jika berhasil, redirect ke halaman data.php dengan pesan sukses
        echo "<script>
                alert('Data karyawan baru berhasil ditambahkan!');
                window.location.href = 'data.php';
              </script>";
    } else {
        // Jika gagal, tampilkan pesan error
        echo "<script>
                alert('Gagal menambahkan data. Error: " . mysqli_error($koneksi) . "');
                window.history.back();
              </script>";
    }
} else {
    // Jika halaman diakses tanpa menekan tombol simpan, tendang kembali
    header('Location: data.php');
}
?>