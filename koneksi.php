<?php


$hostname = "localhost";        
$username = "root";             
$password = "";                
$database = "db_absensi_uas";  


$koneksi = mysqli_connect($hostname, $username, $password, $database);


if (!$koneksi) {
    
    die("KONEKSI KE DATABASE GAGAL: " . mysqli_connect_error());
}



define('BASE_URL', 'http://localhost/Projek_Kelompok_5/');

?>