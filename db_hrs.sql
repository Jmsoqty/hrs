-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2024 at 08:50 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_hrs`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_housetypes`
--

CREATE TABLE `tbl_housetypes` (
  `housetype_id` int(11) NOT NULL,
  `housetype_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_housetypes`
--

INSERT INTO `tbl_housetypes` (`housetype_id`, `housetype_name`) VALUES
(2, 'Super Class A');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `e-wallet_value` double DEFAULT 0,
  `usertype` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `fullname`, `email`, `contact_number`, `username`, `password`, `e-wallet_value`, `usertype`, `date_created`) VALUES
(1, 'Admin', 'admin@gmail.com', '09661460661', 'admin', '21232f297a57a5a743894a0e4a801fc3', 0, 'admin', '2024-04-19 06:32:06'),
(2, 'hahaha', 'ahhahahha@gmail.com', NULL, 'ahahahh', 'f3823903b2dd6e35243b1bbe5a14f651', 0, 'client', '2024-04-19 06:45:17'),
(3, 'awdawdq', 'awadawdawda@gmail.com', '09306491215', 'dwadawdw', '7815c160047855d25071a66f5e172acd', 0, 'admin', '2024-04-19 06:47:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_housetypes`
--
ALTER TABLE `tbl_housetypes`
  ADD PRIMARY KEY (`housetype_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_housetypes`
--
ALTER TABLE `tbl_housetypes`
  MODIFY `housetype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
