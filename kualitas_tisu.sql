-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2020 at 09:52 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datamining_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `kualitas_tisu`
--

CREATE TABLE `kualitas_tisu` (
  `id` int(11) NOT NULL,
  `x1` int(11) NOT NULL,
  `x2` int(11) NOT NULL,
  `y` enum('Baik','Jelek') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kualitas_tisu`
--

INSERT INTO `kualitas_tisu` (`id`, `x1`, `x2`, `y`) VALUES
(1, 8, 4, 'Baik'),
(2, 4, 5, 'Jelek'),
(3, 4, 6, 'Jelek'),
(4, 7, 7, 'Baik'),
(5, 5, 6, 'Jelek'),
(6, 6, 5, 'Baik');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kualitas_tisu`
--
ALTER TABLE `kualitas_tisu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kualitas_tisu`
--
ALTER TABLE `kualitas_tisu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
