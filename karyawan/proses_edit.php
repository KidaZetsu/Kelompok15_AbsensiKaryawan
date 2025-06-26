<?php
include '../koneksi.php';

if (isset($_POST['update'])) {
    // Ambil data dari form
    $id_karyawan = $_POST['id_karyawan'];
    $nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $nomor_telepon = mysqli_real_escape_string($koneksi, $_POST['nomor_telepon']);
    $foto_lama = $_POST['foto_lama'];

    // Cek apakah ada file foto baru yang diupload
    if (!empty($_FILES['foto']['name'])) {
        $foto_nama = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $nama_file_unik = time() . '_' . $foto_nama;
        $tujuan_upload = '../assets/uploads/' . $nama_file_unik;
        
        // Pindahkan file baru
        if (move_uploaded_file($foto_tmp, $tujuan_upload)) {
            // Jika foto lama bukan 'default.png', hapus file foto lama
            if ($foto_lama != 'default.png' && file_exists('../assets/uploads/' . $foto_lama)) {
                unlink('../assets/uploads/' . $foto_lama);
            }
            // Update nama file foto baru ke variabel
            $foto_untuk_db = $nama_file_unik;
        } else {
            echo "<script>alert('Gagal mengupload foto baru.'); window.history.back();</script>";
            exit;
        }
    } else {
        // Jika tidak ada foto baru, gunakan nama foto lama
        $foto_untuk_db = $foto_lama;
    }
    
    // Buat query UPDATE
    $query = "UPDATE karyawan SET 
                nik = '$nik', 
                nama_lengkap = '$nama_lengkap', 
                jabatan = '$jabatan', 
                nomor_telepon = '$nomor_telepon', 
                foto = '$foto_untuk_db' 
              WHERE id_karyawan = '$id_karyawan'";
    
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Data karyawan berhasil diperbarui!'); window.location.href = 'data.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data. Error: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
    }
}
?>