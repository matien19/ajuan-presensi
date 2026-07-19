-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 19, 2026 at 10:33 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ajuan_presensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `ajuan_presensi`
--

CREATE TABLE `ajuan_presensi` (
  `id_ajuan` int NOT NULL,
  `id_mahasiswa` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `id_kelas` int NOT NULL,
  `tanggal_kuliah` date NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci NOT NULL,
  `file_bukti` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status_ajuan` enum('Menunggu','Disetujui','Ditolak') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Menunggu',
  `catatan_admin` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ajuan_presensi`
--

INSERT INTO `ajuan_presensi` (`id_ajuan`, `id_mahasiswa`, `id_kelas`, `tanggal_kuliah`, `keterangan`, `file_bukti`, `status_ajuan`, `catatan_admin`, `created_at`) VALUES
(7, '42421033', 4, '2026-07-21', 'aaa', 'bukti_42421033_1784454127.png', 'Disetujui', NULL, '2026-07-19 16:42:07'),
(8, '42421033', 4, '2026-07-20', 'asda', 'bukti_42421033_1784454360.jpeg', 'Ditolak', NULL, '2026-07-19 16:46:00'),
(9, '42421033', 5, '2026-07-21', 'aaa', 'bukti_42421033_1784456787.jpg', 'Menunggu', NULL, '2026-07-19 17:26:27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dosen`
--

CREATE TABLE `tbl_dosen` (
  `nid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` text COLLATE utf8mb4_general_ci NOT NULL,
  `kontak` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `kelamin` varchar(1) COLLATE utf8mb4_general_ci NOT NULL,
  `stat` varchar(1) COLLATE utf8mb4_general_ci NOT NULL,
  `foto` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_dosen`
--

INSERT INTO `tbl_dosen` (`nid`, `nama`, `kontak`, `kelamin`, `stat`, `foto`) VALUES
('1233', 'aaaa', '4353234', 'P', 'A', ''),
('32432', 'aaa333', '2342233', 'L', 'T', 'template/img/dosen-32432-1783239826.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jurusan`
--

CREATE TABLE `tbl_jurusan` (
  `kode_jurusan` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_jurusan`
--

INSERT INTO `tbl_jurusan` (`kode_jurusan`, `nama`) VALUES
('A001', 'Informatika'),
('A002', 'Sistem Informasi'),
('aa', 'aa');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_klsmatkul`
--

CREATE TABLE `tbl_klsmatkul` (
  `Id` int NOT NULL,
  `nid` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `kode_matkul` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `kelas` varchar(3) COLLATE utf8mb4_general_ci NOT NULL,
  `kode_jurusan` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_klsmatkul`
--

INSERT INTO `tbl_klsmatkul` (`Id`, `nid`, `kode_matkul`, `kelas`, `kode_jurusan`) VALUES
(4, '1233', 'A1', 'A1', 'A001'),
(5, '32432', 'A3', 'aa', 'A001');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mahasiswa`
--

CREATE TABLE `tbl_mahasiswa` (
  `nim` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `kelamin` varchar(1) COLLATE utf8mb4_general_ci NOT NULL,
  `nohp` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `stat` varchar(1) COLLATE utf8mb4_general_ci NOT NULL,
  `foto` text COLLATE utf8mb4_general_ci NOT NULL,
  `kode_jurusan` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_mahasiswa`
--

INSERT INTO `tbl_mahasiswa` (`nim`, `nama`, `kelamin`, `nohp`, `stat`, `foto`, `kode_jurusan`) VALUES
('42421033', 'sss', 'P', 'ss22', 'T', '', 'A002'),
('42421079', 'safur', 'L', '45646', 'A', '', 'A001');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_matkul`
--

CREATE TABLE `tbl_matkul` (
  `Id` int NOT NULL,
  `kode_matkul` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_ind` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_eng` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sks` varchar(2) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_matkul`
--

INSERT INTO `tbl_matkul` (`Id`, `kode_matkul`, `nama_ind`, `nama_eng`, `sks`) VALUES
(1, 'A1', 'B. Indoneisa1', 'Indonesian language1', '2'),
(2, 'A2', 'B. Indoneisa2', 'Indonesian language2', '3'),
(3, 'A3', 'B. Indoneisa3', 'Indonesian language3', '3'),
(4, 'A4', 'B. Indoneisa4', 'Indonesian language4', '2'),
(5, 'A5', 'B. Indoneisa5', 'Indonesian language5', '2'),
(6, 'A6', 'B. Indoneisa6', 'Indonesian language6', '3'),
(7, 'A7', 'B. Indoneisa7', 'Indonesian language7', '2'),
(8, 'A8', 'B. Indoneisa8', 'Indonesian language8', '2');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `Id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `peran` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(200) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pengguna`
--

INSERT INTO `tbl_pengguna` (`Id`, `username`, `password`, `peran`, `nama`) VALUES
(105, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Admin', 'Admin'),
(389, 'admin1', '6c7ca345f63f835cb353ff15bd6c5e052ec08e7a', 'Admin', 'admin1'),
(390, 'aa', 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', 'Admin', 'aa'),
(391, '42421033', 'fbb567222775c6f30832e1113b6f6d87ff04a173', 'mhs', 'sss'),
(392, '42421033', 'fbb567222775c6f30832e1113b6f6d87ff04a173', 'mhs', 'sss'),
(393, '32432', 'ef36a25f2e942d6e0a50c2f4798443d6235112c7', 'dosen', 'aaa333'),
(394, '1233', 'cdd6dba996d0049e2a45b8615f6085ac3f8bc130', 'dosen', 'aaaa'),
(395, '42421079', '55354346abcf1451ce343fb1aa4cafaeed02907e', 'mhs', 'safur');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ajuan_presensi`
--
ALTER TABLE `ajuan_presensi`
  ADD PRIMARY KEY (`id_ajuan`),
  ADD KEY `idx_mahasiswa` (`id_mahasiswa`),
  ADD KEY `idx_kelas` (`id_kelas`),
  ADD KEY `idx_status` (`status_ajuan`);

--
-- Indexes for table `tbl_dosen`
--
ALTER TABLE `tbl_dosen`
  ADD PRIMARY KEY (`nid`);

--
-- Indexes for table `tbl_klsmatkul`
--
ALTER TABLE `tbl_klsmatkul`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_mahasiswa`
--
ALTER TABLE `tbl_mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `tbl_matkul`
--
ALTER TABLE `tbl_matkul`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ajuan_presensi`
--
ALTER TABLE `ajuan_presensi`
  MODIFY `id_ajuan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_klsmatkul`
--
ALTER TABLE `tbl_klsmatkul`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_matkul`
--
ALTER TABLE `tbl_matkul`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=396;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
