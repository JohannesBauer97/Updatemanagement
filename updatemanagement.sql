-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 18, 2018 at 01:21 PM
-- Server version: 5.5.60-0+deb8u1
-- PHP Version: 7.0.31-1~dotdeb+8.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `updatemanagement`
--
CREATE DATABASE IF NOT EXISTS `updatemanagement` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `updatemanagement`;

-- --------------------------------------------------------

--
-- Table structure for table `dateien`
--

CREATE TABLE `dateien` (
  `DateiID` int(10) UNSIGNED NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Size` int(11) NOT NULL,
  `Path` text COLLATE utf8_unicode_ci NOT NULL,
  `ProjektID` int(11) NOT NULL,
  `Hochgeladen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ProjektDatei` bit(1) NOT NULL DEFAULT b'0',
  `active` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `loginID` int(10) UNSIGNED NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `projekte`
--

CREATE TABLE `projekte` (
  `ProjektID` int(11) UNSIGNED NOT NULL,
  `Projektname` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Projektbeschreibung` text COLLATE utf8_unicode_ci,
  `Angelegt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projekte_user`
--

CREATE TABLE `projekte_user` (
  `projekteUserID` int(11) NOT NULL,
  `userID` int(11) UNSIGNED NOT NULL,
  `projektID` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) UNSIGNED NOT NULL,
  `username` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `version`
--

CREATE TABLE `version` (
  `versionID` int(10) UNSIGNED NOT NULL,
  `projektID` int(11) UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `DateiID` int(11) UNSIGNED NOT NULL,
  `Angelegt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `changes` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dateien`
--
ALTER TABLE `dateien`
  ADD PRIMARY KEY (`DateiID`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`loginID`);

--
-- Indexes for table `projekte`
--
ALTER TABLE `projekte`
  ADD PRIMARY KEY (`ProjektID`);

--
-- Indexes for table `projekte_user`
--
ALTER TABLE `projekte_user`
  ADD PRIMARY KEY (`projekteUserID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `projektID` (`projektID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `version`
--
ALTER TABLE `version`
  ADD PRIMARY KEY (`versionID`),
  ADD KEY `projektID` (`projektID`),
  ADD KEY `DateiID` (`DateiID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dateien`
--
ALTER TABLE `dateien`
  MODIFY `DateiID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;
--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `loginID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `projekte`
--
ALTER TABLE `projekte`
  MODIFY `ProjektID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `projekte_user`
--
ALTER TABLE `projekte_user`
  MODIFY `projekteUserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `version`
--
ALTER TABLE `version`
  MODIFY `versionID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `projekte_user`
--
ALTER TABLE `projekte_user`
  ADD CONSTRAINT `projekte_user_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `projekte_user_ibfk_2` FOREIGN KEY (`projektID`) REFERENCES `projekte` (`ProjektID`);

--
-- Constraints for table `version`
--
ALTER TABLE `version`
  ADD CONSTRAINT `version_ibfk_1` FOREIGN KEY (`projektID`) REFERENCES `projekte` (`ProjektID`),
  ADD CONSTRAINT `version_ibfk_2` FOREIGN KEY (`DateiID`) REFERENCES `dateien` (`DateiID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
