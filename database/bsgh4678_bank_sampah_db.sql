-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 16, 2026 at 08:11 PM
-- Server version: 11.4.10-MariaDB-cll-lve
-- PHP Version: 8.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bsgh4678_bank_sampah_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_nasabah` int(11) NOT NULL,
  `nama_nasabah` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `no_wa` varchar(15) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_nasabah`, `nama_nasabah`, `alamat`, `no_wa`, `tanggal`) VALUES
(11, 'Panitia', 'BS green cikeas', '08932831313', '2026-05-13'),
(12, 'admin BS', 'Green Cikeas', '08123238238', '2026-05-25'),
(26, 'DINI HUSAINI', 'KP. SANDING 2, RT10/05, KEL.BOJONG NANGKA, KEC. GUNUNG PUTRI, KAB.BOGOR, JAWA BARAT.', '', '2026-06-15'),
(27, 'Arya Irfan', 'Leuwinanggung RT 001 RW 010', '', '2026-06-15'),
(28, 'silvy', 'ciangsana', '', '2026-06-15'),
(29, 'Ellyza', 'Klapanunggal', '0883728882', '2026-06-15'),
(30, 'Ellyza ', 'Klapanunggal ', '085811985025', '2026-06-16'),
(31, 'Ellyza', 'Klapanunggal', '0883728882', '2026-06-16'),
(32, 'Isil', 'Vila 5', '081221694905', '2026-06-16');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_sampah`
--

CREATE TABLE `jenis_sampah` (
  `id_jenis` int(11) NOT NULL,
  `nama_jenis` varchar(50) NOT NULL,
  `harga_per_kg` decimal(10,2) NOT NULL,
  `harga_nasabah` decimal(10,2) NOT NULL,
  `harga_pengepul` decimal(10,2) NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_sampah`
--

INSERT INTO `jenis_sampah` (`id_jenis`, `nama_jenis`, `harga_per_kg`, `harga_nasabah`, `harga_pengepul`, `gambar`) VALUES
(1, 'Pet A', 3000.00, 3000.00, 3700.00, 'pet_a.jpg'),
(2, 'Karung', 1000.00, 500.00, 1000.00, 'karung.jpg'),
(3, 'Asoy', 800.00, 400.00, 800.00, 'asoy.jpg'),
(5, 'Kardus', 1750.00, 1000.00, 1750.00, 'kardus.jpg'),
(6, 'Besi', 3800.00, 3000.00, 3800.00, 'besi.jpg'),
(7, 'Gelas A', 4500.00, 4000.00, 4500.00, 'gelasa.jpg'),
(8, 'Slopan', 3000.00, 2000.00, 3000.00, 'slopan.jpg'),
(9, 'Duplek', 600.00, 300.00, 600.00, 'duplek.jpg'),
(10, 'Beling', 2000.00, 1000.00, 2000.00, 'beling.jpg'),
(11, 'Tutup', 1000.00, 500.00, 1000.00, 'tutup.jpg'),
(12, 'Emberan', 1600.00, 1000.00, 1600.00, 'emberan.jpg'),
(13, 'Seng', 1500.00, 1000.00, 1500.00, 'seng.jpg'),
(14, 'Kaleng', 2000.00, 1000.00, 2000.00, 'kaleng.jpg'),
(15, 'Jelantah', 5000.00, 2500.00, 5000.00, 'jelantah.jpg'),
(16, 'Kabel', 1000.00, 500.00, 1000.00, 'kabel.jpg'),
(17, 'Buku', 1500.00, 1000.00, 1500.00, 'buku.jpg'),
(18, 'Kertas', 1000.00, 500.00, 1000.00, 'kertas.jpg'),
(20, 'gabruk', 0.00, 0.00, 0.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `kehadiran_penimbangan`
--

CREATE TABLE `kehadiran_penimbangan` (
  `id_kehadiran` int(11) NOT NULL,
  `id_nasabah` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penimbangan`
--

CREATE TABLE `penimbangan` (
  `id_penimbangan` int(11) NOT NULL,
  `id_nasabah` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `berat` decimal(5,2) NOT NULL,
  `status` enum('normal','gabruk') NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sesi_absensi`
--

CREATE TABLE `sesi_absensi` (
  `id_sesi` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `kode_qr` varchar(100) DEFAULT NULL,
  `status` enum('aktif','selesai') DEFAULT 'aktif',
  `dibuat` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sesi_absensi`
--

INSERT INTO `sesi_absensi` (`id_sesi`, `tanggal`, `kode_qr`, `status`, `dibuat`) VALUES
(3, '2026-06-16', 'BS20260616141447', 'selesai', '2026-06-16 14:14:47'),
(4, '2026-06-16', 'BS20260616141452', 'selesai', '2026-06-16 14:14:52'),
(5, '2026-06-16', 'BS20260616190448', 'selesai', '2026-06-16 19:04:48'),
(6, '2026-06-16', 'BS20260616190715', 'selesai', '2026-06-16 19:07:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_users` varchar(25) NOT NULL,
  `username_users` varchar(25) NOT NULL,
  `password_users` varchar(25) NOT NULL,
  `role` enum('admin','nasabah') NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `otp_expired` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_users`, `username_users`, `password_users`, `role`, `email`, `otp`, `otp_expired`) VALUES
(5, 'adminbscikeas', 'bscikeas', '13579', 'admin', NULL, NULL, NULL),
(13, 'isil', 'vvisill', '1717', 'nasabah', NULL, NULL, NULL),
(14, 'Dini Husaini', 'dinihsnn', '09876', 'nasabah', 'dinihusaini2312@gmail.com', NULL, NULL),
(15, 'Putri', 'ptrrr', '123', 'nasabah', NULL, NULL, NULL),
(16, 'Juan', 'Saya', '123', 'nasabah', NULL, NULL, NULL),
(17, 'DINI HUSAINI', 'dininyun', '09876', 'nasabah', 'dinidragster58@gmail.com', NULL, NULL),
(18, 'Arya Irfan', 'Arya Irfan', 'aryairfan123', 'nasabah', 'aryairfan13@gmail.com', NULL, NULL),
(19, 'silvy', 'isilll', '1234', 'nasabah', 'silvi@gmail.com', NULL, NULL),
(20, 'Ellyza', 'ell', '12345', 'nasabah', 'ellyza@gmail.com', NULL, NULL),
(21, 'Ellyza ', 'Ell', '111', 'nasabah', 'ellyzajnnnnn@gmail.com', NULL, NULL),
(22, 'Isil', 'isilaja', '1717', 'nasabah', 'afriliasilvy@gmail.com', '169483', '2026-06-16 12:23:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_nasabah`);

--
-- Indexes for table `jenis_sampah`
--
ALTER TABLE `jenis_sampah`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `kehadiran_penimbangan`
--
ALTER TABLE `kehadiran_penimbangan`
  ADD PRIMARY KEY (`id_kehadiran`);

--
-- Indexes for table `penimbangan`
--
ALTER TABLE `penimbangan`
  ADD PRIMARY KEY (`id_penimbangan`);

--
-- Indexes for table `sesi_absensi`
--
ALTER TABLE `sesi_absensi`
  ADD PRIMARY KEY (`id_sesi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_nasabah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `jenis_sampah`
--
ALTER TABLE `jenis_sampah`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `kehadiran_penimbangan`
--
ALTER TABLE `kehadiran_penimbangan`
  MODIFY `id_kehadiran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `penimbangan`
--
ALTER TABLE `penimbangan`
  MODIFY `id_penimbangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `sesi_absensi`
--
ALTER TABLE `sesi_absensi`
  MODIFY `id_sesi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
