-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 18, 2023 at 04:46 AM
-- Server version: 10.5.20-MariaDB-cll-lve-log
-- PHP Version: 7.4.27

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
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `email`, `name`) VALUES
('admin', 'admin', 'admin', 'admin');

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
  `check_in_date` date DEFAULT NULL,
  `check_out_date` date DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT NULL,
  `adults` int(11) DEFAULT NULL,
  `children` int(11) DEFAULT NULL,
  `reference_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `user_id`, `room_id`, `services_number`, `services_description`, `services_price`, `check_in_date`, `check_out_date`, `status`, `adults`, `children`, `reference_number`) VALUES
(65, 15, 16, NULL, NULL, NULL, '2023-10-13', '2023-10-14', 'Approved', NULL, NULL, '0012632506991'),
(117, 26, 18, NULL, NULL, NULL, '2023-10-03', '2023-10-04', 'Approved', NULL, NULL, '4012699471152'),
(118, 26, NULL, 2, 'Banana Boat (10 pax)', 3500, NULL, NULL, 'Approved', NULL, NULL, '4012699471152'),
(119, 26, NULL, 3, 'Aqua Slider (4 pax)', 2000, NULL, NULL, 'Approved', NULL, NULL, '4012699471152'),
(120, 26, NULL, 4, 'Speed Boat (6 pax)', 2500, NULL, NULL, 'Approved', NULL, NULL, '4012699471152'),
(121, 1, 13, NULL, NULL, NULL, '2023-11-01', '2023-11-03', 'Pending', NULL, NULL, NULL),
(125, 11, 13, NULL, NULL, NULL, '2023-11-16', '2023-11-18', 'Approved', NULL, NULL, '0013206490659'),
(126, 11, NULL, 3, 'Aqua Slider (4 pax)', 2000, NULL, NULL, 'Approved', NULL, NULL, '0013206490659'),
(128, 18, 12, NULL, NULL, NULL, '2023-11-17', '2023-11-19', 'Pending', NULL, NULL, NULL),
(129, 18, 19, NULL, NULL, NULL, '2023-11-17', '2023-11-19', 'Pending', NULL, NULL, NULL),
(130, 18, NULL, 2, 'Banana Boat (10 pax)', 3500, NULL, NULL, 'Pending', NULL, NULL, NULL),
(131, 18, NULL, 4, 'Speed Boat (6 pax)', 2500, NULL, NULL, 'Pending', NULL, NULL, NULL);

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
('Barkada Room 2', 'Barkada Room (16 pax)', 12500, 13, 'barkadaroom2.jpg', 'barkadaroom2.php', 1),
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
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`services_number`, `description`, `price`) VALUES
(2, 'Banana Boat (10 pax)', 3500),
(3, 'Aqua Slider (4 pax)', 2000),
(4, 'Speed Boat (6 pax)', 2500);

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
('Savgabiaso', '$2y$10$v5E0Xj.81ttYmnIgM9pKhO7yiaQ3BwiEjR928M8xRhblz5WEwEuHa', 'Saverlyn Grace L. Gabiaso', 'grasyagabay@gmail.com', 18, '80a0cdfa4d4d93ea6ee9107ace79fc5d', 1),
('Savgabiaso', '$2y$10$VP42B7hBnB9U.GEcbx6bKO032.pX9PQz3z2k1A/ej8KLyMrw9VKki', 'Saverlyn Grace L. Gabiaso', 'grasyagabay@gmail.com', 23, '08b014ff177529bf93dceb0c58f6d4a4', 1),
('SER NAJ', '$2y$10$10jRPb.YqsXIWFpoGzjmLe6aDK5Ml/p81trGFCnxptVozci1W4432', 'Jan Jhariel Baroro', 'jharrel28@gmail.com', 24, '2314704910f5313752c6bfb64024c00c', 0),
('sernaj', '$2y$10$EPecgY3ZrkDqPAgL2dVeq.F55wFHO9dnViN4ty.BwvF5sw8fjGAG2', 'Jan Jhariel Baroro', 'jhariel28@gmail.com', 26, '13f3fdde0db3de6beb5a0016d16d5a2e', 1);

--
-- Indexes for dumped tables
--

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
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `services_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
