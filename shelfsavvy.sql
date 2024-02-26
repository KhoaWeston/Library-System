-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2024 at 12:49 AM
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
-- Database: `shelfsavvy`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `BookID` bigint(20) NOT NULL,
  `Title` varchar(75) NOT NULL,
  `Author` varchar(50) NOT NULL,
  `Genre` varchar(50) NOT NULL,
  `NumofCopies` int(2) UNSIGNED NOT NULL,
  `image_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`BookID`, `Title`, `Author`, `Genre`, `NumofCopies`, `image_name`, `reg_date`) VALUES
(777, 'The Bible', 'Jesus', 'Nonfiction', 40, 'Book_cover_633.jpg', '2024-02-20 02:08:15'),
(385737955, 'The Maze Runner', 'James Dashner', 'Fiction', 8, 'Book_cover_242.jpg', '2024-02-20 16:10:34'),
(590353403, 'Harry Potter', 'J K Rowling', 'Fantasy Fiction', 1, 'Book_cover_424.jpg', '2024-02-20 02:08:15'),
(679824111, 'Magic Treehouse', 'Mary Pope Osborne', 'Childrens Fiction', 10, 'Book_cover_841.jpg', '2024-02-20 02:08:15'),
(9780060194994, 'To Kill a Mockingbird', 'Harper Lee', 'Domestic Fiction', 6, 'Book_cover_229.jpg', '2024-02-26 23:27:14'),
(9780394800011, 'The Cat in the Hat', 'Dr. Suess', 'Childrens Fantasy Fiction', 1, 'Book_cover_299.jpg', '2024-02-26 23:28:23'),
(9780399529207, 'Lord of the Flies', 'William Golding', 'Fiction', 3, 'Book_cover_295.jpg', '2024-02-26 23:25:33'),
(9780439023481, 'The Hunger Games', 'Suzanne Collins', 'Fiction', 7, 'Book_cover_111.jpg', '2024-02-20 02:13:00'),
(9780520966871, 'The Odyssey', 'Homer', 'Epic Poem', 2, 'Book_cover_699.jpg', '2024-02-26 23:23:07'),
(9780547345901, 'The Giver', 'Lois Lowry', 'Dystopian Fiction', 3, 'Book_cover_880.jpg', '2024-02-26 23:29:24'),
(9780786838653, 'The Lightning Thief', 'Rick Riordan', 'Fantasy Fiction', 7, 'Book_cover_688.jpg', '2024-02-20 02:08:15'),
(9781775412137, 'The Metamorphosis', 'Franz Kafka', 'Fiction', 4, 'Book_cover_98.jpg', '2024-02-26 23:21:24'),
(9781911481140, 'Moby Dick', 'C S Woolley', 'Fiction', 6, 'Book_cover_666.jpg', '2024-02-20 02:08:15');

-- --------------------------------------------------------

--
-- Table structure for table `loaned`
--

CREATE TABLE `loaned` (
  `UID` int(10) NOT NULL,
  `BookID` bigint(20) NOT NULL,
  `LoanDate` date NOT NULL,
  `ToBeReturnedDate` date NOT NULL,
  `Status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loaned`
--

INSERT INTO `loaned` (`UID`, `BookID`, `LoanDate`, `ToBeReturnedDate`, `Status`) VALUES
(9, 385737955, '2024-02-26', '2024-02-19', ''),
(9, 679824111, '2024-02-26', '2024-02-19', '');

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
  `PhoneNum` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Username`, `Password`, `MemberType`, `BooksOut`, `UID`, `Address`, `PhoneNum`) VALUES
('EthanBowers', '7c6a180b36896a0a8c02787eeafb0e4c', 'manager', 0, 2, 'Some address', 1231231234),
('DavidStemen', '6cb75f652a9b52798eb6cf2201057c73', 'manager', 0, 5, 'Another address', 1231231234),
('Cheka', '919e682cac825d430a580e842ff0bbc4', 'member', 0, 6, 'Her address', 7897897890),
('Khadka', '5f4dcc3b5aa765d61d8327deb882cf99', 'manager', 0, 8, 'His Address', 4564564567),
('KhoaWeston', '5f4dcc3b5aa765d61d8327deb882cf99', 'manager', 2, 9, '2784 N 300 E Anderson, IN 46012', 7658082261),
('DelilahTaylorr', '5f4dcc3b5aa765d61d8327deb882cf99', 'member', 0, 11, 'An address', 1231231234),
('Michael', '5f4dcc3b5aa765d61d8327deb882cf99', 'member', 0, 13, 'addresssss', 1231231234),
('1', 'c4ca4238a0b923820dcc509a6f75849b', 'manager', 0, 17, '1', 1);

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
  ADD KEY `loaned_FK_2` (`BookID`),
  ADD KEY `loaned_FK_1` (`UID`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `loaned`
--
ALTER TABLE `loaned`
  ADD CONSTRAINT `loaned_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `user` (`UID`),
  ADD CONSTRAINT `loaned_ibfk_2` FOREIGN KEY (`BookID`) REFERENCES `books` (`BookID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
