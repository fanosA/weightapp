-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2016 at 01:22 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weightapp`
--
CREATE DATABASE IF NOT EXISTS `weightapp` DEFAULT CHARACTER SET greek COLLATE greek_general_ci;
USE `weightapp`;

-- --------------------------------------------------------

--
-- Table structure for table `diaitologos`
--

CREATE TABLE `diaitologos` (
  `id-diaitologou` int(16) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `onoma` varchar(32) NOT NULL,
  `epitheto` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=greek;

--
-- Dumping data for table `diaitologos`
--

INSERT INTO `diaitologos` (`id-diaitologou`, `username`, `password`, `onoma`, `epitheto`) VALUES
(1, 'diaitologos1', '123', 'diaitologosName', 'diaitologosLastname'),
(2, 'diaitologos2', '123', 'diaitologosName', 'diaitologosLastname');

-- --------------------------------------------------------

--
-- Table structure for table `diaitologos-pelatis`
--

CREATE TABLE `diaitologos-pelatis` (
  `id-diaitologou` int(16) NOT NULL,
  `id-pelati` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=greek;

--
-- Dumping data for table `diaitologos-pelatis`
--

INSERT INTO `diaitologos-pelatis` (`id-diaitologou`, `id-pelati`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `geyma`
--

CREATE TABLE `geyma` (
  `id-geymatos` int(16) NOT NULL,
  `id-diaitologou` int(16) NOT NULL,
  `id-pelati` int(16) NOT NULL,
  `imerominia` date NOT NULL,
  `sxolia-diaitologou` varchar(256) NOT NULL,
  `feedback` varchar(256) NOT NULL,
  `typos-geymatos` int(16) NOT NULL,
  `ora-katanalosis` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=greek;

--
-- Dumping data for table `geyma`
--

INSERT INTO `geyma` (`id-geymatos`, `id-diaitologou`, `id-pelati`, `imerominia`, `sxolia-diaitologou`, `feedback`, `typos-geymatos`, `ora-katanalosis`) VALUES
(1, 1, 1, '2016-03-26', '1 φρυγανιά με μέλι', 'δεν προλαβα να φαω', 1, '00:00:00'),
(2, 1, 1, '2016-03-26', '1 φρούτο', '', 2, '10:47:00'),
(3, 1, 1, '2016-03-26', '1/4 κοτόπουλο και σαλάτα όση θες', 'Δεν χόρτασα', 3, '14:39:00'),
(4, 1, 1, '2016-03-26', '1 γιαούρτι και 1 φρυγανιά', 'Εφαγα 2 φρυγανιες παραπανω', 5, '06:50:00'),
(5, 1, 1, '2016-03-27', '1 τοστ και χυμός', 'Αρκετο', 1, '22:22:00'),
(7, 1, 1, '2016-03-27', 'ελεύθερο', '', 3, NULL),
(8, 1, 1, '2016-03-26', 'ελεύθερο', 'Το καλυτερο γευμα απο ολα :)', 5, '09:37:00'),
(9, 1, 2, '2016-03-28', 'Σούπα και σαλάτα', 'δεν εκανε τιποτα', 3, '08:24:00'),
(10, 1, 2, '2016-03-30', '1 πιάτο μακαρόνια με λίγο τυρί', '', 5, NULL),
(11, 1, 2, '2016-04-01', '1 μικρο μπολ δημητριακα', '', 1, NULL),
(12, 1, 2, '2016-04-01', '2 φρουτα', '', 2, NULL),
(13, 1, 2, '2016-04-01', '3 καλαμακια κοτοπουλο και σαλατα', '', 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pelatis`
--

CREATE TABLE `pelatis` (
  `id-pelati` int(16) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `onoma` varchar(32) NOT NULL,
  `epitheto` varchar(32) NOT NULL,
  `baros` int(3) NOT NULL,
  `filo` varchar(16) NOT NULL,
  `ilikia` int(3) NOT NULL,
  `sxolia` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=greek;

--
-- Dumping data for table `pelatis`
--

INSERT INTO `pelatis` (`id-pelati`, `username`, `password`, `onoma`, `epitheto`, `baros`, `filo`, `ilikia`, `sxolia`) VALUES
(1, 'thanos', '123', 'Αθανάσιος', 'Φανός', 85, 'Άνδρας', 33, '3η ΓΕ ΠΛΗ23'),
(2, 'dora', '123', 'Θεοδώρα', 'Φανού', 62, 'Γυναίκα', 26, ''),
(3, 'rita', '123', 'Μαργαρίτα', 'Δελούδη', 72, 'Γυναίκα', 61, ''),
(5, 'testuser2', '123', 'name2', 'lastnameEdited', 103, 'Άνδρας', 43, 'A much shorter comment'),
(7, 'testuser4', '123', 'name4', 'lastname4', 118, 'Γυναίκα', 55, 'Ένα σχόλιο');

-- --------------------------------------------------------

--
-- Table structure for table `sxolia-imeras`
--

CREATE TABLE `sxolia-imeras` (
  `id-sxoliou-imeras` int(16) NOT NULL,
  `id-pelati` int(16) NOT NULL,
  `imerominia` date NOT NULL,
  `sxolio` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=greek;

--
-- Dumping data for table `sxolia-imeras`
--

INSERT INTO `sxolia-imeras` (`id-sxoliou-imeras`, `id-pelati`, `imerominia`, `sxolio`) VALUES
(1, 1, '2016-03-26', 'Πεινουσα λιγο στο τελος της ημερας και εφαγα και μια σοκοφρετα παραπανω'),
(2, 1, '2016-03-27', 'Πολυ ικανοποιημενος απο το μενου της ημερας!!'),
(3, 2, '2016-03-28', 'που ειναι τα αλλα γευματα διαιτολογε?'),
(4, 2, '2016-04-01', 'Ικανοποιητικα'),
(5, 1, '2016-03-28', 'τεστ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diaitologos`
--
ALTER TABLE `diaitologos`
  ADD PRIMARY KEY (`id-diaitologou`);

--
-- Indexes for table `geyma`
--
ALTER TABLE `geyma`
  ADD PRIMARY KEY (`id-geymatos`);

--
-- Indexes for table `pelatis`
--
ALTER TABLE `pelatis`
  ADD PRIMARY KEY (`id-pelati`);

--
-- Indexes for table `sxolia-imeras`
--
ALTER TABLE `sxolia-imeras`
  ADD PRIMARY KEY (`id-sxoliou-imeras`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `diaitologos`
--
ALTER TABLE `diaitologos`
  MODIFY `id-diaitologou` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `geyma`
--
ALTER TABLE `geyma`
  MODIFY `id-geymatos` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `pelatis`
--
ALTER TABLE `pelatis`
  MODIFY `id-pelati` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `sxolia-imeras`
--
ALTER TABLE `sxolia-imeras`
  MODIFY `id-sxoliou-imeras` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
