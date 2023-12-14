-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2023 at 11:40 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parapoia_hotel_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`, `email`, `name`) VALUES
(1, 'admin', 'admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE `audit` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `action_taken` text DEFAULT NULL,
  `date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit`
--

INSERT INTO `audit` (`id`, `user_id`, `user_name`, `action_taken`, `date`) VALUES
(1, '1', 'user', 'Logged on', '2023-11-22 19:35:09'),
(2, '1', 'user', 'Add to cart service with service ID: 2', '2023-11-22 19:36:42'),
(3, '1', 'user', 'Add to cart service with service ID: 4', '2023-11-22 19:36:46'),
(4, '1', 'user', 'Add to cart room reservation with room ID: 12', '2023-11-22 19:39:19'),
(5, '1', 'user', 'Add to cart service with service ID: 2', '2023-11-22 19:45:05'),
(6, '1', 'user', 'Add to cart room reservation with room ID: 13', '2023-11-22 19:45:13'),
(7, '1', 'user', 'Used PROMO with promo code: CODE123', '2023-11-22 19:45:18'),
(8, '1', 'user', 'Guest attempt to access gcash gateway to pay full payment', '2023-11-22 19:46:01'),
(9, '1', 'user', 'Guest paid its reservation with reservation ID: 156 thru Gcash, payment reference #: 724572718', '2023-11-22 19:46:10'),
(10, '1', 'user', 'Guest paid its reservation with reservation ID: 157 thru Gcash, payment reference #: 724572718', '2023-11-22 19:46:10'),
(11, '1', 'user', 'Guest paid its reservation with reservation ID: 158 thru Gcash, payment reference #: 724572718', '2023-11-22 19:46:10'),
(12, '1', 'user', 'Guest paid its reservation with reservation ID: 159 thru Gcash, payment reference #: 724572718', '2023-11-22 19:46:11'),
(13, '1', 'user', 'Guest paid its reservation with reservation ID: 160 thru Gcash, payment reference #: 724572718', '2023-11-22 19:46:11'),
(14, '1', 'user', 'Guest paid its reservation with reservation ID: 161 thru Gcash, payment reference #: 724572718', '2023-11-22 19:46:11'),
(15, '', '', 'Logged on', '2023-11-22 19:48:43'),
(16, '1', 'admin', 'Logged on', '2023-11-22 19:49:42'),
(17, '', '', 'Update room with ID: 12 status to 0', '2023-11-22 19:55:42'),
(18, '', '', 'Update room with ID: 12 status to 1', '2023-11-22 19:55:44'),
(19, '1', 'admin', 'Update room with ID: 12 status to 0', '2023-11-22 19:58:08'),
(20, '1', 'admin', 'Update room with ID: 12 status to 1', '2023-11-22 19:58:10'),
(21, '1', 'user', 'Logged on', '2023-11-22 20:27:34'),
(22, '1', 'user', 'Add to cart service with service ID: 2', '2023-11-22 20:28:14'),
(23, '1', 'user', 'Used PROMO with promo code: CODE123', '2023-11-22 20:28:30'),
(24, '1', 'user', 'Guest attempt to access gcash gateway to pay full payment', '2023-11-22 20:28:38'),
(25, '1', 'user', 'Guest paid its reservation with reservation ID: 162 thru Gcash, payment reference #: 885857521', '2023-11-22 20:29:01'),
(26, '1', 'user', 'Add to cart room reservation with room ID: 13', '2023-11-22 20:29:43'),
(27, '1', 'user', 'Guest attempt to access gcash gateway to pay down payment', '2023-11-22 20:29:48'),
(28, '1', 'user', 'Guest paid its reservation with reservation ID: 163 thru Gcash, payment reference #: 286166114', '2023-11-22 20:29:59'),
(29, '1', 'admin', 'Logged on', '2023-11-22 20:32:39'),
(30, '1', 'user', 'Logged on', '2023-11-29 19:29:42'),
(31, '1', 'user', 'Add to cart service with service ID: 2', '2023-11-29 19:31:04'),
(32, '1', 'user', 'User delete its reservation with reservation ID: 164 from reservations cart.', '2023-11-29 19:31:06'),
(33, '1', 'user', 'Add to cart room reservation with room ID: 12', '2023-11-29 19:40:30'),
(34, '1', 'user', 'User delete its reservation with reservation ID: 165 from reservations cart.', '2023-11-29 19:40:41'),
(35, '1', 'user', 'Add to cart room reservation with room ID: 12', '2023-11-29 19:40:52'),
(36, '1', 'user', 'User delete its reservation with reservation ID: 166 from reservations cart.', '2023-11-29 19:41:27'),
(37, '1', 'admin', 'Logged on', '2023-11-29 22:24:18'),
(38, '1', 'user', 'Logged on', '2023-11-29 22:28:37'),
(39, '1', 'user', 'Add to cart room reservation with room ID: 12', '2023-11-29 22:28:50'),
(40, '1', 'user', 'Add to cart service with service ID: 2', '2023-11-29 22:41:01'),
(41, '1', 'user', 'User delete its reservation with reservation ID: 168 from reservations cart.', '2023-11-29 22:41:05'),
(42, '1', 'user', 'Used PROMO with promo code: CODE123', '2023-11-29 22:41:09'),
(43, '1', 'user', 'Guest paid its reservation with reservation ID: 167 thru Gcash, payment reference #: 084249471', '2023-11-29 22:46:19'),
(44, '1', 'user', 'Add to cart service with service ID: 2', '2023-11-29 22:47:40'),
(45, '1', 'user', 'Guest paid its reservation with reservation ID: 169 thru Gcash, payment reference #: 552489598', '2023-11-29 22:47:47'),
(46, '1', 'user', 'Add to cart service with service ID: 2', '2023-11-29 22:48:04'),
(47, '1', 'user', 'Guest paid its reservation with reservation ID: 170 thru Gcash, payment reference #: 992094562', '2023-11-29 22:48:09'),
(48, '1', 'user', 'Add to cart service with service ID: 2', '2023-11-29 22:48:57'),
(49, '1', 'user', 'Used PROMO with promo code: CODE123', '2023-11-29 22:49:02'),
(50, '1', 'user', 'Guest paid its reservation with reservation ID: 171 thru Gcash, payment reference #: 053734668', '2023-11-29 22:49:06'),
(51, '1', 'user', 'Add to cart service with service ID: 2', '2023-11-29 23:02:47'),
(52, '1', 'user', 'Add to cart service with service ID: 3', '2023-11-30 00:31:17'),
(53, '1', 'user', 'Guest paid its reservation with reservation ID: 172 thru Gcash, payment reference #: 053734661', '2023-11-30 00:32:42'),
(54, '1', 'user', 'Guest paid its reservation with reservation ID: 173 thru Gcash, payment reference #: 053734661', '2023-11-30 00:32:43'),
(55, '1', 'user', 'Add to cart room reservation with room ID: 13', '2023-11-30 00:33:31'),
(56, '1', 'user', 'Used PROMO with promo code: CODE123', '2023-11-30 00:33:37'),
(57, '1', 'user', 'Guest paid its reservation with reservation ID: 174 thru Gcash, payment reference #: 22233423', '2023-11-30 00:33:47'),
(58, '1', 'user', 'Add to cart room reservation with room ID: 14', '2023-11-30 00:53:13'),
(59, '1', 'user', 'Add to cart room reservation with room ID: 15', '2023-11-30 00:54:15'),
(60, '1', 'user', 'Add to cart room reservation with room ID: 16', '2023-11-30 06:12:15'),
(61, '1', 'user', 'User delete its reservation with reservation ID: 177 from reservations cart.', '2023-11-30 06:12:30'),
(62, '1', 'user', 'User delete its reservation with reservation ID: 176 from reservations cart.', '2023-11-30 06:12:31'),
(63, '1', 'user', 'Add to cart room reservation with room ID: 20', '2023-11-30 06:22:13'),
(64, '1', 'admin', 'Logged on', '2023-11-30 06:22:58'),
(65, '', '', 'Logged Out', '2023-11-30 06:45:56'),
(66, '1', 'user', 'Logged on', '2023-11-30 06:46:02'),
(67, '1', 'user', 'User delete its reservation with reservation ID: 175 from reservations cart.', '2023-11-30 06:58:44'),
(68, '1', 'user', 'User delete its reservation with reservation ID: 178 from reservations cart.', '2023-11-30 07:02:33'),
(69, '1', 'user', 'Add to cart room reservation with room ID: 14', '2023-11-30 07:02:43'),
(70, '1', 'user', 'Add to cart room reservation with room ID: 16', '2023-11-30 07:24:06'),
(71, '1', 'user', 'Add to cart room reservation with room ID: 12', '2023-11-30 13:51:26'),
(72, '1', 'user', 'User delete its reservation with reservation ID: 179 from reservations cart.', '2023-11-30 15:32:30'),
(73, '1', 'user', 'Add to cart room reservation with room ID: 12', '2023-11-30 15:32:41'),
(74, '1', 'user', 'Used PROMO with promo code: CODE123', '2023-11-30 15:34:42'),
(75, '1', 'user', 'User delete its reservation with reservation ID: 182 from reservations cart.', '2023-11-30 15:34:44'),
(76, '1', 'user', 'Add to cart room reservation with room ID: 12', '2023-11-30 15:35:53'),
(77, '1', 'user', 'User delete its reservation with reservation ID: 183 from reservations cart.', '2023-11-30 15:36:00'),
(78, '1', 'user', 'Add to cart room reservation with room ID: 12', '2023-11-30 15:36:10'),
(79, '1', 'user', 'Used PROMO with promo code: CODE123', '2023-11-30 15:36:17'),
(80, '1', 'user', 'Used PROMO with promo code: CODE123', '2023-11-30 15:36:55'),
(81, '1', 'user', 'User delete its reservation with reservation ID: 184 from reservations cart.', '2023-11-30 15:37:30'),
(82, '1', 'user', 'Add to cart room reservation with room ID: 12', '2023-11-30 15:37:39'),
(83, '1', 'user', 'Used PROMO with promo code: code123', '2023-11-30 15:37:49'),
(84, '1', 'user', 'Guest paid its reservation with reservation ID: 185 thru Gcash, payment reference #: 22233423', '2023-11-30 15:38:01'),
(85, '1', 'user', 'Add to cart room reservation with room ID: 13', '2023-11-30 15:50:07'),
(86, '1', 'user', 'Used PROMO with promo code: CODE123', '2023-11-30 15:50:12'),
(87, '1', 'user', 'Guest paid its reservation with reservation ID: 186 thru Gcash, payment reference #: 123123123', '2023-11-30 15:50:18'),
(88, '1', 'user', 'Add to cart room reservation with room ID: 12', '2023-11-30 15:52:31'),
(89, '1', 'user', 'Guest paid its reservation with reservation ID: 187 thru Gcash, payment reference #: AAASDASD', '2023-11-30 15:52:43'),
(90, '1', 'user', 'Logged on', '2023-11-30 15:52:56'),
(91, '1', 'user', 'Add to cart room reservation with room ID: 13', '2023-11-30 15:53:59'),
(92, '1', 'user', 'Guest paid its reservation with reservation ID: 188 thru Gcash, payment reference #: 123123123', '2023-11-30 15:54:09'),
(93, '1', 'user', 'Add to cart service with service ID: 2', '2023-11-30 15:55:41'),
(94, '1', 'user', 'Guest paid its reservation with reservation ID: 189 thru Gcash, payment reference #: 22233423333', '2023-11-30 15:55:47'),
(95, '1', 'user', 'Add to cart room reservation with room ID: 17', '2023-11-30 15:56:08'),
(96, '1', 'user', 'Guest paid its reservation with reservation ID: 190 thru Gcash, payment reference #: 333233', '2023-11-30 15:56:14'),
(97, '1', 'user', 'Add to cart room reservation with room ID: 12', '2023-11-30 16:02:51'),
(98, '1', 'user', 'Used PROMO with promo code: CODE123', '2023-11-30 16:03:06'),
(99, '1', 'user', 'Guest paid its reservation with reservation ID: 191 thru Gcash, payment reference #: 66662323', '2023-11-30 16:03:13'),
(100, '1', 'user', 'Add to cart service with service ID: 2', '2023-11-30 16:04:33'),
(101, '1', 'user', 'Add to cart service with service ID: 3', '2023-11-30 16:04:37'),
(102, '1', 'user', 'Add to cart room reservation with room ID: 12', '2023-11-30 16:04:46'),
(103, '1', 'user', 'Add to cart room reservation with room ID: 13', '2023-11-30 16:04:59'),
(104, '1', 'user', 'User delete its reservation with reservation ID: 195 from reservations cart.', '2023-11-30 16:10:09'),
(105, '1', 'user', 'Add to cart room reservation with room ID: 21', '2023-11-30 16:10:22'),
(106, '1', 'user', 'Used PROMO with promo code: CODE123', '2023-11-30 16:18:16'),
(107, '1', 'user', 'Guest paid its reservation with reservation ID: 192 thru Gcash, payment reference #: AASD2232323', '2023-11-30 16:18:22'),
(108, '1', 'user', 'Guest paid its reservation with reservation ID: 193 thru Gcash, payment reference #: AASD2232323', '2023-11-30 16:18:22'),
(109, '1', 'user', 'Guest paid its reservation with reservation ID: 194 thru Gcash, payment reference #: AASD2232323', '2023-11-30 16:18:23'),
(110, '1', 'user', 'Guest paid its reservation with reservation ID: 196 thru Gcash, payment reference #: AASD2232323', '2023-11-30 16:18:23'),
(111, '1', 'user', 'Add to cart service with service ID: 2', '2023-11-30 16:19:41'),
(112, '1', 'user', 'Guest paid its reservation with reservation ID: 197 thru Gcash, payment reference #: 331112233', '2023-11-30 16:19:47'),
(113, '1', 'admin', 'Logged on', '2023-11-30 16:20:09'),
(114, '1', 'admin', 'Added service with descriptionAmenities', '2023-11-30 16:29:19'),
(115, '1', 'admin', 'Logged on', '2023-11-30 16:44:08'),
(116, '1', 'admin', 'Update the status of reservation ID: 196 to Approved', '2023-11-30 16:45:33'),
(117, '1', 'admin', 'Update the status of reservation ID: 194 to Approved', '2023-11-30 16:45:35'),
(118, '1', 'user', 'Logged on', '2023-11-30 17:02:30'),
(119, '1', 'user', 'Add to cart room reservation with room ID: 13', '2023-11-30 17:02:39'),
(120, '1', 'user', 'Add to cart room reservation with room ID: 13', '2023-11-30 17:02:57'),
(121, '1', 'user', 'Add to cart room reservation with room ID: 14', '2023-11-30 17:03:21'),
(122, '1', 'user', 'User delete its reservation with reservation ID: 199 from reservations cart.', '2023-11-30 17:03:30'),
(123, '1', 'user', 'User delete its reservation with reservation ID: 198 from reservations cart.', '2023-11-30 17:03:31'),
(124, '1', 'user', 'Guest paid its reservation with reservation ID: 200 thru Gcash, payment reference #: TEST1', '2023-11-30 17:03:37'),
(125, '1', 'user', 'Add to cart room reservation with room ID: 15', '2023-11-30 17:03:55'),
(126, '1', 'user', 'Guest paid its reservation with reservation ID: 201 thru Gcash, payment reference #: TEST2', '2023-11-30 17:04:00'),
(127, '1', 'user', 'Add to cart room reservation with room ID: 20', '2023-11-30 17:04:22'),
(128, '1', 'user', 'Used PROMO with promo code: code123', '2023-11-30 17:04:27'),
(129, '1', 'user', 'Guest paid its reservation with reservation ID: 202 thru Gcash, payment reference #: TEST3', '2023-11-30 17:04:32'),
(130, '1', 'user', 'Add to cart service with service ID: 3', '2023-11-30 17:05:05'),
(131, '1', 'user', 'Guest paid its reservation with reservation ID: 203 thru Gcash, payment reference #: TEST4', '2023-11-30 17:05:12'),
(132, '1', 'admin', 'Logged on', '2023-11-30 17:10:50'),
(133, '1', 'admin', 'Logged on', '2023-11-30 18:55:09'),
(134, '1', 'admin', 'Update room with ID: 12 status to 0', '2023-11-30 18:55:25'),
(135, '1', 'user', 'Logged on', '2023-11-30 18:56:29'),
(136, '1', 'admin', 'Update room with ID: 12 status to 1', '2023-11-30 18:56:55'),
(137, '1', 'admin', 'Update room with ID: 13 status to 0', '2023-11-30 18:57:18'),
(138, '1', 'admin', 'Update the status of reservation ID: 202 to Approved', '2023-11-30 19:17:07'),
(139, '1', 'admin', 'Update the status of reservation ID: 202 to Approved', '2023-11-30 19:17:09'),
(140, '1', 'admin', 'Update the status of reservation ID: 201 to Approved', '2023-11-30 19:17:13'),
(141, '1', 'admin', 'Update the status of reservation ID: 200 to Approved', '2023-11-30 19:17:14'),
(142, '1', 'admin', 'Checked out reservation ID: 202', '2023-11-30 19:21:52'),
(143, '1', 'admin', 'Checked out reservation ID: 201', '2023-11-30 19:21:53'),
(144, '1', 'admin', 'Checked out reservation ID: 200', '2023-11-30 19:21:55'),
(145, '1', 'admin', 'Checked out reservation ID: 196', '2023-11-30 19:22:24'),
(146, '1', 'admin', 'Checked out reservation ID: 194', '2023-11-30 19:22:26'),
(147, '1', 'user', 'Add to cart room reservation with room ID: 12', '2023-11-30 19:26:02'),
(148, '1', 'user', 'Guest paid its reservation with reservation ID: 204 thru Gcash, payment reference #: 3332223', '2023-11-30 19:26:08'),
(149, '1', 'admin', 'Update the status of reservation ID: 204 to Rejected', '2023-11-30 19:49:00'),
(150, '1', 'admin', 'Set fully paid reservation ID: 201', '2023-11-30 20:13:22'),
(151, '1', 'admin', 'Set fully paid reservation ID: 196', '2023-11-30 20:13:39'),
(152, '1', 'admin', 'Set fully paid reservation ID: 194', '2023-11-30 20:22:18'),
(153, '1', 'user', 'Add to cart service with service ID: 2', '2023-11-30 20:55:34'),
(154, '1', 'user', 'Guest paid its reservation with reservation ID: 205 thru Gcash, payment reference #: 77777777', '2023-11-30 20:55:42');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `date`, `name`, `email`, `subject`, `message`, `status`) VALUES
(1, '2023-08-14', 'John Paul Heje', 'johnpaulheje@gmail.com', 'awww', 'awww', 0),
(2, '2023-08-14', 'John Paul Heje', 'johnpaulheje@gmail.com', 'aawwa', 'awdadasd', 0),
(3, '2023-08-14', 'John Paul Heje', 'johnpaulheje@gmail.com', 'awwwwwww', 'awwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwwwawwwwwww', 0),
(4, '2023-10-15', 'JP', 'johnpaulheje@gmail.com', 'Test', 'Test Message', 0),
(5, '2023-10-15', 'Saverlyn Grace L. Gabiaso', 'grasyagabay@gmail.com', 'asdfghjk', 'aqwedcfgyuj', 0),
(6, '2023-10-15', 'John Paul Heje', 'johnpaulheje@gmail.com', 'Test', 'TEST', 0),
(7, '2023-10-15', 'Saverlyn Grace L. Gabiaso', 'grasyagabay@gmail.com', 'kamantigue', 'kamantiguebeachresort', 0),
(8, '2023-10-15', 'John Paul Heje', 'johnpaulheje@gmail.com', 'TEST', 'TEST MESSAGE', 0),
(9, '2023-10-15', 'John Paul Heje', 'johnpaul.heje@g.batstate-u.edu.ph', 'Test', 'TEST', 0),
(10, '2023-10-15', 'John Paul Heje', 'johnpaulheje@gmail.com', 'TEST', 'TEST', 0),
(11, '2023-10-15', 'John Paul Heje', 'johnpaulheje@gmail.com', 'NEW TEST', 'NEW TEST', 0),
(12, '2023-10-15', 'allen', 'allenvien123@gmail.com', 'reservations', 'reserve', 0),
(13, '2023-10-15', 'Saverlyn Grace L. Gabiaso', 'grasyagabay@gmail.com', 'CED', 'reservation', 0),
(14, '2023-10-15', 'Saverlyn Grace L. Gabiaso', 'grasyagabay@gmail.com', 'JIN', 'RESERVATION', 0),
(15, '2023-10-15', 'Saverlyn Grace L. Gabiaso', 'grasyagabay@gmail.com', 'ELLA', 'RESERVATION PAYMENT', 0),
(16, '2023-10-16', 'Saverlyn Grace L. Gabiaso', 'grasyagabay@gmail.com', 'GIDEON', 'RESERVATION', 0),
(17, '2023-10-16', 'Saverlyn Grace L. Gabiaso', 'grasyagabay@gmail.com', 'CHRISTIAN', 'RESERVATION', 0),
(18, '2023-10-16', 'Saverlyn Grace L. Gabiaso', 'grasyagabay@gmail.com', 'JOVAN', 'RESERVATION', 0),
(19, '2023-10-16', 'Saverlyn Grace L. Gabiaso', 'grasyagabay@gmail.com', 'KEN', 'RESERVATION', 0),
(20, '2023-10-16', 'Saverlyn Grace L. Gabiaso', 'grasyagabay@gmail.com', 'JAMES', 'REDCFNMFDKJR', 0),
(21, '2023-10-16', 'SER NAJ', 'jhariel28@gmail.com', 'Reservation', 'Palpak', 0),
(22, '2023-10-16', 'Nishant Sharma', 'nishant.developer22@gmail.com', 'Re: Website Design & development service for kamantiguebeachresort.com', 'Hello team kamantiguebeachresort.com,\r\n\r\nI trust this message finds you well! \r\n\r\nWould you be interested in Design or Re-design your website & mobile app? Or are you interested in creating a whole New Site?\r\n \r\nOur Services are: - Create New Website â€“ (New Brand) Web Design, Re-design, Web Copywriting, Wordpress, Web Development, Graphic Design, Mobile App (iOS Android) Maintenanceâ€¦etc\r\n \r\nAnything similar to what youâ€™re looking for?\r\n \r\nIf interested, then please get back to me.\r\n \r\nThank & Regards,\r\nNishant Sharma\r\nSr. Manager Technical Consultant', 0);

-- --------------------------------------------------------

--
-- Table structure for table `promocode`
--

CREATE TABLE `promocode` (
  `promo_id` int(11) NOT NULL,
  `promo_code` varchar(50) NOT NULL,
  `promo_description` varchar(50) NOT NULL,
  `promo_discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promocode`
--

INSERT INTO `promocode` (`promo_id`, `promo_code`, `promo_description`, `promo_discount`) VALUES
(1, 'CODE123', '10% Discount', 10),
(3, 'PROMO1', '', 15);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `services_number` int(11) DEFAULT NULL,
  `services_description` varchar(50) DEFAULT NULL,
  `services_price` int(11) DEFAULT NULL,
  `Amenities` varchar(255) DEFAULT NULL,
  `Amenities_prices` varchar(255) DEFAULT NULL,
  `check_in_date` date DEFAULT NULL,
  `check_out_date` date DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT NULL,
  `adults` int(11) DEFAULT NULL,
  `children` int(11) DEFAULT NULL,
  `reference_number` varchar(255) DEFAULT NULL,
  `Amenities_totalprice` varchar(255) DEFAULT '0',
  `payable_amount` varchar(255) NOT NULL DEFAULT '0',
  `paid_amount` varchar(255) NOT NULL DEFAULT '0',
  `check_out_status` varchar(100) DEFAULT 'waiting' COMMENT 'waiting and checkedout',
  `down_payment` varchar(100) DEFAULT '0',
  `submitted_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `user_id`, `room_id`, `services_number`, `services_description`, `services_price`, `Amenities`, `Amenities_prices`, `check_in_date`, `check_out_date`, `status`, `adults`, `children`, `reference_number`, `Amenities_totalprice`, `payable_amount`, `paid_amount`, `check_out_status`, `down_payment`, `submitted_date`) VALUES
(192, 1, NULL, 2, 'Banana Boat (10 pax)', 3500, NULL, NULL, NULL, NULL, 'Pending', NULL, NULL, 'AASD2232323', '0', '3500', '1050', 'waiting', '0', '2023-11-30 20:27:00'),
(193, 1, NULL, 3, 'Aqua Slider (4 pax)', 2000, NULL, NULL, NULL, NULL, 'Pending', NULL, NULL, 'AASD2232323', '0', '2000', '600', 'waiting', '0', '2023-11-30 20:27:00'),
(194, 1, 12, NULL, NULL, NULL, 'Pillows [5] | ', '100 | ', '2023-12-01', '2023-12-02', 'Approved', 1, 2, 'AASD2232323', '500', '12500', '12500', 'checkedout', '3750', '2023-11-30 20:27:00'),
(196, 1, 21, NULL, NULL, NULL, 'Comforter [1] | Condom [2] | ', '200 | 300 | ', '2023-12-28', '2023-12-30', 'Approved', 1, 2, 'AASD2232323', '800', '12000', '12000', 'waiting', '0', '2023-11-30 20:27:00'),
(197, 1, NULL, 2, 'Banana Boat (10 pax)', 3500, NULL, NULL, NULL, NULL, 'Pending', NULL, NULL, '331112233', '0', '3500', '3500', 'waiting', '0', '2023-11-30 20:27:00'),
(200, 1, 14, NULL, NULL, NULL, NULL, NULL, '2023-12-01', '2023-12-02', 'Approved', 1, 1, 'TEST1', '0', '3000', '3000', 'checkedout', '0', '2023-11-30 20:27:00'),
(201, 1, 15, NULL, NULL, NULL, NULL, NULL, '2023-12-01', '2023-12-02', 'Approved', 1, 1, 'TEST2', '0', '2000', '2000', 'checkedout', '0', '2023-11-30 20:27:00'),
(202, 1, 20, NULL, NULL, NULL, NULL, NULL, '2023-12-01', '2023-12-02', 'Approved', 1, 1, 'TEST3', '0', '9000', '9000', 'checkedout', '0', '2023-11-30 20:27:00'),
(203, 1, NULL, 3, 'Aqua Slider (4 pax)', 2000, NULL, NULL, NULL, NULL, 'Pending', NULL, NULL, 'TEST4', '0', '2000', '2000', 'waiting', '0', '2023-11-30 20:27:00'),
(204, 1, 12, NULL, NULL, NULL, NULL, NULL, '2023-12-01', '2023-12-02', 'Rejected', 1, 1, '3332223', '0', '12500', '12500', 'waiting', '0', '2023-11-30 20:27:00'),
(205, 1, NULL, 2, 'Banana Boat (10 pax)', 3500, NULL, NULL, NULL, NULL, 'Approved', NULL, NULL, '77777777', '0', '3500', '3500', 'waiting', '0', '2023-11-30 20:55:34');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_number` varchar(50) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `price` int(50) NOT NULL,
  `room_id` int(11) NOT NULL,
  `picture_link` varchar(50) NOT NULL,
  `site_link` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_number`, `description`, `price`, `room_id`, `picture_link`, `site_link`, `status`) VALUES
('Barkada Room 1', 'Barkada Room (16 pax)', 12500, 12, 'barkadaroom1.jpg', 'barkadaroom1.php', 1),
('Barkada Room 2', 'Barkada Room (16 pax)', 12500, 13, 'barkadaroom2.jpg', 'barkadaroom2.php', 0),
('Aircon Cottage', 'Aircon Cottage (4 pax)', 3000, 14, 'aircon-cottage.jpg', 'aircon-cottage.php', 1),
('Couple Room', 'Couple Room with AC, CR with shower', 2000, 15, 'couples-room.jpg', 'couples-room.php', 1),
('Family Room 1', 'Main Building Family Room 1 (4 pax) Overnight', 4500, 16, 'main-building-family-1.jpg', 'main-building-family-1.php', 1),
('Family Room 2', 'Main Building Family Room 2 (4 pax) Overnight', 4500, 17, 'main-building-family-2.jpg', 'main-building-family-2.php', 1),
('Group Room 1', 'Main Building Group Room 1 (16 pax)', 13000, 18, 'main-building-group-1.jpg', 'main-building-group-1.php', 1),
('Group Room 2', 'Main Building Group Room 2 Overnight', 12500, 19, 'main-building-group-2.jpg', 'main-building-group-2.php', 1),
('Seaside Unit 1', 'Sea Side Unit (12 pax) Overnight', 10000, 20, 'seaside-unit-1.jpg', 'seaside-unit-1.php', 1),
('Seaside Unit 2', 'Seaside Unit (18 pax) Overnight', 12000, 21, 'seaside-unit-2.jpg', 'seaside-unit-2.php', 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `services_number` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `type` varchar(100) DEFAULT 'Service' COMMENT 'Service or Amenities'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`services_number`, `description`, `price`, `type`) VALUES
(2, 'Banana Boat (10 pax)', 3500, 'Service'),
(3, 'Aqua Slider (4 pax)', 2000, 'Service'),
(4, 'Speed Boat (6 pax)', 2500, 'Service'),
(6, 'Pillows', 100, 'Amenities'),
(7, 'Comforter', 200, 'Amenities'),
(8, 'Condom', 300, 'Amenities'),
(9, 'Amenities', 2000, 'Amenities');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `verification_token` varchar(50) NOT NULL,
  `verified` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `name`, `email`, `user_id`, `verification_token`, `verified`) VALUES
('user', '$2y$10$31VzJMHZ1yWaGg97RGSto.vOFdTGSsd1RoWVR7iW9K8L/tNMwEN7W', 'user', 'user', 1, '', 1),
('Japet', '$2y$10$8z5trNoRPJwvCZfH/kjj8u3XwyXrvn8lWxen8ComLYEc19CW4Cvw.', 'Japet Babasa', 'jhapetbabasa@gmail.com', 11, 'ad9026bed8baaa93c2a239c380de5b26', 1),
('angel', '$2y$10$8UAkuv0MuysLBzzimk7DEeovQoORTiqSfR0lOGC7rNm8qeoolGlqS', 'angel', 'angel@gmail.com', 13, 'b24f069d3d198b37af77a1e8c0fa469e', 0),
('angel', '$2y$10$bCs.EjbA2uTlHVad32hXfOOGHzkPHV479q0atKky0Gkkzum4hzHX6', 'angel', 'mabricenio01@gmail.com', 14, '3373b2d8ab0a105cb7b54ec95a09bbe6', 1),
('EARLPUGE', '$2y$10$.EYurY3pkcE4HYZpT/Tmi.Hh2TKBPoWizz2rX80O1Mxp5B/fCz7gu', 'EARL', 'earlcedricguevarra.pvgma@gmail.com', 15, '5a064d8bc30325d55c3834b5855e2392', 1),
('Savgabiaso', '$2y$10$v5E0Xj.81ttYmnIgM9pKhO7yiaQ3BwiEjR928M8xRhblz5WEwEuHa', 'Saverlyn Grace L. Gabiaso', 'grasyagabay@gmail.com', 18, '80a0cdfa4d4d93ea6ee9107ace79fc5d', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `audit`
--
ALTER TABLE `audit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promocode`
--
ALTER TABLE `promocode`
  ADD PRIMARY KEY (`promo_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`services_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audit`
--
ALTER TABLE `audit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `promocode`
--
ALTER TABLE `promocode`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `services_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
