-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jun 2026 pada 18.32
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
-- Database: `db_aulaundry`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `level` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `username`, `email`, `password`, `reset_token`, `level`, `created_at`, `updated_at`) VALUES
(1, 'Aul Cantik', 'superaul', NULL, '77eac10b06245a15f042688b7ca73248', NULL, 'Owner', '2026-06-09 13:16:05', '2026-06-09 13:16:05'),
(5, 'Haji Rizaldi', 'aldiganteng', NULL, '$2y$10$dTifSCSpZhviby7DqZs5/.C7iDsLuky7L1WKpJfo36q3tZfLeUybO', NULL, 'admin', '2026-06-12 14:16:04', '2026-06-12 14:16:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `posisi` varchar(50) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` text DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `status_aktif` varchar(20) NOT NULL DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `nama_karyawan`, `posisi`, `no_hp`, `alamat`, `foto_profil`, `username`, `password`, `reset_token`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Budi Garuk', 'Kasir', '081111111111', 'Palur', NULL, 'budigaruk', '9c5fa085ce256c7c598f6710584ab25d', NULL, 'Aktif', '2026-06-10 13:16:02', '2026-06-11 15:40:02'),
(2, 'Tante Ridwin', 'Manager', '080808080808', 'Magelang', NULL, 'tanteridwin', '$2y$10$1xhhpXKa/GD.M/XxfybTLusA9bjPBeUAzFT.sBla4JVdcD.1SpaZO', NULL, 'Aktif', '2026-06-10 13:19:54', '2026-06-12 15:17:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kurir`
--

CREATE TABLE `kurir` (
  `id_kurir` int(11) NOT NULL,
  `nama_kurir` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` text DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `lokasi_terakhir` point DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status_aktif` enum('Aktif','Nonaktif') DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kurir`
--

INSERT INTO `kurir` (`id_kurir`, `nama_kurir`, `no_hp`, `alamat`, `foto_profil`, `lokasi_terakhir`, `username`, `password`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Agus Cluster', '088888888888', 'Karangdowo', NULL, NULL, 'agusss', 'eb5f4940c71bd2e2f51798db4bcd673f', 'Aktif', '2026-06-10 13:04:11', '2026-06-10 13:05:04'),
(2, 'Mujib Khaer', '089999999999', 'Purwaji', NULL, NULL, 'jiebbb', '12286266448e3f804787f9213bfa3aa7', 'Aktif', '2026-06-10 13:04:56', '2026-06-10 13:04:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_keuangan`
--

CREATE TABLE `laporan_keuangan` (
  `id_laporan` int(11) NOT NULL,
  `periode` varchar(7) NOT NULL,
  `total_pendapatan` int(11) NOT NULL,
  `total_transaksi` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `alamat`, `no_hp`, `username`, `password`, `reset_token`, `created_at`, `updated_at`) VALUES
(1, 'Budi Speed', 'Palur', '08123456789', 'budisicepat', '9c5fa085ce256c7c598f6710584ab25d', NULL, '2026-06-10 05:45:24', '2026-06-11 15:11:39'),
(2, 'Suratmono', 'Pracimanuk', '08123456789', 'suratmono', 'ae18c01f0113ef91e2c48690fed337bc', NULL, '2026-06-10 06:36:46', '2026-06-10 06:36:46'),
(3, 'Cipung Ganteng', 'Sragen', '082222222222', 'cipung', '5e43c555feb974cd49aad4b3ee20781c', NULL, '2026-06-11 07:23:58', '2026-06-12 15:57:28'),
(4, 'Tukang Gali Kubur', 'TPU Pracimaluyo', '080000000000', 'galikubur', '72982353d0bad4dd35c5edf5a973eb00', NULL, '2026-06-12 14:19:17', '2026-06-12 14:19:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `permission_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `permissions`
--

INSERT INTO `permissions` (`id`, `permission_name`) VALUES
(3, 'manage_employees'),
(4, 'manage_finances'),
(2, 'manage_orders'),
(1, 'view_dashboard'),
(5, 'view_reports');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `no_pesanan` varchar(20) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_kurir` int(11) DEFAULT NULL,
  `jenis_layanan` varchar(50) NOT NULL,
  `berat_kg` decimal(5,1) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `metode_bayar` enum('Cash','E-Wallet') DEFAULT 'Cash',
  `status_laundry` enum('Menunggu','Diproses','Selesai') DEFAULT 'Menunggu',
  `status_piutang` enum('Lunas','Belum Lunas') DEFAULT 'Lunas',
  `tgl_masuk` timestamp NOT NULL DEFAULT current_timestamp(),
  `tgl_selesai` timestamp NULL DEFAULT NULL,
  `pesanan_diambil` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `jenis_waktu` varchar(20) NOT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `no_pesanan`, `id_pelanggan`, `id_kurir`, `jenis_layanan`, `berat_kg`, `total_bayar`, `metode_bayar`, `status_laundry`, `status_piutang`, `tgl_masuk`, `tgl_selesai`, `pesanan_diambil`, `created_at`, `updated_at`, `jenis_waktu`, `catatan`) VALUES
(13, 'AUL1781083726', 1, NULL, 'Lengkap', 7.0, 84000, 'Cash', 'Diproses', 'Belum Lunas', '2026-06-10 09:28:46', NULL, 0, '2026-06-10 09:28:46', '2026-06-10 09:28:46', 'Ekspres', NULL),
(14, 'AUL1781083751', 2, NULL, 'Bed Cover', 5.0, 45000, 'Cash', 'Selesai', 'Lunas', '2026-06-10 09:29:11', '2026-06-10 04:45:47', 1, '2026-06-10 09:29:11', '2026-06-10 09:45:47', 'Reguler', NULL),
(16, 'ORD-20260612-C4FB2', 3, NULL, 'Lengkap', 5.0, 60000, 'Cash', 'Selesai', 'Lunas', '2026-06-12 16:12:57', '2026-06-12 11:13:45', 0, '2026-06-12 16:12:57', '2026-06-12 16:13:45', 'Ekspres', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(4, 'Karyawan'),
(2, 'Kasir'),
(3, 'Kurir'),
(1, 'Owner');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_user`
--

CREATE TABLE `role_user` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `user_type` enum('admin','karyawan','kurir') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role_user`
--

INSERT INTO `role_user` (`id`, `user_id`, `role_id`, `user_type`) VALUES
(1, 1, 1, 'admin'),
(2, 2, 2, 'karyawan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tracking`
--

CREATE TABLE `tracking` (
  `id` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `kurir`
--
ALTER TABLE `kurir`
  ADD PRIMARY KEY (`id_kurir`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_name` (`permission_name`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD UNIQUE KEY `no_pesanan` (`no_pesanan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `idx_status_laundry` (`status_laundry`),
  ADD KEY `idx_tgl_masuk` (`tgl_masuk`),
  ADD KEY `idx_id_kurir` (`id_kurir`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indeks untuk tabel `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indeks untuk tabel `tracking`
--
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `kurir`
--
ALTER TABLE `kurir`
  MODIFY `id_kurir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `laporan_keuangan`
--
ALTER TABLE `laporan_keuangan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `role_user`
--
ALTER TABLE `role_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tracking`
--
ALTER TABLE `tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_kurir` FOREIGN KEY (`id_kurir`) REFERENCES `kurir` (`id_kurir`) ON DELETE SET NULL,
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tracking`
--
ALTER TABLE `tracking`
  ADD CONSTRAINT `tracking_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
