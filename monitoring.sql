-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Agu 2021 pada 17.19
-- Versi server: 10.4.19-MariaDB
-- Versi PHP: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monitoring`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `earned_value`
--

CREATE TABLE `earned_value` (
  `id_earned_value` bigint(20) UNSIGNED NOT NULL,
  `id_projek` bigint(20) UNSIGNED DEFAULT NULL,
  `id_schedule` bigint(20) UNSIGNED DEFAULT NULL,
  `bobot_actual_kum` double DEFAULT 0,
  `bobot_schedule_kum` double DEFAULT 0,
  `acwp_kum` double DEFAULT 0,
  `bcwp_kum` double DEFAULT 0,
  `bcws_kum` double DEFAULT 0,
  `cv` double DEFAULT 0,
  `sv` double DEFAULT 0,
  `cpi` double DEFAULT 0,
  `spi` double DEFAULT 0,
  `etc` double DEFAULT 0,
  `eac` double DEFAULT 0,
  `te` double DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `earned_value`
--

INSERT INTO `earned_value` (`id_earned_value`, `id_projek`, `id_schedule`, `bobot_actual_kum`, `bobot_schedule_kum`, `acwp_kum`, `bcwp_kum`, `bcws_kum`, `cv`, `sv`, `cpi`, `spi`, `etc`, `eac`, `te`) VALUES
(21, 7, 24, 11, 20, 2400000, 1100000, 2000000, -1300000, -900000, 0.45833333333333, 0.55, 19418181.818182, 21818181.818182, 12.727272727273),
(22, 7, 25, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(23, 7, 26, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_foto`
--

CREATE TABLE `laporan_foto` (
  `id_foto` bigint(20) UNSIGNED NOT NULL,
  `id_laporan_pekerjaan` bigint(20) UNSIGNED DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `laporan_foto`
--

INSERT INTO `laporan_foto` (`id_foto`, `id_laporan_pekerjaan`, `foto`) VALUES
(21, 29, '16301552150.jpg'),
(22, 29, '16301552161.jpg'),
(23, 30, '16301553120.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_pekerjaan`
--

CREATE TABLE `laporan_pekerjaan` (
  `id_laporan_pekerjaan` bigint(20) UNSIGNED NOT NULL,
  `id_projek` bigint(20) UNSIGNED DEFAULT NULL,
  `id_schedule` bigint(20) UNSIGNED DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `bobot_actual` double DEFAULT 0,
  `bobot_schedule` double DEFAULT 0,
  `acwp` double DEFAULT 0,
  `bcwp` double DEFAULT 0,
  `bcws` double DEFAULT 0,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `laporan_pekerjaan`
--

INSERT INTO `laporan_pekerjaan` (`id_laporan_pekerjaan`, `id_projek`, `id_schedule`, `tgl`, `jam_mulai`, `jam_selesai`, `bobot_actual`, `bobot_schedule`, `acwp`, `bcwp`, `bcws`, `keterangan`) VALUES
(29, 7, 24, '2021-08-28', '08:00:00', '17:00:00', 5, 10, 1000000, 500000, 1000000, 'Baik Baik Saja'),
(30, 7, 24, '2021-08-29', '08:00:00', '17:00:00', 6, 10, 1400000, 600000, 1000000, 'Rugi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_pengeluaran`
--

CREATE TABLE `laporan_pengeluaran` (
  `id_laporan_pengeluaran` bigint(20) UNSIGNED NOT NULL,
  `id_projek` bigint(20) UNSIGNED DEFAULT NULL,
  `id_laporan_pekerjaan` bigint(20) UNSIGNED DEFAULT NULL,
  `rincian` varchar(255) DEFAULT NULL,
  `id_satuan` bigint(20) UNSIGNED DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `biaya` double DEFAULT NULL,
  `total_biaya` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `laporan_pengeluaran`
--

INSERT INTO `laporan_pengeluaran` (`id_laporan_pengeluaran`, `id_projek`, `id_laporan_pekerjaan`, `rincian`, `id_satuan`, `qty`, `biaya`, `total_biaya`) VALUES
(47, 7, 29, 'Transportasi', 2, 2, 500000, 1000000),
(48, 7, 30, 'Makan', 2, 2, 700000, 1400000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `jk` enum('L','P') DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `file_ktp` varchar(255) DEFAULT NULL,
  `file_asuransi` varchar(255) DEFAULT NULL,
  `file_foto` varchar(255) DEFAULT NULL,
  `id_jabatan` bigint(20) UNSIGNED DEFAULT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nama`, `jk`, `tempat_lahir`, `tgl_lahir`, `alamat`, `file_ktp`, `file_asuransi`, `file_foto`, `id_jabatan`, `id_user`, `deleted_at`) VALUES
(2, 'Administrator', 'L', 'Serang', '1991-10-24', 'Serang, Banten', 'KTP-1629660471.jpg', 'ASURANSI-1629660471.jpg', 'FOTO-1629660471.jpg', 3, 1, NULL),
(9, 'Mayudi', 'L', 'Serang', '1999-02-05', 'Serang', 'KTP-1630074390.jpg', 'ASURANSI-1630073816.jpg', 'FOTO-1630073816.jpg', 2, 7, NULL),
(10, 'Hambali', 'P', 'Ranjang', '1994-09-08', 'Kragilan', 'KTP-1630074720.jpg', 'ASURANSI-1630074720.jpg', 'FOTO-1630074720.jpg', 6, 8, NULL),
(11, 'Muhammad Dede Nuraen', 'L', 'Mushola', '1992-03-09', 'Serang', 'KTP-1630074849.jpg', 'ASURANSI-1630074849.jpg', 'FOTO-1630074849.jpg', 1, 9, NULL),
(12, 'Riwan', 'L', 'Padang Masyar', '1997-07-08', 'Ciruas', 'KTP-1630074957.jpg', 'ASURANSI-1630074957.jpg', 'FOTO-1630074957.jpg', 5, 10, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `projek`
--

CREATE TABLE `projek` (
  `id_projek` bigint(20) UNSIGNED NOT NULL,
  `id_vendor_pt` bigint(20) UNSIGNED DEFAULT NULL,
  `no_kontrak` char(20) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `tgl_kontrak` date DEFAULT current_timestamp(),
  `tgl_mulai` date DEFAULT current_timestamp(),
  `tgl_selesai` date DEFAULT current_timestamp(),
  `durasi_kontrak` int(11) DEFAULT NULL,
  `nilai_kontrak` double DEFAULT 0,
  `file_izin_kerja` varchar(255) DEFAULT NULL,
  `file_kontrak` varchar(255) DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `id_status` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `projek`
--

INSERT INTO `projek` (`id_projek`, `id_vendor_pt`, `no_kontrak`, `nama`, `tgl_kontrak`, `tgl_mulai`, `tgl_selesai`, `durasi_kontrak`, `nilai_kontrak`, `file_izin_kerja`, `file_kontrak`, `approved_by`, `id_status`) VALUES
(7, 1, 'SK/006/2021', 'Installasi Jaringan', '2021-08-27', '2021-08-28', '2021-09-03', 7, 10000000, 'Izin-Kerja-1630152421.jpg', 'Kontrak-1630152421.jpg', 11, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `projek_pegawai`
--

CREATE TABLE `projek_pegawai` (
  `id_projek_pegawai` bigint(20) UNSIGNED NOT NULL,
  `id_projek` bigint(20) UNSIGNED DEFAULT NULL,
  `id_pegawai` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `projek_pegawai`
--

INSERT INTO `projek_pegawai` (`id_projek_pegawai`, `id_projek`, `id_pegawai`) VALUES
(14, 7, 11),
(15, 7, 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_jabatan`
--

CREATE TABLE `ref_jabatan` (
  `id_jabatan` bigint(20) UNSIGNED NOT NULL,
  `jabatan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ref_jabatan`
--

INSERT INTO `ref_jabatan` (`id_jabatan`, `jabatan`) VALUES
(1, 'Direktur'),
(2, 'Manager'),
(3, 'Administrasi'),
(4, 'Finance'),
(5, 'Teknisi'),
(6, 'Helper');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_satuan`
--

CREATE TABLE `ref_satuan` (
  `id_satuan` bigint(20) UNSIGNED NOT NULL,
  `satuan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ref_satuan`
--

INSERT INTO `ref_satuan` (`id_satuan`, `satuan`) VALUES
(1, 'Unit'),
(2, 'Buah'),
(3, 'Pcs'),
(4, 'Batang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_status`
--

CREATE TABLE `ref_status` (
  `id_status` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `color` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ref_status`
--

INSERT INTO `ref_status` (`id_status`, `status`, `color`) VALUES
(1, 'Belum Approve', 'warning'),
(2, 'Sudah Approve', 'info'),
(3, 'Dalam Pengerjaan', 'primary'),
(4, 'Projek Selesai', 'success');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id_role` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id_role`, `role`) VALUES
(1, 'Super Admin'),
(2, 'Direktur'),
(3, 'Manager'),
(4, 'Finance'),
(5, 'Vendor'),
(6, 'Other');

-- --------------------------------------------------------

--
-- Struktur dari tabel `schedule`
--

CREATE TABLE `schedule` (
  `id_schedule` bigint(20) UNSIGNED NOT NULL,
  `id_projek` bigint(20) UNSIGNED DEFAULT NULL,
  `pekerjaan` varchar(255) DEFAULT NULL,
  `tgl_mulai` date DEFAULT current_timestamp(),
  `tgl_selesai` date DEFAULT current_timestamp(),
  `durasi_hari` int(11) DEFAULT NULL,
  `biaya` double DEFAULT NULL,
  `bobot_total` double DEFAULT NULL,
  `bobot_hari` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `schedule`
--

INSERT INTO `schedule` (`id_schedule`, `id_projek`, `pekerjaan`, `tgl_mulai`, `tgl_selesai`, `durasi_hari`, `biaya`, `bobot_total`, `bobot_hari`) VALUES
(24, 7, 'A', '2021-08-28', '2021-08-29', 2, 2000000, 20, 10),
(25, 7, 'B', '2021-08-30', '2021-09-01', 3, 4000000, 40, 13.333333333333),
(26, 7, 'C', '2021-09-02', '2021-09-03', 2, 4000000, 40, 20);

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_jalan`
--

CREATE TABLE `surat_jalan` (
  `no_surat_jalan` char(20) NOT NULL,
  `id_projek` bigint(20) UNSIGNED DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tgl_surat` date DEFAULT NULL,
  `file_surat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `surat_jalan`
--

INSERT INTO `surat_jalan` (`no_surat_jalan`, `id_projek`, `keterangan`, `tgl_surat`, `file_surat`) VALUES
('1630156217', 7, 'Contoh Surat Jalan', '2021-08-28', 'SJ-1630156217.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `image_profil` varchar(255) DEFAULT 'default.svg',
  `id_role` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `email`, `email_verified_at`, `password`, `image_profil`, `id_role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin@email.com', NULL, '$2y$10$P18mvy7lxK0BYc0Ia/mWjOe6zW5IgHTVentZp5rFLhje/vCYVA0T.', 'default.svg', 1, NULL, '2021-08-22 10:21:15', '2021-08-22 10:21:15'),
(5, 'vendor@email.com', NULL, '$2y$10$PsdYGsavjO2e4jj5CTouQOQTUNnBzJHJBwOefbOB3s1Kh02mN.m8a', 'default.svg', 5, NULL, '2021-08-22 10:21:15', '2021-08-22 10:21:15'),
(6, 'sapri@gmail.com', NULL, '$2y$10$wUCsV9NXnN1X2aVPlxGlSuiKn5yKSEvOlneKupLmjEi8VuEo51oki', 'default.svg', 5, NULL, '2021-08-22 20:53:25', '2021-08-22 20:59:49'),
(7, 'mayudi@email.com', NULL, '$2y$10$C.KmK/.HX.5baLdtdQiSB.MdCPjrvHc4D8h3LUEExqloRg9GZ0T8K', 'default.svg', 3, NULL, '2021-08-27 14:16:57', '2021-08-27 14:26:31'),
(8, 'hambali@email.com', NULL, '$2y$10$6qXJH.wSIlKmb2zon07HNedCm2.e26paGgIrFKtlpmhXTsJCuCeuK', 'default.svg', 4, NULL, '2021-08-27 14:32:00', '2021-08-27 14:38:02'),
(9, 'mdede@email.com', NULL, '$2y$10$8Dg2QO8AIJsMsw2JrkM7aOTAjaZgZBWmLPKv0Vl60T1wx2N/mFK9m', 'default.svg', 2, NULL, '2021-08-27 14:34:09', '2021-08-27 14:43:44'),
(10, 'riwan@email.com', NULL, '$2y$10$nP/HmUU4zgMQx/7esvscme.7NRW94h81oxQNyIfjxrJwgVwqo59t6', 'default.svg', 6, NULL, '2021-08-27 14:35:57', '2021-08-27 15:40:05'),
(11, 'manusiabiasa@email.com', NULL, '$2y$10$sOHPLTE5X7zAOcCxPanC7eT044JDb1pai.wDneKDJcC40U4cVRXfS', 'default.svg', 5, NULL, '2021-08-27 15:42:45', '2021-08-27 15:42:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vendor`
--

CREATE TABLE `vendor` (
  `id_vendor` bigint(20) UNSIGNED NOT NULL,
  `id_vendor_pt` bigint(20) UNSIGNED DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `telp` char(20) DEFAULT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `vendor`
--

INSERT INTO `vendor` (`id_vendor`, `id_vendor_pt`, `nama`, `telp`, `id_user`, `deleted_at`) VALUES
(1, 1, 'Sapri', '081295705677', 6, NULL),
(2, 1, 'Manusia Biasa', '98797070', 11, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `vendor_pt`
--

CREATE TABLE `vendor_pt` (
  `id_vendor_pt` bigint(20) UNSIGNED NOT NULL,
  `vendor` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `telp` char(20) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `vendor_pt`
--

INSERT INTO `vendor_pt` (`id_vendor_pt`, `vendor`, `alamat`, `telp`, `logo`, `deleted_at`) VALUES
(1, 'PT. INDONESIA', 'Suralaya Cilegon', '0846473', 'logo-1629663881.jpg', NULL),
(2, 'PLTU CILEGON', 'Cilegon', '8866', 'logo-1630078911.jpg', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `earned_value`
--
ALTER TABLE `earned_value`
  ADD PRIMARY KEY (`id_earned_value`),
  ADD KEY `id_projek` (`id_projek`),
  ADD KEY `id_plan` (`id_schedule`);

--
-- Indeks untuk tabel `laporan_foto`
--
ALTER TABLE `laporan_foto`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `id_laporan_pekerjaan` (`id_laporan_pekerjaan`);

--
-- Indeks untuk tabel `laporan_pekerjaan`
--
ALTER TABLE `laporan_pekerjaan`
  ADD PRIMARY KEY (`id_laporan_pekerjaan`),
  ADD KEY `id_plan` (`id_schedule`),
  ADD KEY `id_projek` (`id_projek`);

--
-- Indeks untuk tabel `laporan_pengeluaran`
--
ALTER TABLE `laporan_pengeluaran`
  ADD PRIMARY KEY (`id_laporan_pengeluaran`),
  ADD KEY `id_actual` (`id_laporan_pekerjaan`),
  ADD KEY `id_satuan` (`id_satuan`),
  ADD KEY `id_projek` (`id_projek`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indeks untuk tabel `projek`
--
ALTER TABLE `projek`
  ADD PRIMARY KEY (`id_projek`),
  ADD KEY `id_vendor` (`id_vendor_pt`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `id_status` (`id_status`);

--
-- Indeks untuk tabel `projek_pegawai`
--
ALTER TABLE `projek_pegawai`
  ADD PRIMARY KEY (`id_projek_pegawai`),
  ADD KEY `id_projek` (`id_projek`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indeks untuk tabel `ref_jabatan`
--
ALTER TABLE `ref_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indeks untuk tabel `ref_satuan`
--
ALTER TABLE `ref_satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indeks untuk tabel `ref_status`
--
ALTER TABLE `ref_status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id_schedule`),
  ADD KEY `id_projek` (`id_projek`);

--
-- Indeks untuk tabel `surat_jalan`
--
ALTER TABLE `surat_jalan`
  ADD PRIMARY KEY (`no_surat_jalan`),
  ADD KEY `id_projek` (`id_projek`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_role` (`id_role`);

--
-- Indeks untuk tabel `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id_vendor`),
  ADD KEY `id_vendor` (`id_vendor_pt`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `vendor_pt`
--
ALTER TABLE `vendor_pt`
  ADD PRIMARY KEY (`id_vendor_pt`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `earned_value`
--
ALTER TABLE `earned_value`
  MODIFY `id_earned_value` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `laporan_foto`
--
ALTER TABLE `laporan_foto`
  MODIFY `id_foto` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `laporan_pekerjaan`
--
ALTER TABLE `laporan_pekerjaan`
  MODIFY `id_laporan_pekerjaan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `laporan_pengeluaran`
--
ALTER TABLE `laporan_pengeluaran`
  MODIFY `id_laporan_pengeluaran` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `projek`
--
ALTER TABLE `projek`
  MODIFY `id_projek` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `projek_pegawai`
--
ALTER TABLE `projek_pegawai`
  MODIFY `id_projek_pegawai` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `ref_jabatan`
--
ALTER TABLE `ref_jabatan`
  MODIFY `id_jabatan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `ref_satuan`
--
ALTER TABLE `ref_satuan`
  MODIFY `id_satuan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `ref_status`
--
ALTER TABLE `ref_status`
  MODIFY `id_status` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id_role` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id_schedule` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id_vendor` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `vendor_pt`
--
ALTER TABLE `vendor_pt`
  MODIFY `id_vendor_pt` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `earned_value`
--
ALTER TABLE `earned_value`
  ADD CONSTRAINT `ev_projek` FOREIGN KEY (`id_projek`) REFERENCES `projek` (`id_projek`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ev_schedule` FOREIGN KEY (`id_schedule`) REFERENCES `schedule` (`id_schedule`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_foto`
--
ALTER TABLE `laporan_foto`
  ADD CONSTRAINT `laporan_foto` FOREIGN KEY (`id_laporan_pekerjaan`) REFERENCES `laporan_pekerjaan` (`id_laporan_pekerjaan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_pekerjaan`
--
ALTER TABLE `laporan_pekerjaan`
  ADD CONSTRAINT `pekerjaan_projek` FOREIGN KEY (`id_projek`) REFERENCES `projek` (`id_projek`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pekerjaan_schedule` FOREIGN KEY (`id_schedule`) REFERENCES `schedule` (`id_schedule`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_pengeluaran`
--
ALTER TABLE `laporan_pengeluaran`
  ADD CONSTRAINT `laporan_pengeluaran_ibfk_1` FOREIGN KEY (`id_satuan`) REFERENCES `ref_satuan` (`id_satuan`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `pengeluaran_pekerjaan` FOREIGN KEY (`id_laporan_pekerjaan`) REFERENCES `laporan_pekerjaan` (`id_laporan_pekerjaan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengeluaran_projek` FOREIGN KEY (`id_projek`) REFERENCES `projek` (`id_projek`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_jabatan` FOREIGN KEY (`id_jabatan`) REFERENCES `ref_jabatan` (`id_jabatan`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `pegawai_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `projek`
--
ALTER TABLE `projek`
  ADD CONSTRAINT `project_vendor` FOREIGN KEY (`id_vendor_pt`) REFERENCES `vendor_pt` (`id_vendor_pt`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projek_approve` FOREIGN KEY (`approved_by`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `projek_status` FOREIGN KEY (`id_status`) REFERENCES `ref_status` (`id_status`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ketidakleluasaan untuk tabel `projek_pegawai`
--
ALTER TABLE `projek_pegawai`
  ADD CONSTRAINT `projek_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `projek_projek` FOREIGN KEY (`id_projek`) REFERENCES `projek` (`id_projek`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_projek` FOREIGN KEY (`id_projek`) REFERENCES `projek` (`id_projek`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `surat_jalan`
--
ALTER TABLE `surat_jalan`
  ADD CONSTRAINT `surat_jalan_prpjek` FOREIGN KEY (`id_projek`) REFERENCES `projek` (`id_projek`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ketidakleluasaan untuk tabel `vendor`
--
ALTER TABLE `vendor`
  ADD CONSTRAINT `vendor_to_pt` FOREIGN KEY (`id_vendor_pt`) REFERENCES `vendor_pt` (`id_vendor_pt`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vendor_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
