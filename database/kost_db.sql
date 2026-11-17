-- Database: kost_db
CREATE DATABASE IF NOT EXISTS `kost_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `kost_db`;

-- 1. tb_pengguna
CREATE TABLE IF NOT EXISTS `tb_pengguna` (
  `id_pengguna` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Penghuni') NOT NULL DEFAULT 'Penghuni',
  `is_first_login` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pengguna`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. tb_profil_admin
CREATE TABLE IF NOT EXISTS `tb_profil_admin` (
  `id_profil_admin` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengguna` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `no_wa` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_profil_admin`),
  KEY `id_pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. tb_tipe_kamar
CREATE TABLE IF NOT EXISTS `tb_tipe_kamar` (
  `id_tipe` int(11) NOT NULL AUTO_INCREMENT,
  `nama_tipe` varchar(100) NOT NULL,
  `harga_dasar` decimal(12,2) NOT NULL DEFAULT 0.00,
  `fasilitas` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto_1` varchar(255) DEFAULT NULL,
  `foto_2` varchar(255) DEFAULT NULL,
  `foto_3` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_tipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. tb_kamar
CREATE TABLE IF NOT EXISTS `tb_kamar` (
  `id_kamar` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipe` int(11) NOT NULL,
  `no_kamar` varchar(20) NOT NULL,
  `status_kamar` varchar(50) NOT NULL DEFAULT 'Tersedia',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_kamar`),
  KEY `id_tipe` (`id_tipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. tb_profil_penghuni
CREATE TABLE IF NOT EXISTS `tb_profil_penghuni` (
  `id_profil_penghuni` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengguna` int(11) NOT NULL,
  `id_kamar` int(11) DEFAULT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `no_wa` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `foto_ktp` varchar(255) DEFAULT NULL,
  `kontak_darurat` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_profil_penghuni`),
  KEY `id_pengguna` (`id_pengguna`),
  KEY `id_kamar` (`id_kamar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. tb_booking
CREATE TABLE IF NOT EXISTS `tb_booking` (
  `id_booking` int(11) NOT NULL AUTO_INCREMENT,
  `id_kamar` int(11) NOT NULL,
  `nama_calon` varchar(100) NOT NULL,
  `no_wa` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status_booking` varchar(50) NOT NULL DEFAULT 'Pending',
  `nominal_dp` decimal(12,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_booking`),
  KEY `id_kamar` (`id_kamar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. tb_tagihan
CREATE TABLE IF NOT EXISTS `tb_tagihan` (
  `id_tagihan` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengguna` int(11) NOT NULL,
  `bulan` varchar(20) NOT NULL,
  `tahun` int(5) NOT NULL,
  `nominal_asal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `nominal_denda` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status_bayar` varchar(50) NOT NULL DEFAULT 'Belum Bayar',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_tagihan`),
  KEY `id_pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. tb_pembayaran
CREATE TABLE IF NOT EXISTS `tb_pembayaran` (
  `id_bayar` int(11) NOT NULL AUTO_INCREMENT,
  `kode_transaksi` varchar(100) NOT NULL,
  `total_bayar` decimal(12,2) NOT NULL DEFAULT 0.00,
  `metode_bayar` varchar(50) DEFAULT NULL,
  `waktu_expired` datetime DEFAULT NULL,
  `status_transaksi` varchar(50) NOT NULL DEFAULT 'Pending',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_bayar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 9. tb_detail_bayar
CREATE TABLE IF NOT EXISTS `tb_detail_bayar` (
  `id_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_bayar` int(11) NOT NULL,
  `id_tagihan` int(11) NOT NULL,
  PRIMARY KEY (`id_detail`),
  KEY `id_bayar` (`id_bayar`),
  KEY `id_tagihan` (`id_tagihan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 10. tb_komplain
CREATE TABLE IF NOT EXISTS `tb_komplain` (
  `id_komplain` int(11) NOT NULL AUTO_INCREMENT,
  `id_pengguna` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto_bukti` varchar(255) DEFAULT NULL,
  `status_perbaikan` varchar(50) NOT NULL DEFAULT 'Menunggu',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_komplain`),
  KEY `id_pengguna` (`id_pengguna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample Data: Akun Admin Default (username: admin, password: password / admin123)
-- Password 'admin123' hash: $2y$10$w3zCJonVrZLk/HVYOaXYe.gCnV3/wQ8qXwW4oz2XHTxjgU4J8W4mG
INSERT IGNORE INTO `tb_pengguna` (`id_pengguna`, `username`, `password`, `role`, `is_first_login`) VALUES
(1, 'admin', '$2y$10$w3zCJonVrZLk/HVYOaXYe.gCnV3/wQ8qXwW4oz2XHTxjgU4J8W4mG', 'Admin', 0);

INSERT IGNORE INTO `tb_profil_admin` (`id_profil_admin`, `id_pengguna`, `nama_lengkap`, `no_wa`) VALUES
(1, 1, 'Administrator Kos', '081234567890');

-- Sample Data Tipe Kamar
INSERT IGNORE INTO `tb_tipe_kamar` (`id_tipe`, `nama_tipe`, `harga_dasar`, `fasilitas`, `deskripsi`) VALUES
(1, 'Standar', 750000.00, 'Kasur, Lemari, Kipas Angin, Kamar Mandi Luar', 'Kamar tipe standar yang nyaman dan ekonomis.'),
(2, 'Deluxe', 1200000.00, 'Kasur Spring Bed, Lemari, AC, Meja Belajar, Kamar Mandi Dalam', 'Kamar deluxe dengan pendingin udara dan kamar mandi pribadi.');

-- Sample Data Kamar
INSERT IGNORE INTO `tb_kamar` (`id_kamar`, `id_tipe`, `no_kamar`, `status_kamar`) VALUES
(1, 1, 'A-01', 'Tersedia'),
(2, 1, 'A-02', 'Tersedia'),
(3, 2, 'B-01', 'Tersedia');
