-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2021 at 06:35 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pengadilanbws`
--

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id_request` int(11) NOT NULL,
  `id_urequest` int(11) NOT NULL,
  `request` varchar(30) NOT NULL,
  `status` enum('1','2','3') NOT NULL,
  `id_leader` int(5) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id_request`, `id_urequest`, `request`, `status`, `id_leader`, `updated_at`) VALUES
(1, 1, 'sapu', '2', 27, '2021-03-28 08:37:42'),
(2, 1, 'deterjen', '2', 27, '2021-03-28 08:37:28'),
(3, 1, 'pel pelan', '2', 27, '2021-03-28 08:37:48'),
(4, 2, 'sapu lagi', '2', 27, '2021-03-28 08:53:44'),
(5, 2, 'sapu', '2', 27, '2021-03-28 08:53:37');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(3) NOT NULL,
  `room_name` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_name`) VALUES
(1, 'Ruang Wakil Ketua'),
(2, 'Ruang Pertemuan'),
(3, 'Ruang Cakim'),
(4, 'Ruang Panitera'),
(5, 'Ruang Panitera Pengganti+DYK'),
(6, 'Ruang Kamar Mandi Atas'),
(7, 'Ruang Sekretaris'),
(8, 'Ruang Hukum'),
(9, 'Ruang Ketua'),
(10, 'Ruang Hakim'),
(11, 'Ruang Perpustakaan'),
(12, 'Ruang Tahanan'),
(13, 'Ruang Kamar Mandi Barat(arsip) dan Taman(POT)'),
(15, 'PTSP'),
(16, 'Ruang Laktasi'),
(17, 'Ruang Mediasi dan taman(kolam)'),
(18, 'Ruang Sidang Utama'),
(19, 'Ruang Sidang 2(Barat)'),
(20, 'Ruang tunggu sidang'),
(21, 'Ruang Sidang Anak'),
(22, 'Ruang ramah anak'),
(23, 'Kamar mandi difabel'),
(24, 'Ruang Perdata'),
(25, 'Halaman belakang'),
(26, 'Halaman depan'),
(27, 'Taman bagian depan'),
(28, 'Ruang IT');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(6) NOT NULL,
  `task` text NOT NULL,
  `room_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `task`, `room_id`) VALUES
(1, 'Menyapu dan Mengepel lantai dengan cairan pembersih', 28),
(2, 'Mengosongkan tempat sampah', 28),
(3, 'Membersihkan/mengelap Meja dan Kursi', 28),
(4, 'Menata Meja dan Kursi ketempat semula', 28),
(5, 'Membersihkan langit-langit', 28),
(6, 'Membersihkan jendela dengan cairan pembersih', 28),
(7, 'Mematikan / Menghidupkan AC/kipas', 28),
(8, 'Mengecek fungsi saklar dan lampu', 28),
(9, 'Mengecek pengharum ruangan', 28);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(5) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(60) NOT NULL,
  `gender` enum('1','2') NOT NULL COMMENT '1.Laki-laki\r\n2.Perempuan',
  `id_role` int(2) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `active` enum('1','2') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `full_name`, `username`, `password`, `gender`, `id_role`, `nip`, `created_at`, `updated_at`, `active`) VALUES
(9, 'admin', 'admin', '$2y$10$0W.Z4oziqwgHw9w1rlEnAuM17buOaVE7c4i5SYIF0rNTmKlFd8OBi', '1', 1, '', '2021-03-04 08:29:09', '2021-03-04 15:29:09', '1'),
(13, 'Recky', 'recky', '$2y$10$xK6Hr.FKVTRkjSBAVDauJeSnVuBqwnbys956yGz2WNV9A.Qbhc.v6', '1', 2, '', '2021-03-04 04:24:36', NULL, '1'),
(14, 'Fajar', 'fajar', '$2y$10$xK6Hr.FKVTRkjSBAVDauJeSnVuBqwnbys956yGz2WNV9A.Qbhc.v6', '1', 2, '', '2021-03-04 04:24:36', NULL, '1'),
(15, 'Yudi', 'yudi', '$2y$10$xK6Hr.FKVTRkjSBAVDauJeSnVuBqwnbys956yGz2WNV9A.Qbhc.v6', '1', 2, '', '2021-03-04 04:24:36', NULL, '1'),
(16, 'Juhari', 'juhari', '$2y$10$xK6Hr.FKVTRkjSBAVDauJeSnVuBqwnbys956yGz2WNV9A.Qbhc.v6', '1', 2, '', '2021-03-04 04:24:36', NULL, '1'),
(17, 'Andre', 'andre', '$2y$10$xK6Hr.FKVTRkjSBAVDauJeSnVuBqwnbys956yGz2WNV9A.Qbhc.v6', '1', 2, '', '2021-03-04 04:24:36', NULL, '1'),
(18, 'Risma', 'risma', '$2y$10$xK6Hr.FKVTRkjSBAVDauJeSnVuBqwnbys956yGz2WNV9A.Qbhc.v6', '1', 2, '', '2021-03-04 04:24:36', NULL, '1'),
(19, 'Putri', 'putri', '$2y$10$xK6Hr.FKVTRkjSBAVDauJeSnVuBqwnbys956yGz2WNV9A.Qbhc.v6', '1', 2, '', '2021-03-04 04:24:36', NULL, '1'),
(20, 'Hasan', 'hasan', '$2y$10$xK6Hr.FKVTRkjSBAVDauJeSnVuBqwnbys956yGz2WNV9A.Qbhc.v6', '1', 2, '', '2021-03-04 04:37:52', '2021-03-04 11:37:52', '1'),
(21, 'Rendi', 'rendi', '$2y$10$xK6Hr.FKVTRkjSBAVDauJeSnVuBqwnbys956yGz2WNV9A.Qbhc.v6', '1', 2, '', '2021-03-04 04:24:36', NULL, '1'),
(22, 'Hisyam', 'hisyam', '$2y$10$xK6Hr.FKVTRkjSBAVDauJeSnVuBqwnbys956yGz2WNV9A.Qbhc.v6', '1', 2, '', '2021-03-04 04:24:36', NULL, '1'),
(23, 'Wawan', 'wawan', '$2y$10$xK6Hr.FKVTRkjSBAVDauJeSnVuBqwnbys956yGz2WNV9A.Qbhc.v6', '1', 2, '', '2021-03-04 04:24:36', NULL, '1'),
(24, 'Yuyut', 'yuyut', '$2y$10$xK6Hr.FKVTRkjSBAVDauJeSnVuBqwnbys956yGz2WNV9A.Qbhc.v6', '1', 2, '', '2021-03-04 04:24:36', NULL, '1'),
(25, 'Hesyim', 'hesyim', '$2y$10$xK6Hr.FKVTRkjSBAVDauJeSnVuBqwnbys956yGz2WNV9A.Qbhc.v6', '1', 2, '', '2021-03-04 04:24:36', NULL, '1'),
(26, 'Hendra', 'hendra', '$2y$10$D2yWF3avWShPx6jetlX5deGS2uQGbWBwVdB2JAgsYJV3fuz5sv8tm', '1', 2, '', '2021-03-04 06:47:08', NULL, '1'),
(27, 'Murti Triputranti. SE', 'murti', '$2y$10$wkfmp/huk.k/.oVgtio1S.Omua3zhL88AC72qOYuK1DYNqu207ETK', '1', 4, '198509302009122003', '2021-03-04 08:28:59', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_request`
--

CREATE TABLE `user_request` (
  `id_urequest` int(11) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `user_id` int(5) NOT NULL,
  `user_request_id` int(5) DEFAULT NULL,
  `room_id` int(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_request`
--

INSERT INTO `user_request` (`id_urequest`, `judul`, `user_id`, `user_request_id`, `room_id`, `created_at`) VALUES
(1, 'Permintaan sapu dan deterjen', 26, 26, 28, '2021-03-11 06:21:47'),
(2, 'z', 27, 13, 1, '2021-03-25 07:00:54');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id_role` int(2) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id_role`, `role_name`) VALUES
(1, 'admin'),
(2, 'petugas'),
(4, 'pimpinan'),
(5, 'keamanan');

-- --------------------------------------------------------

--
-- Table structure for table `user_room`
--

CREATE TABLE `user_room` (
  `user_room_id` int(11) NOT NULL,
  `user_id` int(5) NOT NULL,
  `room_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_room`
--

INSERT INTO `user_room` (`user_room_id`, `user_id`, `room_id`) VALUES
(1, 13, 1),
(2, 13, 2),
(3, 14, 2),
(4, 15, 2),
(5, 16, 2),
(6, 17, 2),
(7, 18, 2),
(8, 19, 2),
(9, 14, 3),
(10, 15, 4),
(11, 14, 5),
(12, 15, 6),
(14, 15, 7),
(15, 16, 10),
(16, 18, 8),
(17, 19, 9),
(18, 17, 11),
(19, 20, 12),
(20, 20, 13),
(21, 21, 15),
(22, 21, 16),
(23, 21, 17),
(24, 22, 18),
(25, 22, 19),
(26, 22, 20),
(27, 23, 21),
(28, 23, 22),
(29, 23, 23),
(30, 19, 24),
(31, 24, 25),
(32, 25, 26),
(33, 25, 27),
(34, 26, 28);

-- --------------------------------------------------------

--
-- Table structure for table `user_task`
--

CREATE TABLE `user_task` (
  `id_user_task` int(11) NOT NULL,
  `user_id` int(5) NOT NULL,
  `room_id` int(3) NOT NULL,
  `eviden` text DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `leader_id` int(5) DEFAULT NULL,
  `score` enum('1','2','3','4') NOT NULL COMMENT '1.putih\r\n2.merah\r\n3.kuning\r\n4.hijau',
  `deleted_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_task`
--

INSERT INTO `user_task` (`id_user_task`, `user_id`, `room_id`, `eviden`, `date`, `leader_id`, `score`, `deleted_at`) VALUES
(26, 26, 28, 'ig.png,marker.png,mbeek.jpg,phone.png', '2021-03-27 11:55:27', 27, '4', '2022-03-27'),
(32, 26, 28, 'mbeek.jpg', '2021-03-28 03:52:38', NULL, '1', '2022-03-28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id_request`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_request`
--
ALTER TABLE `user_request`
  ADD PRIMARY KEY (`id_urequest`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `user_room`
--
ALTER TABLE `user_room`
  ADD PRIMARY KEY (`user_room_id`);

--
-- Indexes for table `user_task`
--
ALTER TABLE `user_task`
  ADD PRIMARY KEY (`id_user_task`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user_request`
--
ALTER TABLE `user_request`
  MODIFY `id_urequest` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id_role` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_room`
--
ALTER TABLE `user_room`
  MODIFY `user_room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `user_task`
--
ALTER TABLE `user_task`
  MODIFY `id_user_task` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
