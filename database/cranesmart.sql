-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2020 at 09:40 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cranesmart`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member_wallet`
--

CREATE TABLE `tbl_member_wallet` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `wallet_display_id` text NOT NULL,
  `wallet_display_id_no` int(11) DEFAULT NULL,
  `wallet_balance` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_member_wallet`
--

INSERT INTO `tbl_member_wallet` (`id`, `member_id`, `wallet_display_id`, `wallet_display_id_no`, `wallet_balance`, `status`, `type`, `created`, `updated`) VALUES
(1, 19, 'CRNMW001', 1, 0, 1, 1, '2019-12-31 10:54:15', '0000-00-00 00:00:00'),
(2, 21, 'CRNMW002', 2, 0, 1, 1, '2019-12-31 14:14:30', '0000-00-00 00:00:00'),
(3, 22, 'CRNMW003', 3, 0, 1, 1, '2019-12-31 14:43:39', '0000-00-00 00:00:00'),
(4, 23, 'CRNMW004', 4, 0, 1, 1, '2019-12-31 14:56:12', '0000-00-00 00:00:00'),
(5, 24, 'CRNMW005', 5, 0, 1, 1, '2019-12-31 15:25:22', '0000-00-00 00:00:00'),
(6, 25, 'CRNMW006', 6, 0, 1, 1, '2019-12-31 15:27:57', '0000-00-00 00:00:00'),
(7, 26, 'CRNMW007', 7, 0, 1, 1, '2019-12-31 15:30:13', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `role_id` int(1) NOT NULL,
  `user_code` text NOT NULL,
  `user_code_no` int(11) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `decode_password` text NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile` varchar(25) DEFAULT NULL,
  `is_active` int(1) NOT NULL DEFAULT 0,
  `is_verified` int(11) DEFAULT NULL,
  `wallet_balance` float DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `role_id`, `user_code`, `user_code_no`, `name`, `username`, `password`, `decode_password`, `email`, `mobile`, `is_active`, `is_verified`, `wallet_balance`, `created_by`, `created`, `updated`) VALUES
(1, 1, '', 0, 'Admin', 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', 'cranesmart@gmail.com', '9672407007', 1, 1, NULL, NULL, '2019-12-21 11:41:19', '2019-12-30 12:10:08'),
(19, 2, 'CRNM001', 1, 'Ketan Jangid', 'CRNM001', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', 'ketanjangid1999@gmail.com', '8290660564', 1, 1, 0, 1, '2019-12-31 10:54:15', '2020-01-02 10:47:13'),
(21, 2, 'CRNM002', 2, 'Lakshya Gujrati', 'CRNM002', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', 'lakshya@gmail.com', '8619651646', 1, 1, 0, NULL, '2019-12-31 14:14:30', NULL),
(22, 2, 'CRNM003', 3, 'Himanshu Jhankal', 'CRNM003', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', 'himanshu@gmail.com', '8587888885', 1, 1, 0, NULL, '2019-12-31 14:43:39', NULL),
(23, 2, 'CRNM004', 4, 'Manish Kumar', 'CRNM004', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', 'manish@gmail.com', '8574859685', 1, 1, 0, NULL, '2019-12-31 14:56:12', NULL),
(24, 2, 'CRNM005', 5, 'Manoj kumar', 'CRNM005', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', 'manoj@gmail.com', '8748596587', 1, 1, 0, NULL, '2019-12-31 15:25:22', NULL),
(25, 2, 'CRNM006', 6, 'Vipul Kumar', 'CRNM006', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', 'vipul@gmail.com', '7458963625', 1, 1, 0, NULL, '2019-12-31 15:27:57', NULL),
(26, 2, 'CRNM007', 7, 'Anuj Kumar', 'CRNM007', '7c4a8d09ca3762af61e59520943dc26494f8941b', '123456', 'anuj@gmail.com', '8078612099', 1, 1, 0, NULL, '2019-12-31 15:30:13', '2019-12-31 17:56:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users_otp`
--

CREATE TABLE `tbl_users_otp` (
  `id` int(11) NOT NULL,
  `otp_code` int(11) DEFAULT NULL,
  `encrypt_otp_code` text DEFAULT NULL,
  `mobile` text NOT NULL,
  `status` int(11) DEFAULT NULL,
  `api_response` text NOT NULL,
  `json_post_data` text NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users_otp`
--

INSERT INTO `tbl_users_otp` (`id`, `otp_code`, `encrypt_otp_code`, `mobile`, `status`, `api_response`, `json_post_data`, `created`, `updated`) VALUES
(1, 6728, '80bf020381573d26001a1f3ad072d6accb602f62', '8619651646', 1, '396c456e6d37343330303033', '{\"siteUrl\":\"http:\\/\\/localhost\\/cranesmart\\/\",\"name\":\"Lakshya Gujrati\",\"email\":\"lakshya@gmail.com\",\"mobile\":\"8619651646\",\"password\":\"123456\"}', '2019-12-31 14:13:59', '0000-00-00 00:00:00'),
(2, 8633, '5eb422b39a69f7fec5c053501c62460114fa6e16', '9685756958', 0, '396c456e7642323937323934', '{\"siteUrl\":\"http:\\/\\/localhost\\/cranesmart\\/\",\"name\":\"Himanshu Jhankal\",\"email\":\"himanshu@gmail.com\",\"mobile\":\"9685756958\",\"password\":\"123456\"}', '2019-12-31 14:22:28', '0000-00-00 00:00:00'),
(3, 3965, 'efba2e3a199defca4f3115b2c81e2f9ae470dc97', '8078612099', 1, '396c456e4d6e333338383437', '{\"siteUrl\":\"http:\\/\\/localhost\\/cranesmart\\/\",\"name\":\"Himanshu Jhankal\",\"email\":\"himanshu@gmail.com\",\"mobile\":\"8078612099\",\"password\":\"123456\"}', '2019-12-31 14:39:14', '0000-00-00 00:00:00'),
(4, 8409, '2860a7ffe02c1f107b5f6f25660cdba5feed4e2c', '8078612099', 1, '396c456e3342343431323834', '{\"siteUrl\":\"http:\\/\\/localhost\\/cranesmart\\/\",\"name\":\"Manish Kumar\",\"email\":\"manish@gmail.com\",\"mobile\":\"8078612099\",\"password\":\"123456\"}', '2019-12-31 14:55:28', '0000-00-00 00:00:00'),
(5, 6441, '10a5fad164f122ccc309f3cd60d6a402b2094eef', '8078612099', 1, '396c456f7833343831323130', '{\"siteUrl\":\"http:\\/\\/localhost\\/cranesmart\\/\",\"name\":\"Manoj kumar\",\"email\":\"manoj@gmail.com\",\"mobile\":\"8078612099\",\"password\":\"123456\"}', '2019-12-31 15:24:55', '0000-00-00 00:00:00'),
(6, 8787, '88c74f68cb7a2b680835c9fca69e1002ed30f50b', '8078612099', 1, '396c456f414c313735313239', '{\"siteUrl\":\"http:\\/\\/localhost\\/cranesmart\\/\",\"name\":\"Vipul Kumar\",\"email\":\"vipul@gmail.com\",\"mobile\":\"8078612099\",\"password\":\"123456\"}', '2019-12-31 15:27:38', '0000-00-00 00:00:00'),
(7, 3503, '9e4e2c268ce949a8cc49f38f2223bebbb2a55481', '8078612099', 1, '396c456f4333393333333736', '{\"siteUrl\":\"http:\\/\\/localhost\\/cranesmart\\/\",\"name\":\"Anuj Kumar\",\"email\":\"anuj@gmail.com\",\"mobile\":\"8078612099\",\"password\":\"123456\"}', '2019-12-31 15:29:55', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_roles`
--

CREATE TABLE `tbl_user_roles` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `status` int(1) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_roles`
--

INSERT INTO `tbl_user_roles` (`id`, `title`, `status`, `created`, `updated`) VALUES
(1, 'Admin', 1, '2019-12-23 12:10:19', '0000-00-00 00:00:00'),
(2, 'Member', 1, '2019-12-23 12:10:45', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_member_wallet`
--
ALTER TABLE `tbl_member_wallet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users_otp`
--
ALTER TABLE `tbl_users_otp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_member_wallet`
--
ALTER TABLE `tbl_member_wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_users_otp`
--
ALTER TABLE `tbl_users_otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_user_roles`
--
ALTER TABLE `tbl_user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
