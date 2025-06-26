-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Jun 2025 pada 04.53
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_absensi_uas`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_catat_absensi_masuk` (IN `karyawan_id` INT)   BEGIN
    
    IF NOT EXISTS (SELECT 1 FROM absensi WHERE id_karyawan = karyawan_id AND DATE(waktu_masuk) = CURDATE()) THEN
        INSERT INTO absensi(id_karyawan, waktu_masuk, status_kehadiran, keterangan)
        VALUES (karyawan_id, NOW(), 'Hadir', 'Absen masuk via sistem');
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `waktu_masuk` datetime DEFAULT NULL,
  `waktu_keluar` datetime DEFAULT NULL,
  `status_kehadiran` enum('Hadir','Sakit','Izin') NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_karyawan`, `waktu_masuk`, `waktu_keluar`, `status_kehadiran`, `keterangan`) VALUES
(1, 1, '2025-06-26 09:17:44', '2025-06-26 09:18:21', 'Hadir', 'Absen masuk via sistem'),
(2, 2, '2025-06-26 04:47:47', NULL, 'Izin', 'Sedang Perform Acara World Tour');

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `foto` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nik`, `nama_lengkap`, `jabatan`, `nomor_telepon`, `foto`) VALUES
(1, '2455301073', 'Gede Abhita', 'Manajer', '088278904304', 'default.png'),
(2, '245536969', 'Rusdiman Baik Budiman', 'Supporter', '088269696', '1750906002_download.jpg');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_rekap_absensi`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_rekap_absensi` (
`id_absensi` int(11)
,`id_karyawan` int(11)
,`nik` varchar(50)
,`nama_lengkap` varchar(255)
,`jabatan` varchar(100)
,`waktu_masuk` datetime
,`waktu_keluar` datetime
,`status_kehadiran` enum('Hadir','Sakit','Izin')
,`keterangan` text
);

-- --------------------------------------------------------

--
-- Struktur untuk view `v_rekap_absensi`
--
DROP TABLE IF EXISTS `v_rekap_absensi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_rekap_absensi`  AS SELECT `a`.`id_absensi` AS `id_absensi`, `k`.`id_karyawan` AS `id_karyawan`, `k`.`nik` AS `nik`, `k`.`nama_lengkap` AS `nama_lengkap`, `k`.`jabatan` AS `jabatan`, `a`.`waktu_masuk` AS `waktu_masuk`, `a`.`waktu_keluar` AS `waktu_keluar`, `a`.`status_kehadiran` AS `status_kehadiran`, `a`.`keterangan` AS `keterangan` FROM (`absensi` `a` join `karyawan` `k` on(`a`.`id_karyawan` = `k`.`id_karyawan`)) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `fk_absensi_karyawan` (`id_karyawan`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD KEY `idx_nama_karyawan` (`nama_lengkap`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `fk_absensi_karyawan` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
