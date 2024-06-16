-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 16, 2024 at 09:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mpl_hell`
--

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id` int(11) NOT NULL,
  `nama_divisi` varchar(50) DEFAULT NULL,
  `kode_divisi` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id`, `nama_divisi`, `kode_divisi`) VALUES
(1, 'Human Resources', 1001),
(2, 'Finance', 1002),
(3, 'IT', 1003),
(4, 'Marketing', 1004),
(5, 'Sales', 1005);

-- --------------------------------------------------------

--
-- Table structure for table `klasifikasi`
--

CREATE TABLE `klasifikasi` (
  `id` int(11) NOT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `nomor` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `klasifikasi`
--

INSERT INTO `klasifikasi` (`id`, `nama`, `nomor`, `status`) VALUES
(1, 'Type A', 1, 1),
(2, 'Type B', 2, 1),
(3, 'Type C', 3, 1),
(4, 'Type D', 4, 1),
(5, 'Type E', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `penerbit`
--

CREATE TABLE `penerbit` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_divisi` int(11) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `NIP` varchar(50) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `penerbit`
--

INSERT INTO `penerbit` (`id`, `id_user`, `id_divisi`, `nama`, `NIP`, `jabatan`, `status`) VALUES
(1, 1, 1, 'Alice Johnson', '1234567890', 'Manager', 1),
(2, 2, 2, 'Bob Smith', '2345678901', 'Accountant', 1),
(3, 3, 3, 'Carol White', '3456789012', 'IT Specialist', 1),
(4, 4, 4, 'David Brown', '4567890123', 'Marketing Lead', 1),
(5, 5, 5, 'Eve Black', '5678901234', 'Sales Executive', 1),
(6, 6, 2, 'Muhammad Hamdani', '2110010302', 'Kepala Seksi 2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id` int(11) NOT NULL,
  `id_penerbit` int(11) DEFAULT NULL,
  `id_tujuan` int(11) DEFAULT NULL,
  `id_jenis` int(11) DEFAULT NULL,
  `berlaku_dari` date DEFAULT NULL,
  `berlaku_sampai` date DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id`, `id_penerbit`, `id_tujuan`, `id_jenis`, `berlaku_dari`, `berlaku_sampai`, `detail`, `status`) VALUES
(1, 1, 2, 3, '2024-06-15', '2024-06-16', 'Lorem impsum goes here.', 0),
(2, 2, 2, 2, '2024-02-01', '2024-12-31', 'Details of Surat 2', 1),
(3, 3, 3, 3, '2024-03-01', '2024-12-31', 'Details of Surat 3', 1),
(5, 5, 5, 5, '2024-05-01', '2024-12-31', 'Details of Surat 5', 1),
(7, 6, 1, 1, '2024-06-15', '2024-06-16', 'Lorem ipsum whatever bullcrap.', 0),
(8, 6, 1, 1, '2024-06-15', '2024-06-16', 'Lorem ipsum whatever bullcrap.', 0),
(9, 6, 1, 1, '2024-06-06', '2024-06-07', 'Lorempumsum bullcrap', 0),
(10, 6, 1, 1, '2024-06-06', '2024-06-07', 'Lorempumsum bullcrap', 0),
(11, 6, 1, 1, '2024-05-05', '2024-05-05', 'Lorempumsum bullcrap', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tujuan`
--

CREATE TABLE `tujuan` (
  `id` int(11) NOT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `orang` varchar(50) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `institusi` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tujuan`
--

INSERT INTO `tujuan` (`id`, `alamat`, `orang`, `jabatan`, `institusi`, `status`) VALUES
(1, '123 Main St', 'John Doe', 'CEO', 'Company A', 1),
(2, '456 Elm St', 'Jane Roe', 'CFO', 'Company B', 1),
(3, '789 Pine St', 'Richard Roe', 'CTO', 'Company C', 1),
(4, '101 Maple St', 'John Smith', 'COO', 'Company D', 1),
(5, '202 Oak St', 'Jane Smith', 'CMO', 'Company E', 1),
(6, 'PPj', 'me', 'wallowing in sadness', 'my filthy room', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `status`, `level`) VALUES
(1, 'admin', 'admin', 1, 1),
(2, 'user', 'user', 0, 0),
(3, 'carol', 'password345', 0, 0),
(4, 'david', 'password456', 0, 0),
(5, 'eve', 'password567', 1, 2),
(6, 'pimpinan', 'pimpinan', 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `klasifikasi`
--
ALTER TABLE `klasifikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penerbit`
--
ALTER TABLE `penerbit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_divisi` (`id_divisi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tujuan` (`id_tujuan`),
  ADD KEY `id_penerbit` (`id_penerbit`),
  ADD KEY `id_jenis` (`id_jenis`);

--
-- Indexes for table `tujuan`
--
ALTER TABLE `tujuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `klasifikasi`
--
ALTER TABLE `klasifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penerbit`
--
ALTER TABLE `penerbit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tujuan`
--
ALTER TABLE `tujuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `penerbit`
--
ALTER TABLE `penerbit`
  ADD CONSTRAINT `penerbit_ibfk_1` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id`),
  ADD CONSTRAINT `penerbit_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Constraints for table `surat`
--
ALTER TABLE `surat`
  ADD CONSTRAINT `surat_ibfk_1` FOREIGN KEY (`id_tujuan`) REFERENCES `tujuan` (`id`),
  ADD CONSTRAINT `surat_ibfk_2` FOREIGN KEY (`id_penerbit`) REFERENCES `penerbit` (`id`),
  ADD CONSTRAINT `surat_ibfk_3` FOREIGN KEY (`id_jenis`) REFERENCES `klasifikasi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
