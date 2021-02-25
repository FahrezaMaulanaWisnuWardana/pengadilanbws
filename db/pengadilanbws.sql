-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2021 at 11:58 PM
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
  `status` enum('1','2','3') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(3) NOT NULL,
  `room_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_name`) VALUES
(5, 'Ruang Sidang'),
(6, 'Toilet'),
(7, 'Ruang lobi'),
(8, 'test'),
(9, 'Halaman Depan');

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
(11, 'bersih berish', 9),
(12, 'bersih bersih lobi', 7),
(13, 'bersih bersih ruang sidang', 5),
(14, 'test', 5);

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
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `full_name`, `username`, `password`, `gender`, `id_role`, `nip`, `created_at`, `updated_at`) VALUES
(8, 'hasan', 'hasan', '$2y$10$0W.Z4oziqwgHw9w1rlEnAuM17buOaVE7c4i5SYIF0rNTmKlFd8OBi', '1', 2, '123', '2021-02-04 13:22:45', NULL),
(9, 'admin', 'admin', '$2y$10$0W.Z4oziqwgHw9w1rlEnAuM17buOaVE7c4i5SYIF0rNTmKlFd8OBi', '1', 1, '123', '2021-02-04 13:22:45', NULL),
(10, 'murti', 'murti', '$2y$10$UpU88CH7tLBz/uDGO8eDTOutw17fjuXJ0TP5zsjU6clQ2tl0jnFzK', '2', 4, '123', '2021-02-04 13:34:13', NULL),
(11, 'test', 'test', '$2y$10$RnQ6TXErJ48dZsbD0snRL.Cl3oFkkGownWkrYccjk7BcBFo.FaOS.', '1', 2, '', '2021-02-07 19:18:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_request`
--

CREATE TABLE `user_request` (
  `id_urequest` int(11) NOT NULL,
  `user_id` int(5) NOT NULL,
  `user_request_id` int(5) DEFAULT NULL,
  `room_id` int(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(12, 8, 5),
(13, 8, 7),
(14, 11, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user_task`
--

CREATE TABLE `user_task` (
  `id_user_task` int(11) NOT NULL,
  `user_id` int(5) NOT NULL,
  `room_id` int(3) NOT NULL,
  `task_id` int(6) NOT NULL,
  `eviden` text DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `leader_id` int(5) DEFAULT NULL,
  `score` enum('1','2','3','4') NOT NULL COMMENT '1.putih\r\n2.merah\r\n3.kuning\r\n4.hijau'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_task`
--

INSERT INTO `user_task` (`id_user_task`, `user_id`, `room_id`, `task_id`, `eviden`, `date`, `leader_id`, `score`) VALUES
(47, 8, 5, 13, 'marker.png,mbeek.jpg', '2021-02-24 09:58:19', NULL, '1'),
(48, 8, 5, 14, 'ig.png,marker.png,phone.png', '2021-02-24 09:59:35', NULL, '1'),
(49, 8, 7, 12, 'fb.png,ig.png,marker.png', '2021-02-24 12:24:43', NULL, '1'),
(50, 8, 5, 13, 'fb.png,ig.png,phone.png', '2021-02-25 20:39:15', 10, '3'),
(54, 8, 7, 12, 'fb.png,ig.png,marker.png,moo.jpg,phone.png', '2021-02-25 19:07:00', NULL, '1'),
(55, 8, 5, 14, 'mbeek.jpg,moo.jpg', '2021-02-25 22:36:58', 10, '4');

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
  MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_request`
--
ALTER TABLE `user_request`
  MODIFY `id_urequest` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id_role` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_room`
--
ALTER TABLE `user_room`
  MODIFY `user_room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_task`
--
ALTER TABLE `user_task`
  MODIFY `id_user_task` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
