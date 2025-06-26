<?php

include '../koneksi.php';


if (isset($_POST['simpan'])) {

    
    $nik = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $nomor_telepon = mysqli_real_escape_string($koneksi, $_POST['nomor_telepon']);

    
    $foto_nama = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $nama_file_unik = "";

    
    if ($foto_nama) {
        
        $nama_file_unik = time() . '_' . $foto_nama;
        
        
        $tujuan_upload = '../assets/uploads/' . $nama_file_unik;
        
        
        if (move_uploaded_file($foto_tmp, $tujuan_upload)) {
            
        } else {
            
            echo "<script>alert('Gagal mengupload foto.'); window.history.back();</script>";
            exit;
        }
    } else {
        
        $nama_file_unik = 'default.png'; 
    }

    
    $query = "INSERT INTO karyawan (nik, nama_lengkap, jabatan, nomor_telepon, foto) 
              VALUES ('$nik', '$nama_lengkap', '$jabatan', '$nomor_telepon', '$nama_file_unik')";

    
    $result = mysqli_query($koneksi, $query);

    
    if ($result) {
      
        echo "<script>
                alert('Data karyawan baru berhasil ditambahkan!');
                window.location.href = 'data.php';
              </script>";
    } else {
        
        echo "<script>
                alert('Gagal menambahkan data. Error: " . mysqli_error($koneksi) . "');
                window.history.back();
              </script>";
    }
} else {
    
    header('Location: data.php');
}
?>