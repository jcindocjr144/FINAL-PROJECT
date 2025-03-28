-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 09:01 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tinkerbelldb`
--

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `street` varchar(100) DEFAULT NULL,
  `barangay` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `plate_no` varchar(20) DEFAULT NULL,
  `body_no` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `car_image` varchar(255) DEFAULT NULL,
  `is_for_rent` tinyint(1) DEFAULT 0,
  `car_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `contact`, `street`, `barangay`, `city`, `province`, `unit`, `plate_no`, `body_no`, `created_at`, `car_image`, `is_for_rent`, `car_id`) VALUES
(1, 'emil145', '1234', 'Emil', 'Louise', 'Igot', '09123456789', 'Babag', '1', 'Lapu-Lapu', 'Cebu', 'TAXI', 'GAW-123', 123, '2024-12-20 12:11:30', 'car.jpg', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gcash_transactions`
--

CREATE TABLE `gcash_transactions` (
  `id` int(11) NOT NULL,
  `rental_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `recipient_gcash_account` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE `guest` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'guest',
  `car_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guest`
--

INSERT INTO `guest` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `contact`, `street`, `barangay`, `city`, `province`, `created_at`, `user_id`, `role`, `car_id`) VALUES
(1, 'ivy1235', '12345', '', NULL, '', NULL, NULL, NULL, NULL, NULL, '2024-12-20 20:45:12', 3, 'guest', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `maintenancelogs`
--

CREATE TABLE `maintenancelogs` (
  `id` int(11) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `plate_no` varchar(20) NOT NULL,
  `body_no` int(11) NOT NULL,
  `driver_name` varchar(100) NOT NULL,
  `maintenance` varchar(255) NOT NULL,
  `mechanic` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenancelogs`
--

INSERT INTO `maintenancelogs` (`id`, `unit`, `plate_no`, `body_no`, `driver_name`, `maintenance`, `mechanic`, `created_at`, `payment`) VALUES
(1, 'TAXI', 'GAW-1234', 1234, 'Emil Louise Igot', 'CHANGE OIL', 'Jerson', '2024-12-20 12:12:35', 2000.00),
(2, 'TAXI', 'GAW-1234', 1234, 'Emil Louise Igot', 'CHANGE TIRE ', 'Jerson', '2024-12-20 12:14:56', 400.00);

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `plate_no` varchar(50) DEFAULT NULL,
  `body_no` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'driver',
  `car_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `contact`, `street`, `barangay`, `city`, `province`, `unit`, `plate_no`, `body_no`, `created_at`, `updated_at`, `user_id`, `role`, `car_id`) VALUES
(1, 'emil145', '1234', 'Emil', 'Louise', 'Igot', '09123456789', 'Babag', '1', 'Lapu-Lapu', 'Cebu', 'TAXI', 'GAW-123', '123', '2024-12-20 12:11:30', '2024-12-20 13:14:16', 2, 'driver', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rental`
--

CREATE TABLE `rental` (
  `id` int(11) NOT NULL,
  `car_id` int(11) DEFAULT NULL,
  `guest_id` int(11) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `rental_date` datetime DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `mode_of_payment` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rental`
--

INSERT INTO `rental` (`id`, `car_id`, `guest_id`, `driver_id`, `rental_date`, `payment_method`, `status`, `mode_of_payment`, `amount`) VALUES
(1, 1, NULL, 1, NULL, 'cash', NULL, 'full_payment', 1000.00),
(2, 1, NULL, 1, NULL, 'cash', NULL, 'full_payment', 399.00),
(3, 1, NULL, 1, NULL, 'cash', NULL, 'installment', 300.00),
(4, 1, NULL, 1, NULL, 'gcash', NULL, NULL, NULL),
(5, 1, NULL, 1, NULL, 'cash', NULL, NULL, NULL),
(6, 1, NULL, 1, NULL, 'cash', NULL, 'full_payment', 1200.00);

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `id` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `plate_no` varchar(255) NOT NULL,
  `body_no` int(11) NOT NULL,
  `driver_name` varchar(255) NOT NULL,
  `payment_method` enum('CASH','GCASH') NOT NULL,
  `days` int(11) NOT NULL,
  `rental` decimal(10,2) NOT NULL,
  `maintenance` decimal(10,2) NOT NULL,
  `savings` decimal(10,2) NOT NULL,
  `accspay` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `collection_total` decimal(10,2) GENERATED ALWAYS AS (`rental` * `days` + `maintenance` + `savings` + `accspay`) STORED,
  `status` enum('pending','approved','rejected','completed') DEFAULT 'pending',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `driver_id` int(11) NOT NULL,
  `guest_id` int(11) NOT NULL,
  `car_id` int(11) DEFAULT NULL,
  `rental_date` datetime DEFAULT current_timestamp(),
  `mode_of_payment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`id`, `unit`, `plate_no`, `body_no`, `driver_name`, `payment_method`, `days`, `rental`, `maintenance`, `savings`, `accspay`, `total`, `status`, `start_date`, `end_date`, `created_at`, `driver_id`, `guest_id`, `car_id`, `rental_date`, `mode_of_payment`) VALUES
(7, 'TAXI', '123', 123, 'Emil Louise Igot', 'CASH', 2, 100.00, 1000.00, 1000.00, 1000.00, 3200.00, 'pending', NULL, NULL, '2024-12-21 01:17:14', 0, 0, NULL, '2024-12-21 09:20:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'client',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'Administrator', 'admin', 'admin', '2024-12-20 12:09:21'),
(2, 'emil145', '1234', 'driver', '2024-12-20 12:11:30'),
(3, 'ivy1234', '12345', 'guest', '2024-12-20 20:45:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gcash_transactions`
--
ALTER TABLE `gcash_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gcash_transactions_ibfk_1` (`rental_id`);

--
-- Indexes for table `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maintenancelogs`
--
ALTER TABLE `maintenancelogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `rental`
--
ALTER TABLE `rental`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guest_id` (`guest_id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guest_id` (`guest_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gcash_transactions`
--
ALTER TABLE `gcash_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guest`
--
ALTER TABLE `guest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `maintenancelogs`
--
ALTER TABLE `maintenancelogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rental`
--
ALTER TABLE `rental`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gcash_transactions`
--
ALTER TABLE `gcash_transactions`
  ADD CONSTRAINT `gcash_transactions_ibfk_1` FOREIGN KEY (`rental_id`) REFERENCES `rentals` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rental`
--
ALTER TABLE `rental`
  ADD CONSTRAINT `rental_ibfk_1` FOREIGN KEY (`guest_id`) REFERENCES `guest` (`id`),
  ADD CONSTRAINT `rental_ibfk_2` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
