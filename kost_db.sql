-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 17 Nov 2026 pada 14.26
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
-- Database: `kost_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(2, '2026-05-05-123539', 'App\\Database\\Migrations\\CreateSiKosTables', 'default', 'App', 1780877143, 1),
(3, '2026-11-13-200500', 'App\\Database\\Migrations\\AddPhotosToTipeKamar', 'default', 'App', 1794575056, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_booking`
--

CREATE TABLE `tb_booking` (
  `id_booking` int(11) UNSIGNED NOT NULL,
  `id_kos` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `id_kamar` int(11) UNSIGNED NOT NULL,
  `nama_calon` varchar(100) NOT NULL,
  `no_wa` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nominal_dp` int(11) DEFAULT NULL,
  `waktu_batas_dp` datetime DEFAULT NULL,
  `status_booking` enum('Menunggu Persetujuan','Menunggu DP','Paid','Ditolak') NOT NULL DEFAULT 'Menunggu Persetujuan',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_detail_bayar`
--

CREATE TABLE `tb_detail_bayar` (
  `id_detail` int(11) UNSIGNED NOT NULL,
  `id_bayar` int(11) UNSIGNED NOT NULL,
  `id_tagihan` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kamar`
--

CREATE TABLE `tb_kamar` (
  `id_kamar` int(11) UNSIGNED NOT NULL,
  `id_tipe` int(11) UNSIGNED NOT NULL,
  `no_kamar` varchar(10) NOT NULL,
  `status_kamar` enum('Tersedia','Terisi','Perbaikan') NOT NULL DEFAULT 'Tersedia',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_komplain`
--

CREATE TABLE `tb_komplain` (
  `id_komplain` int(11) UNSIGNED NOT NULL,
  `id_pengguna` int(11) UNSIGNED NOT NULL,
  `deskripsi` text NOT NULL,
  `foto_bukti` varchar(255) DEFAULT NULL,
  `status_perbaikan` enum('Pending','Proses','Selesai') NOT NULL DEFAULT 'Pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kos`
--

CREATE TABLE `tb_kos` (
  `id_kos` int(10) UNSIGNED NOT NULL,
  `nama_kos` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `alamat` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto_banner` varchar(255) DEFAULT NULL,
  `no_wa_pemilik` varchar(25) DEFAULT NULL,
  `email_pemilik` varchar(100) DEFAULT NULL,
  `status` enum('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kos`
--

INSERT INTO `tb_kos` (`id_kos`, `nama_kos`, `slug`, `alamat`, `deskripsi`, `foto_banner`, `no_wa_pemilik`, `email_pemilik`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Kos Grand Si-Kos (Pusat)', 'kos-grand-si-kos', 'Jl. Ring Road Utara No. 12, Sleman, D.I. Yogyakarta', 'Hunian kos nyaman, tenang, dan strategis dekat kampus dengan fasilitas lengkap dan keamanan 24 jam.', 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=1200&q=80', '081234567890', 'admin@sikos.com', 'Aktif', '2026-11-14 07:16:05', '2026-11-14 07:16:05'),
(2, 'Kos Melati Harmoni', 'kos-melati-harmoni', 'Jl. Kaliurang KM 5, Gang Melati No. 8, Yogyakarta', 'Kos eksklusif putri dan pasutri dengan nuansa asri, taman hijau, WiFi kencang 100 Mbps, dan parkir luas.', 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1200&q=80', '087812345678', 'melati@harmoni-kos.id', 'Aktif', '2026-11-14 07:16:05', '2026-11-14 07:16:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `id_bayar` int(11) UNSIGNED NOT NULL,
  `kode_transaksi` varchar(50) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `metode_bayar` varchar(50) DEFAULT NULL,
  `waktu_expired` datetime DEFAULT NULL,
  `status_transaksi` enum('Pending','Success','Expired') NOT NULL DEFAULT 'Pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengguna`
--

CREATE TABLE `tb_pengguna` (
  `id_pengguna` int(11) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Penghuni') NOT NULL,
  `id_kos` int(10) UNSIGNED DEFAULT 1,
  `is_first_login` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_pengguna`
--

INSERT INTO `tb_pengguna` (`id_pengguna`, `username`, `password`, `role`, `id_kos`, `is_first_login`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', '$2y$10$IVUzdbLJVyPHBUSQEL98R.EioPi/.r8.L/GzswzFH14tuzq3sjXLS', 'Admin', 1, 0, '2026-11-13 20:23:03', '2026-11-13 20:23:03', NULL),
(2, 'admin_utama', '$2y$10$saiwMcO5Yk9oNUpYjXnXsuSHtXrcbBzudCRVrdvxuzHYqECynV3Zy', 'Admin', 1, 0, '2026-11-13 20:23:03', '2026-11-13 20:23:03', NULL),
(3, '0821', '$2y$10$GsoulgE9S96a3UJjlU3IbufMimSh8fFT/bSMNrJVK8U0HoJPAP1V6', 'Penghuni', 1, 0, '2026-11-13 20:23:03', '2026-11-13 20:28:10', NULL),
(4, 'pemilik_melati', '$2y$10$yruo2yeHGo.BZmuXQ4B9AOeGEKOK35kbOkWd1ieJAt4IthNdmgCOi', 'Admin', 2, 0, '2026-11-14 07:23:55', '2026-11-14 07:23:55', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_profil_admin`
--

CREATE TABLE `tb_profil_admin` (
  `id_profil_admin` int(11) UNSIGNED NOT NULL,
  `id_pengguna` int(11) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `no_wa` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_profil_admin`
--

INSERT INTO `tb_profil_admin` (`id_profil_admin`, `id_pengguna`, `nama_lengkap`, `no_wa`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Administrator Kos', '081234567890', NULL, NULL, NULL),
(2, 2, 'Bapak Kos', '080000000001', NULL, NULL, NULL),
(3, 4, 'Ibu Melati (Pemilik Kos Melati)', '087812345678', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_profil_penghuni`
--

CREATE TABLE `tb_profil_penghuni` (
  `id_profil_penghuni` int(11) UNSIGNED NOT NULL,
  `id_kos` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `id_pengguna` int(11) UNSIGNED NOT NULL,
  `id_kamar` int(11) UNSIGNED DEFAULT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `no_wa` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `foto_ktp` varchar(255) DEFAULT NULL,
  `kontak_darurat` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_profil_penghuni`
--

INSERT INTO `tb_profil_penghuni` (`id_profil_penghuni`, `id_kos`, `id_pengguna`, `id_kamar`, `nama_lengkap`, `no_wa`, `email`, `foto_ktp`, `kontak_darurat`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 3, NULL, 'Awaludin', '0821', 'udin@gmail.com', '1794576490_cbd59665b0ca32847721.jpg', '082216258849', NULL, '2026-11-13 20:28:10', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_tagihan`
--

CREATE TABLE `tb_tagihan` (
  `id_tagihan` int(11) UNSIGNED NOT NULL,
  `id_pengguna` int(11) UNSIGNED NOT NULL,
  `bulan` varchar(20) NOT NULL,
  `tahun` year(4) NOT NULL,
  `nominal_asal` int(11) NOT NULL,
  `nominal_denda` int(11) NOT NULL DEFAULT 0,
  `status_bayar` enum('Belum Bayar','Lunas','Dibatalkan') NOT NULL DEFAULT 'Belum Bayar',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_tipe_kamar`
--

CREATE TABLE `tb_tipe_kamar` (
  `id_tipe` int(11) UNSIGNED NOT NULL,
  `id_kos` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `nama_tipe` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga_dasar` int(11) NOT NULL,
  `fasilitas` text DEFAULT NULL,
  `foto_1` varchar(255) DEFAULT NULL,
  `foto_2` varchar(255) DEFAULT NULL,
  `foto_3` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_booking`
--
ALTER TABLE `tb_booking`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `tb_booking_id_kamar_foreign` (`id_kamar`);

--
-- Indeks untuk tabel `tb_detail_bayar`
--
ALTER TABLE `tb_detail_bayar`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `tb_detail_bayar_id_bayar_foreign` (`id_bayar`),
  ADD KEY `tb_detail_bayar_id_tagihan_foreign` (`id_tagihan`);

--
-- Indeks untuk tabel `tb_kamar`
--
ALTER TABLE `tb_kamar`
  ADD PRIMARY KEY (`id_kamar`),
  ADD KEY `tb_kamar_id_tipe_foreign` (`id_tipe`);

--
-- Indeks untuk tabel `tb_komplain`
--
ALTER TABLE `tb_komplain`
  ADD PRIMARY KEY (`id_komplain`),
  ADD KEY `tb_komplain_id_pengguna_foreign` (`id_pengguna`);

--
-- Indeks untuk tabel `tb_kos`
--
ALTER TABLE `tb_kos`
  ADD PRIMARY KEY (`id_kos`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD PRIMARY KEY (`id_bayar`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`);

--
-- Indeks untuk tabel `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `tb_profil_admin`
--
ALTER TABLE `tb_profil_admin`
  ADD PRIMARY KEY (`id_profil_admin`),
  ADD KEY `tb_profil_admin_id_pengguna_foreign` (`id_pengguna`);

--
-- Indeks untuk tabel `tb_profil_penghuni`
--
ALTER TABLE `tb_profil_penghuni`
  ADD PRIMARY KEY (`id_profil_penghuni`),
  ADD KEY `tb_profil_penghuni_id_pengguna_foreign` (`id_pengguna`);

--
-- Indeks untuk tabel `tb_tagihan`
--
ALTER TABLE `tb_tagihan`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD KEY `tb_tagihan_id_pengguna_foreign` (`id_pengguna`);

--
-- Indeks untuk tabel `tb_tipe_kamar`
--
ALTER TABLE `tb_tipe_kamar`
  ADD PRIMARY KEY (`id_tipe`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_booking`
--
ALTER TABLE `tb_booking`
  MODIFY `id_booking` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_detail_bayar`
--
ALTER TABLE `tb_detail_bayar`
  MODIFY `id_detail` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_kamar`
--
ALTER TABLE `tb_kamar`
  MODIFY `id_kamar` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_komplain`
--
ALTER TABLE `tb_komplain`
  MODIFY `id_komplain` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_kos`
--
ALTER TABLE `tb_kos`
  MODIFY `id_kos` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  MODIFY `id_bayar` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  MODIFY `id_pengguna` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_profil_admin`
--
ALTER TABLE `tb_profil_admin`
  MODIFY `id_profil_admin` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_profil_penghuni`
--
ALTER TABLE `tb_profil_penghuni`
  MODIFY `id_profil_penghuni` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_tagihan`
--
ALTER TABLE `tb_tagihan`
  MODIFY `id_tagihan` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_tipe_kamar`
--
ALTER TABLE `tb_tipe_kamar`
  MODIFY `id_tipe` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_booking`
--
ALTER TABLE `tb_booking`
  ADD CONSTRAINT `tb_booking_id_kamar_foreign` FOREIGN KEY (`id_kamar`) REFERENCES `tb_kamar` (`id_kamar`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_detail_bayar`
--
ALTER TABLE `tb_detail_bayar`
  ADD CONSTRAINT `tb_detail_bayar_id_bayar_foreign` FOREIGN KEY (`id_bayar`) REFERENCES `tb_pembayaran` (`id_bayar`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_detail_bayar_id_tagihan_foreign` FOREIGN KEY (`id_tagihan`) REFERENCES `tb_tagihan` (`id_tagihan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_kamar`
--
ALTER TABLE `tb_kamar`
  ADD CONSTRAINT `tb_kamar_id_tipe_foreign` FOREIGN KEY (`id_tipe`) REFERENCES `tb_tipe_kamar` (`id_tipe`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_komplain`
--
ALTER TABLE `tb_komplain`
  ADD CONSTRAINT `tb_komplain_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `tb_pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_profil_admin`
--
ALTER TABLE `tb_profil_admin`
  ADD CONSTRAINT `tb_profil_admin_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `tb_pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_profil_penghuni`
--
ALTER TABLE `tb_profil_penghuni`
  ADD CONSTRAINT `tb_profil_penghuni_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `tb_pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_tagihan`
--
ALTER TABLE `tb_tagihan`
  ADD CONSTRAINT `tb_tagihan_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `tb_pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
