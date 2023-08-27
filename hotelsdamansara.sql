-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2023 at 07:12 AM
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
-- Database: `hotelsdamansara`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustName` varchar(100) NOT NULL,
  `CustEmail` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustName`, `CustEmail`, `password`) VALUES
('Muhammad Faris Bin Adnan', 'farismeow@gmail.com', '$2y$10$n95HGSwtoJiZBViaVO5BBeU68HivDk5OIGCKsvYcPmRLus1Nr2TNG'),
('Muhammad Iman Hakimi Bin Abu Supian', 'imanhakimi2206@gmail.com', '$2y$10$AVdp2cphcWXDcnaOzqLT6uYmGIuYuvBJ.YCDnpx.U9H9KqpilT2hq'),
('Nurin qistina binti mohd fadil', 'nurinqis@gmail.com', '$2y$10$233sXYl5RqqpKAU8psKYhOZMR206k5DT63H/.ejfpsIoQ/UemH9Pq'),
('Muhammad Iman Hakimi Bin Abu Supian', 'painscreamx@gmail.com', '$2y$10$3kO7wijOTUJpXK9Y63ix2.8q4kEtvKf9xQuVZssyA/4L5BkjWMRiq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustEmail`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
