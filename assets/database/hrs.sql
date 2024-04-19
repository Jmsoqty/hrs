-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2024 at 10:51 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrs`
--

-- --------------------------------------------------------

--
-- Table structure for table `housetype`
--

CREATE TABLE `housetype` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `housetype`
--

INSERT INTO `housetype` (`id`, `category`) VALUES
(1, '2 story house'),
(2, 'villa'),
(3, 'duplex'),
(4, 'mansion'),
(5, 'asd'),
(6, 'asd'),
(7, 'sdfsdf'),
(8, 'sgdsgds'),
(9, 'sdfsdfs'),
(10, 'sdfsdfs'),
(11, 'sd');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_housetype`
--

CREATE TABLE `tbl_housetype` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `house_num` int(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `price` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_housetype`
--

INSERT INTO `tbl_housetype` (`id`, `house_num`, `category`, `description`, `price`) VALUES
(1, 1, 'first', 'solo', 1000),
(2, 1, 'first floor', 'solo', 0),
(3, 2, 'second floor', 'solo', 1500),
(4, 4, 'fourth floor', 'ewew', 2000),
(5, 4, 'fourth floor', 'ewew', 2000),
(6, 323, 'asada', 'sad', 23),
(7, 32, 'asdas', 'asdas', 23),
(8, 3123, 'awds', 'adsa', 23),
(9, 3123, 'awds', 'adsa', 23),
(10, 0, '32as', '232as', 23),
(11, 8, 'fffsf', 'sfsf', 22222),
(12, 634, 'villa', '218 galino st.', 50000),
(13, 6969, '2 story house', '218 galino st.', 15000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_fname` varchar(50) NOT NULL,
  `user_mname` varchar(50) NOT NULL,
  `user_lname` varchar(50) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_pass` varchar(50) NOT NULL,
  `user_type` int(11) NOT NULL DEFAULT 0,
  `isActivated` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_fname`, `user_mname`, `user_lname`, `user_name`, `user_pass`, `user_type`, `isActivated`) VALUES
(1, 'f', 'm', 'l', 'u', '83878c91171338902e0fe0fb97a8c47a', 0, 0),
(2, 'Denver', 'Valbarez', 'Cunanan', 'denver', '52e17699cd757e43021c053b456014c6', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE `usertype` (
  `id` int(11) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(200) NOT NULL,
  `usertype` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `housetype`
--
ALTER TABLE `housetype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_housetype`
--
ALTER TABLE `tbl_housetype`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `usertype`
--
ALTER TABLE `usertype`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `housetype`
--
ALTER TABLE `housetype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_housetype`
--
ALTER TABLE `tbl_housetype`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usertype`
--
ALTER TABLE `usertype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
