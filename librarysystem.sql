-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2024 at 07:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `librarysystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `BookID` int(10) NOT NULL,
  `Title` varchar(75) NOT NULL,
  `Author` varchar(50) NOT NULL,
  `Genre` varchar(50) NOT NULL,
  `#ofCopies` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loaned`
--

CREATE TABLE `loaned` (
  `UID` int(11) NOT NULL,
  `BookID` int(11) NOT NULL,
  `LoanDate` date NOT NULL,
  `ToBeReturnedDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `MemberType` varchar(20) NOT NULL,
  `BooksOut` int(2) NOT NULL,
  `UID` int(10) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `PhoneNum` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`BookID`);

--
-- Indexes for table `loaned`
--
ALTER TABLE `loaned`
  ADD KEY `loaned_FK_1` (`UID`),
  ADD KEY `loaned_FK_2` (`BookID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `loaned`
--
ALTER TABLE `loaned`
  ADD CONSTRAINT `loaned_FK_1` FOREIGN KEY (`UID`) REFERENCES `user` (`UID`),
  ADD CONSTRAINT `loaned_FK_2` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
