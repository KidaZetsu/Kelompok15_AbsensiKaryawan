<?php
include '../koneksi.php';


if (isset($_GET['id'])) {
    $id_karyawan = $_GET['id'];

    
    $query_select = "SELECT foto FROM karyawan WHERE id_karyawan = '$id_karyawan'";
    $result_select = mysqli_query($koneksi, $query_select);
    if ($data = mysqli_fetch_assoc($result_select)) {
        $foto_untuk_dihapus = $data['foto'];
    }

    
    $query_delete = "DELETE FROM karyawan WHERE id_karyawan = '$id_karyawan'";
    $result_delete = mysqli_query($koneksi, $query_delete);

    if ($result_delete) {
       
        if (isset($foto_untuk_dihapus) && $foto_untuk_dihapus != 'default.png') {
            $path_ke_file = '../assets/uploads/' . $foto_untuk_dihapus;
            if (file_exists($path_ke_file)) {
                unlink($path_ke_file);
            }
        }
        echo "<script>alert('Data karyawan berhasil dihapus!'); window.location.href = 'data.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data. Error: " . mysqli_error($koneksi) . "'); window.location.href = 'data.php';</script>";
    }
} else {
   
    header('Location: data.php');
}
?>