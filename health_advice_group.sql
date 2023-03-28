-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2023 at 02:21 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `health_advice_group`
--

-- --------------------------------------------------------

--
-- Table structure for table `fitness_data`
--

CREATE TABLE `fitness_data` (
  `user_id` int(255) NOT NULL,
  `steps` int(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fitness_data`
--

INSERT INTO `fitness_data` (`user_id`, `steps`, `date`) VALUES
(10, 123, '2023-03-21'),
(10, 1234, '2023-03-06'),
(10, 555, '2023-01-10'),
(10, 333, '2014-03-12'),
(10, 10000, '2023-03-21'),
(10, 20000, '2023-03-23'),
(10, 13000, '2023-02-15'),
(10, 15000, '2023-12-12'),
(10, 16000, '2023-09-30'),
(10, 17000, '2023-08-11'),
(10, 18000, '2023-01-25'),
(10, 19000, '2023-07-26'),
(10, 23000, '2023-06-01'),
(11, 0, '2023-03-24'),
(10, 10000, '2023-03-28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `admin` int(1) NOT NULL,
  `profileimage` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `admin`, `profileimage`) VALUES
(10, 'test', 'test@gmail.com', '$2y$10$2QYz5IvNPY7mVUo7beyg8uZkCPnYtmTUsqT.cZZEz2/.qte/Ez.DC', 0, 'image-uploads/default.png'),
(11, 'test2', 'test2@gmail.com', '$2y$10$jI3ldaCyHAtSYrbC7Ft2VOOXH2ebuw6XqI/NjEvL7n5mEfcTHwpFS', 0, 'image-uploads/default.png'),
(27, 'test3', 'test3@gmail.com', '$2y$10$bHk79TVy5bWikFo2kNejgeGeJmYjo9er7TKRa6EBs0YS0hbLhHF42', 0, 'image-uploads/default.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `user_id` int(255) NOT NULL,
  `height_feet` int(1) NOT NULL,
  `height_inch` int(2) NOT NULL,
  `weight` int(3) NOT NULL,
  `age` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`user_id`, `height_feet`, `height_inch`, `weight`, `age`) VALUES
(10, 6, 0, 80, 18),
(11, 5, 6, 50, 19),
(27, 5, 5, 80, 18);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fitness_data`
--
ALTER TABLE `fitness_data`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fitness_data`
--
ALTER TABLE `fitness_data`
  ADD CONSTRAINT `fitness_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_data`
--
ALTER TABLE `user_data`
  ADD CONSTRAINT `user_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
