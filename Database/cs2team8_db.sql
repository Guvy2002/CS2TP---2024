-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 24, 2025 at 02:57 AM
-- Server version: 8.0.41-0ubuntu0.20.04.1
-- PHP Version: 8.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cs2team8_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `Basket`
--

CREATE TABLE `Basket` (
  `basketID` int NOT NULL,
  `customerID` int NOT NULL,
  `createdDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `Basket`
--

INSERT INTO `Basket` (`basketID`, `customerID`, `createdDate`) VALUES
(1, 1, '2024-12-09'),
(2, 2, '2024-12-10'),
(3, 3, '2024-12-10'),
(4, 4, '2025-01-22'),
(5, 5, '2025-02-07'),
(6, 8, '2025-03-12'),
(7, 9, '2025-03-12'),
(8, 11, '2025-03-14'),
(9, 10, '2025-03-17'),
(10, 14, '2025-03-18'),
(11, 15, '2025-03-18'),
(12, 7, '2025-03-19'),
(13, 18, '2025-03-20');

-- --------------------------------------------------------

--
-- Table structure for table `BasketItem`
--

CREATE TABLE `BasketItem` (
  `basketItemID` int NOT NULL,
  `basketID` int NOT NULL,
  `productID` int NOT NULL,
  `Quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `BasketItem`
--

INSERT INTO `BasketItem` (`basketItemID`, `basketID`, `productID`, `Quantity`) VALUES
(12, 2, 58, 1),
(13, 2, 53, 1),
(14, 2, 52, 1),
(15, 2, 46, 1),
(16, 2, 47, 1),
(17, 2, 41, 1),
(18, 3, 46, 1),
(73, 7, 6, 6),
(75, 7, 5, 1),
(129, 6, 23, 1),
(139, 6, 100, 1),
(144, 11, 18, 1),
(145, 11, 13, 3),
(146, 11, 29, 3),
(147, 11, 12, 1),
(148, 5, 92, 1),
(159, 5, 7, 1),
(161, 5, 82, 1),
(162, 4, 41, 1),
(166, 13, 27, 1),
(167, 13, 31, 1),
(191, 12, 18, 1),
(192, 12, 22, 1),
(193, 12, 7, 1),
(194, 12, 47, 1),
(195, 5, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `categoryID` int NOT NULL,
  `categoryName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`categoryID`, `categoryName`) VALUES
(1, 'Nintendo Games'),
(2, 'Nintendo Consoles'),
(3, 'Nintendo Controllers'),
(4, 'Nintendo Digital'),
(5, 'PC Headsets'),
(6, 'PC Keyboards'),
(7, 'PC Mice'),
(8, 'PC Microphones'),
(9, 'PC Monitors'),
(10, 'PS5 Consoles'),
(11, 'PS5 Games'),
(12, 'PS5 Accessories'),
(13, 'PS5 Digital'),
(14, 'XBOX Consoles'),
(15, 'XBOX Games'),
(16, 'XBOX Accessories'),
(17, 'XBOX Digital'),
(18, 'VR Headsets'),
(19, 'VR Games'),
(20, 'VR Accessories'),
(21, 'Bundle Deals');

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `customerID` int NOT NULL,
  `fullName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `RegistrationDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`customerID`, `fullName`, `Email`, `Password`, `RegistrationDate`) VALUES
(1, 'cameron hisham', 'abc@gmail.com', '$2y$10$k/GbexceiTChlzVYNcXEG.QC8RkfmBRzg0zT5lTQjHSP8aqcXl9HS', '2024-12-09'),
(2, 'Rene', 'sadwa@gmail', '$2y$10$BDohIet.s1muCP6O3yc79uiSVXEB/hsZcBr2nGjcvcwj55t26oUM2', '2024-12-10'),
(3, 'rene samtani', 'def@gmail.com', '$2y$10$pf9bQkmcbaH4qFv5n.wBte7mpqPlm5YiwB2NQztxQoDqt.G.X4r8q', '2024-12-10'),
(4, 'Rene', 'mbc@gmail.com', '$2y$10$huUGvPpqYvrxDH0W2dQY9ekOxGGVWGNsEFF2ezi8kgz2rosze8Q9K', '2025-01-22'),
(5, 'DSA', 'dsa@gmail.com', '$2y$10$P1V0cusZOkzPQlapN90UL.vGT5wzJkwBX9If5y5vXZXkV5oKqjtZS', '2025-02-05'),
(6, 'Bansi Lukka', 'bansilukka@gmail.com', '$2y$10$HvpVHb.gh5.N/s5A5W0gPuqBdM0Ebhb/C5YOEAUw3PEcqJm0TBck6', '2025-02-07'),
(7, 'Cameron Macdonald', 'cameronmacdonald673@gmail.com', '$2y$10$oV9DyaT4jI6MnjwTTB/K/OO083MlG5kSLbli7KBOA2iFKsslZaDEO', '2025-03-11'),
(8, 'Stan Prichard', 'stanmp19@gmail.com', '$2y$10$RMBnxYcXCdIQwGSFjjTLaOTNNi5hcWmctDCRXcWmJgavh0t6Dm4H.', '2025-03-12'),
(9, 'Chinedu Ukaoha', 'ukaohachinedu2004@gmail.com', '$2y$10$eJWWEoJA5MuUMt3CmyN9qusb5QEa8FBkkY5y0Izyqja/x1hafZbGe', '2025-03-12'),
(10, 'Tester', 'reneske64@gmail.com', '$2y$10$WrCUJB7/A1e3X5bgNAMZd.e73W6mZ7dzcV42kfjbWAq3zuXMwN/qy', '2025-03-12'),
(11, 'Mohammed Hasan', 'Mohamed13@gmail.com', '$2y$10$byhzIAnG.YQA6qmEWIRVQOl9rSmpswAAsvMCaJ8X1RiZ1Nk89osAW', '2025-03-14'),
(12, 'Cameron Macdonald', 'cm@gmail.com', '$2y$10$5j5KYfSTRLK0HKIneDY/B.NQh.v1thJlMR.IhXXCLUnQCtHf40pbi', '2025-03-17'),
(13, 'aaaaaaaaaaaaa aaaaaaa', 'aaaaaaaaaaa@gmail.com', '$2y$10$6p1X2dSemslj2wAslVQj.e3PAgge0vuePINICVH84vxYjqgfX43Je', '2025-03-17'),
(14, 'hjdgids', 'aaaaaaaa@gmail.com', '$2y$10$90EB9VnkzAJAQepHeqaxyekmghESU1Z37pzYda.62rTFd3JlMjVwa', '2025-03-17'),
(15, 'Rafeh', '230230053@aston.ac.uk', '$2y$10$c/.cUTXiuLOhH80EaWsuLugnuyty1cs8.VyKbwyyVJIEae3DWzpZi', '2025-03-18'),
(17, 'Hisham', 'heshamdoheash@gmail.com', '$2y$10$9Og7awcAUgizf4OQB/KT2uqgtlvwa4r063EP2jyzU6iMUWCWHBZ1S', '2025-03-19'),
(18, 'Antonio-Daniel Codreanu', 'antoniocodreanu2@gmail.com', '$2y$10$h.rIRXtzWBAs1Zov06OYAuL5rn7DgV8OcMUX8v0cPhkVsMdFzbn3u', '2025-03-20'),
(19, 'Cameroon Macdonald', 'itscameroony@gmail.com', '$2y$10$XP3Qg4U.cEMr0n7eWE0fYen5EGF0ffyfrQkI7P/7VzaQuIv6old2K', '2025-03-21');

-- --------------------------------------------------------

--
-- Table structure for table `Employee`
--

CREATE TABLE `Employee` (
  `employeeID` int NOT NULL,
  `fullName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `customerID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `Employee`
--

INSERT INTO `Employee` (`employeeID`, `fullName`, `Email`, `Password`, `position`, `customerID`) VALUES
(1, 'Rene', 'admin@gmail.com', '$2y$10$KVDiWF7HCHqLjHTVo4uqZuQw5BHZhfDulair7Ql4ITS62fWXN14kG', 'admin', 4);

-- --------------------------------------------------------

--
-- Table structure for table `Inventory`
--

CREATE TABLE `Inventory` (
  `inventoryID` int NOT NULL,
  `thresholdLevel` int NOT NULL,
  `productID` int NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ItemReview`
--

CREATE TABLE `ItemReview` (
  `itemReviewID` int NOT NULL,
  `productID` int NOT NULL,
  `rating` int NOT NULL,
  `review` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `ItemReview`
--

INSERT INTO `ItemReview` (`itemReviewID`, `productID`, `rating`, `review`) VALUES
(3, 46, 3, 'plaesee'),
(4, 46, 4, 'hsahdsadkjsa'),
(5, 46, 5, ''),
(6, 46, 5, 'PLEASE'),
(7, 46, 5, 'this should work'),
(8, 46, 4, 'please refresh properly'),
(9, 46, 4, 'maybe quicker this time\r\n'),
(10, 46, 1, 'super quick?\r\n'),
(11, 46, 5, 'wow love it'),
(12, 54, 4, ''),
(13, 46, 2, 'not bad'),
(14, 46, 5, 'great'),
(15, 46, 5, 'cam is the best'),
(16, 46, 5, 'hi'),
(17, 46, 5, 'wowww'),
(18, 46, 1, 'hgdckg'),
(19, 54, 5, 'hi '),
(20, 46, 5, 'jhfvfvwjefj'),
(21, 6, 3, 'hi'),
(22, 46, 3, 'cam is the best man'),
(23, 22, 5, 'wow'),
(24, 96, 5, 'SAVINGGG'),
(25, 96, 1, 'Meh'),
(26, 96, 1, 'Idk');

-- --------------------------------------------------------

--
-- Table structure for table `OrderHistory`
--

CREATE TABLE `OrderHistory` (
  `orderHistoryID` int NOT NULL,
  `customerID` int NOT NULL,
  `orderID` int NOT NULL,
  `Action` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `ActionDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `OrderHistory`
--

INSERT INTO `OrderHistory` (`orderHistoryID`, `customerID`, `orderID`, `Action`, `ActionDate`) VALUES
(1, 1, 1, 'Order Created', '2025-02-26'),
(2, 1, 2, 'Order Created', '2025-02-26'),
(3, 1, 3, 'Order Created', '2025-03-04'),
(4, 5, 4, 'Order Created', '2025-03-05'),
(5, 5, 5, 'Order Created', '2025-03-05'),
(6, 1, 6, 'Order Created', '2025-03-06'),
(7, 1, 7, 'Order Created', '2025-03-06'),
(8, 1, 8, 'Order Created', '2025-03-06'),
(9, 1, 6, 'Status updated to Delivered', '2025-03-07'),
(12, 1, 2, 'Status updated to Delivered', '2025-03-10'),
(13, 5, 4, 'Status updated to Shipped', '2025-03-11'),
(14, 5, 4, 'Status updated to Delivered', '2025-03-11'),
(15, 5, 9, 'Order Created', '2025-03-12'),
(16, 5, 10, 'Order Created', '2025-03-12'),
(17, 5, 10, 'Status updated to Processing', '2025-03-12'),
(18, 5, 10, 'Status updated to Shipped', '2025-03-12'),
(19, 5, 10, 'Status updated to Delivered', '2025-03-12'),
(23, 5, 5, 'Status updated to Delivered', '2025-03-12'),
(24, 1, 11, 'Order Created', '2025-03-13'),
(25, 1, 11, 'Status updated to Shipped', '2025-03-13'),
(26, 1, 3, 'Status updated to Processing', '2025-03-14'),
(27, 1, 3, 'Status updated to Shipped', '2025-03-14'),
(28, 1, 3, 'Status updated to Shipped', '2025-03-14'),
(29, 11, 12, 'Order Created', '2025-03-14'),
(56, 5, 9, 'Returned', '2025-03-16'),
(57, 11, 12, 'Status updated to Processing', '2025-03-17'),
(58, 1, 13, 'Order Created', '2025-03-17'),
(59, 1, 8, 'Status updated to Returned', '2025-03-17'),
(60, 5, 14, 'Order Created', '2025-03-17'),
(61, 5, 14, 'Returned', '2025-03-17'),
(62, 5, 14, 'Status updated to Returned', '2025-03-17'),
(67, 10, 15, 'Order Created', '2025-03-17'),
(68, 10, 16, 'Order Created', '2025-03-17'),
(70, 10, 17, 'Order Created', '2025-03-17'),
(71, 10, 18, 'Order Created', '2025-03-17'),
(72, 10, 19, 'Order Created', '2025-03-17'),
(73, 10, 20, 'Order Created', '2025-03-17'),
(74, 10, 15, 'Status updated to Returned', '2025-03-17'),
(75, 5, 10, 'Returned', '2025-03-17'),
(76, 5, 4, 'Returned', '2025-03-17'),
(77, 5, 9, 'Returned', '2025-03-17'),
(80, 5, 21, 'Order Created', '2025-03-17'),
(81, 5, 21, 'Status updated to Delivered', '2025-03-17'),
(82, 10, 20, 'Status updated to Delivered', '2025-03-17'),
(83, 10, 19, 'Status updated to Delivered', '2025-03-17'),
(84, 10, 18, 'Status updated to Delivered', '2025-03-17'),
(85, 10, 17, 'Status updated to Delivered', '2025-03-17'),
(86, 10, 16, 'Status updated to Delivered', '2025-03-17'),
(87, 1, 13, 'Status updated to Delivered', '2025-03-17'),
(88, 5, 10, 'Status updated to Delivered', '2025-03-17'),
(89, 5, 9, 'Status updated to Delivered', '2025-03-17'),
(90, 5, 4, 'Status updated to Delivered', '2025-03-17'),
(94, 5, 5, 'Returned', '2025-03-17'),
(95, 14, 22, 'Order Created', '2025-03-18'),
(96, 14, 22, 'Status updated to Processing', '2025-03-18'),
(97, 14, 22, 'Status updated to Shipped', '2025-03-18'),
(98, 14, 22, 'Status updated to Delivered', '2025-03-18'),
(99, 14, 22, 'Returned', '2025-03-18'),
(100, 14, 22, 'Status updated to Returned', '2025-03-18'),
(101, 7, 23, 'Order Created', '2025-03-19'),
(102, 7, 24, 'Order Created', '2025-03-19'),
(103, 7, 25, 'Order Created', '2025-03-19'),
(104, 7, 26, 'Order Created', '2025-03-19'),
(105, 7, 27, 'Order Created', '2025-03-19'),
(106, 7, 28, 'Order Created', '2025-03-19'),
(107, 7, 29, 'Order Created', '2025-03-19'),
(108, 7, 30, 'Order Created', '2025-03-19'),
(109, 7, 31, 'Order Created', '2025-03-19'),
(110, 7, 32, 'Order Created', '2025-03-19'),
(111, 1, 33, 'Order Created', '2025-03-19'),
(112, 7, 23, 'Status updated to Delivered', '2025-03-20'),
(113, 7, 24, 'Status updated to Delivered', '2025-03-20'),
(114, 7, 25, 'Status updated to Delivered', '2025-03-20'),
(115, 7, 26, 'Status updated to Delivered', '2025-03-20'),
(116, 7, 27, 'Status updated to Delivered', '2025-03-20'),
(117, 7, 28, 'Status updated to Delivered', '2025-03-20'),
(118, 7, 29, 'Status updated to Delivered', '2025-03-20'),
(119, 7, 30, 'Status updated to Delivered', '2025-03-20'),
(120, 7, 31, 'Status updated to Delivered', '2025-03-20'),
(121, 7, 32, 'Status updated to Delivered', '2025-03-20'),
(122, 7, 23, 'Returned', '2025-03-21'),
(123, 7, 24, 'Returned', '2025-03-21'),
(124, 7, 34, 'Order Created', '2025-03-21'),
(125, 7, 34, 'Status updated to Delivered', '2025-03-21'),
(126, 7, 34, 'Returned', '2025-03-21'),
(127, 7, 35, 'Order Created', '2025-03-21'),
(128, 7, 35, 'Status updated to Delivered', '2025-03-21'),
(129, 7, 35, 'Returned', '2025-03-21'),
(130, 7, 36, 'Order Created', '2025-03-21'),
(131, 7, 36, 'Status updated to Delivered', '2025-03-21'),
(132, 7, 35, 'Status updated to Returned', '2025-03-21'),
(133, 7, 34, 'Status updated to Returned', '2025-03-21'),
(134, 7, 36, 'Returned', '2025-03-21'),
(135, 7, 36, 'Returned', '2025-03-21'),
(136, 7, 36, 'Status updated to Delivered', '2025-03-21'),
(137, 7, 36, 'Returned', '2025-03-21'),
(138, 7, 37, 'Order Created', '2025-03-22'),
(139, 7, 38, 'Order Created', '2025-03-22'),
(140, 7, 39, 'Order Created', '2025-03-22'),
(141, 7, 40, 'Order Created', '2025-03-22'),
(142, 7, 41, 'Order Created', '2025-03-22'),
(143, 7, 42, 'Order Created', '2025-03-22'),
(144, 7, 43, 'Order Created', '2025-03-22'),
(145, 7, 44, 'Order Created', '2025-03-22'),
(146, 1, 45, 'Order Created', '2025-03-22'),
(147, 1, 13, 'Returned', '2025-03-22');

-- --------------------------------------------------------

--
-- Table structure for table `OrderItem`
--

CREATE TABLE `OrderItem` (
  `orderItemID` int NOT NULL,
  `orderID` int NOT NULL,
  `productID` int NOT NULL,
  `Quantity` int NOT NULL,
  `itemPrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `OrderItem`
--

INSERT INTO `OrderItem` (`orderItemID`, `orderID`, `productID`, `Quantity`, `itemPrice`) VALUES
(1, 1, 6, 1, 299.99),
(2, 1, 54, 1, 249.99),
(3, 1, 46, 2, 69.99),
(4, 2, 42, 1, 389.99),
(5, 2, 43, 1, 499.99),
(6, 3, 65, 1, 19.99),
(7, 3, 62, 1, 209.99),
(8, 4, 42, 1, 389.99),
(9, 4, 95, 1, 599.99),
(10, 5, 54, 1, 249.99),
(11, 5, 51, 1, 59.99),
(12, 6, 45, 1, 499.99),
(13, 7, 54, 1, 249.99),
(14, 8, 41, 1, 479.99),
(15, 9, 41, 1, 479.99),
(16, 9, 46, 3, 69.99),
(17, 9, 62, 1, 209.99),
(18, 10, 41, 1, 479.99),
(19, 11, 115, 1, 149.99),
(20, 12, 41, 1, 479.99),
(21, 12, 61, 1, 459.99),
(22, 12, 65, 1, 19.99),
(23, 12, 72, 1, 24.99),
(24, 13, 45, 1, 499.99),
(25, 14, 46, 1, 69.99),
(26, 14, 41, 1, 479.99),
(27, 15, 54, 1, 249.99),
(28, 16, 54, 1, 249.99),
(29, 17, 41, 1, 479.99),
(30, 18, 41, 1, 479.99),
(31, 19, 43, 1, 499.99),
(32, 20, 6, 1, 299.99),
(33, 21, 7, 1, 249.99),
(34, 21, 6, 1, 299.99),
(35, 22, 61, 2, 459.99),
(36, 22, 41, 1, 479.99),
(37, 23, 11, 1, 69.99),
(38, 24, 43, 1, 499.99),
(39, 25, 2, 1, 22.99),
(40, 26, 94, 1, 89.99),
(41, 27, 95, 1, 599.99),
(42, 28, 6, 1, 299.99),
(43, 29, 22, 1, 69.99),
(44, 30, 22, 1, 69.99),
(45, 31, 21, 1, 15.99),
(46, 32, 12, 1, 11.99),
(47, 33, 42, 1, 389.99),
(48, 34, 42, 1, 389.99),
(49, 34, 43, 1, 499.99),
(50, 35, 42, 1, 389.99),
(51, 35, 43, 2, 499.99),
(52, 36, 43, 1, 499.99),
(53, 36, 42, 2, 389.99),
(54, 37, 1, 1, 30.00),
(55, 37, 22, 1, 69.99),
(56, 38, 82, 1, 529.99),
(57, 38, 83, 1, 719.99),
(58, 39, 2, 1, 22.99),
(59, 39, 3, 1, 44.99),
(60, 40, 61, 1, 459.99),
(61, 40, 65, 1, 19.99),
(62, 41, 42, 1, 389.99),
(63, 41, 48, 1, 64.99),
(64, 42, 42, 1, 389.99),
(65, 42, 49, 1, 54.99),
(66, 43, 83, 1, 719.99),
(67, 43, 86, 1, 49.99),
(68, 44, 3, 1, 44.99),
(69, 44, 13, 1, 8.99),
(70, 45, 46, 4, 69.99);

-- --------------------------------------------------------

--
-- Table structure for table `OrderRatings`
--

CREATE TABLE `OrderRatings` (
  `ratingID` int NOT NULL,
  `orderID` int NOT NULL,
  `customerID` int NOT NULL,
  `overall_rating` int NOT NULL,
  `website_rating` int NOT NULL,
  `delivery_rating` int NOT NULL,
  `product_rating` int NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_520_ci,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `OrderRatings`
--

INSERT INTO `OrderRatings` (`ratingID`, `orderID`, `customerID`, `overall_rating`, `website_rating`, `delivery_rating`, `product_rating`, `comments`, `date`) VALUES
(1, 45, 1, 4, 3, 3, 5, 'works/?', '2025-03-22');

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE `Orders` (
  `orderID` int NOT NULL,
  `customerID` int DEFAULT NULL,
  `totalPrice` decimal(10,2) NOT NULL,
  `orderDate` date NOT NULL,
  `orderStatus` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `shippingDate` date DEFAULT NULL,
  `BillingAddress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `ShippingAddress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `paymentID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `Orders`
--

INSERT INTO `Orders` (`orderID`, `customerID`, `totalPrice`, `orderDate`, `orderStatus`, `shippingDate`, `BillingAddress`, `ShippingAddress`, `paymentID`) VALUES
(1, 1, 694.95, '2025-02-26', 'Pending', NULL, 'Mary Sturge Residences Aston Street', 'Mary Sturge Residences Aston Street', 15),
(2, 1, 894.97, '2025-02-26', 'Delivered', NULL, 'Mary Sturge Residences Aston Street', 'Mary Sturge Residences Aston Street', 16),
(3, 1, 234.97, '2025-03-04', 'Shipped', '2025-03-14', 'Mary Sturge Residences Aston Street', 'Mary Sturge Residences Aston Street', 17),
(4, 5, 994.97, '2025-03-05', 'Delivered', NULL, '1 ', '1 ', 18),
(5, 5, 314.97, '2025-03-05', 'Pending', NULL, '1 ', '1 ', 19),
(6, 1, 504.98, '2025-03-06', 'Delivered', NULL, 'Mary Sturge Residences Aston Street', 'Mary Sturge Residences Aston Street', 20),
(7, 1, 254.98, '2025-03-06', 'Pending', NULL, 'Mary Sturge Residences Aston Street', 'Mary Sturge Residences Aston Street', 21),
(8, 1, 484.98, '2025-03-06', 'Returned', NULL, 'Mary Sturge Residences Aston Street', 'Mary Sturge Residences Aston Street', 22),
(9, 5, 899.95, '2025-03-12', 'Delivered', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 23),
(10, 5, 479.99, '2025-03-12', 'Delivered', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 24),
(11, 1, 154.98, '2025-03-13', 'Shipped', '2025-03-13', 'Mary Sturge Residences Aston Street', 'Mary Sturge Residences Aston Street', 25),
(12, 11, 989.95, '2025-03-14', 'Processing', NULL, 'bckjbxjkbczjk ', 'bckjbxjkbczjk ', 26),
(13, 1, 499.99, '2025-03-17', 'Pending', NULL, 'Mary Sturge Residences Aston Street', 'Mary Sturge Residences Aston Street', 27),
(14, 5, 549.98, '2025-03-17', 'Returned', NULL, '43 Surley Row ', '43 Surley Row ', 28),
(15, 10, 249.99, '2025-03-17', 'Returned', NULL, 'Mary Sturge Residences Aston Street', 'Mary Sturge Residences Aston Street', 29),
(16, 10, 249.99, '2025-03-17', 'Delivered', NULL, 'Mary Sturge Residences Aston Street', 'Mary Sturge Residences Aston Street', 30),
(17, 10, 484.98, '2025-03-17', 'Delivered', NULL, 'Mary Sturge Residences Aston Street', 'Mary Sturge Residences Aston Street', 31),
(18, 10, 479.99, '2025-03-17', 'Delivered', NULL, 'Mary Sturge Residences Aston Street', 'Mary Sturge Residences Aston Street', 32),
(19, 10, 504.98, '2025-03-17', 'Delivered', NULL, 'Mary Sturge Residences Aston Street', 'Mary Sturge Residences Aston Street', 33),
(20, 10, 304.98, '2025-03-17', 'Delivered', NULL, 'Mary Sturge Residency aston st', 'Mary Sturge Residency aston st', 34),
(21, 5, 549.98, '2025-03-17', 'Delivered', NULL, '43 Surley Row ', '43 Surley Row ', 35),
(22, 14, 1399.97, '2025-03-18', 'Returned', NULL, '43 Surley Row ', '43 Surley Row ', 36),
(23, 7, 74.98, '2025-03-19', 'Pending', NULL, '43 Surley Row ', '43 Surley Row ', 37),
(24, 7, 504.98, '2025-03-19', 'Pending', NULL, '43 Surley Row ', '43 Surley Row ', 38),
(25, 7, 22.99, '2025-03-19', 'Delivered', NULL, '43 Surley Row ', '43 Surley Row ', 39),
(26, 7, 89.99, '2025-03-19', 'Delivered', NULL, '43 Surley Row ', '43 Surley Row ', 40),
(27, 7, 599.99, '2025-03-19', 'Delivered', NULL, '43 Surley Row ', '43 Surley Row ', 41),
(28, 7, 299.99, '2025-03-19', 'Delivered', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 42),
(29, 7, 69.99, '2025-03-19', 'Delivered', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 43),
(30, 7, 69.99, '2025-03-19', 'Delivered', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 44),
(31, 7, 15.99, '2025-03-19', 'Delivered', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 45),
(32, 7, 11.99, '2025-03-19', 'Delivered', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 46),
(33, 1, 394.98, '2025-03-19', 'Pending', NULL, 'Mary Sturge Residences Aston Street', 'Mary Sturge Residences Aston Street', 47),
(34, 7, 889.98, '2025-03-21', 'Returned', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 48),
(35, 7, 1389.97, '2025-03-21', 'Returned', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 49),
(36, 7, 1279.97, '2025-03-21', 'Pending', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 50),
(37, 7, 99.99, '2025-03-22', 'Pending', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 51),
(38, 7, 1249.98, '2025-03-22', 'Pending', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 52),
(39, 7, 67.98, '2025-03-22', 'Pending', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 53),
(40, 7, 479.98, '2025-03-22', 'Pending', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 54),
(41, 7, 454.98, '2025-03-22', 'Pending', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 55),
(42, 7, 444.98, '2025-03-22', 'Pending', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 56),
(43, 7, 769.98, '2025-03-22', 'Pending', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 57),
(44, 7, 53.98, '2025-03-22', 'Pending', NULL, '43 Surely Row Emmer Green', '43 Surely Row Emmer Green', 58),
(45, 1, 284.95, '2025-03-22', 'Pending', NULL, 'Mary Sturge Residences Aston Street', 'Mary Sturge Residences Aston Street', 59);

-- --------------------------------------------------------

--
-- Table structure for table `Payment`
--

CREATE TABLE `Payment` (
  `paymentID` int NOT NULL,
  `orderID` int DEFAULT NULL,
  `paymentDate` date NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `paymentMethod` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `Payment`
--

INSERT INTO `Payment` (`paymentID`, `orderID`, `paymentDate`, `Amount`, `paymentMethod`) VALUES
(15, 1, '2025-02-26', 694.95, 'Credit Card'),
(16, 2, '2025-02-26', 894.97, 'Credit Card'),
(17, 3, '2025-03-04', 234.97, 'Credit Card'),
(18, 4, '2025-03-05', 994.97, 'Credit Card'),
(19, 5, '2025-03-05', 314.97, 'Credit Card'),
(20, 6, '2025-03-06', 504.98, 'Credit Card'),
(21, 7, '2025-03-06', 254.98, 'Credit Card'),
(22, 8, '2025-03-06', 484.98, 'Credit Card'),
(23, 9, '2025-03-12', 899.95, 'Credit Card'),
(24, 10, '2025-03-12', 479.99, 'Credit Card'),
(25, 11, '2025-03-13', 154.98, 'Credit Card'),
(26, 12, '2025-03-14', 989.95, 'Credit Card'),
(27, 13, '2025-03-17', 499.99, 'Credit Card'),
(28, 14, '2025-03-17', 549.98, 'Credit Card'),
(29, 15, '2025-03-17', 249.99, 'Credit Card'),
(30, 16, '2025-03-17', 249.99, 'Credit Card'),
(31, 17, '2025-03-17', 484.98, 'Credit Card'),
(32, 18, '2025-03-17', 479.99, 'Credit Card'),
(33, 19, '2025-03-17', 504.98, 'Credit Card'),
(34, 20, '2025-03-17', 304.98, 'Credit Card'),
(35, 21, '2025-03-17', 549.98, 'Credit Card'),
(36, 22, '2025-03-18', 1399.97, 'Credit Card'),
(37, 23, '2025-03-19', 74.98, 'Credit Card'),
(38, 24, '2025-03-19', 504.98, 'Credit Card'),
(39, 25, '2025-03-19', 22.99, 'Credit Card'),
(40, 26, '2025-03-19', 89.99, 'Credit Card'),
(41, 27, '2025-03-19', 599.99, 'Credit Card'),
(42, 28, '2025-03-19', 299.99, 'Credit Card'),
(43, 29, '2025-03-19', 69.99, 'Credit Card'),
(44, 30, '2025-03-19', 69.99, 'Credit Card'),
(45, 31, '2025-03-19', 15.99, 'Credit Card'),
(46, 32, '2025-03-19', 11.99, 'Credit Card'),
(47, 33, '2025-03-19', 394.98, 'Credit Card'),
(48, 34, '2025-03-21', 889.98, 'Credit Card'),
(49, 35, '2025-03-21', 1389.97, 'Credit Card'),
(50, 36, '2025-03-21', 1279.97, 'Credit Card'),
(51, 37, '2025-03-22', 99.99, 'Credit Card'),
(52, 38, '2025-03-22', 1249.98, 'Credit Card'),
(53, 39, '2025-03-22', 67.98, 'Credit Card'),
(54, 40, '2025-03-22', 479.98, 'Credit Card'),
(55, 41, '2025-03-22', 454.98, 'Credit Card'),
(56, 42, '2025-03-22', 444.98, 'Credit Card'),
(57, 43, '2025-03-22', 769.98, 'Credit Card'),
(58, 44, '2025-03-22', 53.98, 'Credit Card'),
(59, 45, '2025-03-22', 284.95, 'Credit Card');

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `productID` int NOT NULL,
  `ModelNo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fullName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  `Price` decimal(10,2) NOT NULL,
  `Supplier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `categoryID` int NOT NULL,
  `imgURL` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  `stockQuantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`productID`, `ModelNo`, `fullName`, `Description`, `Price`, `Supplier`, `categoryID`, `imgURL`, `stockQuantity`) VALUES
(1, 'NJUST25', 'Just Dance 2025', 'Dance game for Nintendo Switch', 30.00, NULL, 1, 'images/NITENDO GAME 1.avif', 99),
(2, 'NMINE01', 'Minecraft for Nintendo Switch', 'Nintendo Switch version of Minecraft', 22.99, NULL, 1, 'images/NITENDO GAME 3.avif', 98),
(3, 'NMARIO1', 'Super Mario Bros. Wonder', 'Latest Mario adventure', 44.99, NULL, 1, 'images/NITENDO GAME 4.avif', 98),
(4, 'NFC25', 'EA Sports FC 25', 'Football game for Nintendo Switch', 40.00, NULL, 1, 'images/NITENDO GAME 5.avif', 100),
(5, 'NCRASH1', 'Crash Bandicoot N. Sane Trilogy', 'Classic Crash Bandicoot collection', 20.00, NULL, 1, 'images/NITENDO GAME 6.avif', 100),
(6, 'NSW-OLED1', 'Nintendo Switch (OLED model) + Mario Wonder + 12 Months NSO', 'OLED Switch bundle', 299.99, NULL, 2, 'images/Trending - switch.webp', 47),
(7, 'NSW-NEON1', 'Nintendo Switch - Neon (Improved Battery)', 'Standard Switch with better battery', 249.99, NULL, 2, 'images/NC2.jpg', 49),
(8, 'NSW-SPORT1', 'Nintendo Switch (Neon Red/Neon Blue) Switch Sports + 12 Months NSO', 'Switch Sports bundle', 249.99, NULL, 2, 'images/NC4.jpg', 50),
(9, 'NSW-OLED2', 'Nintendo Switch - White (OLED Model)', 'White OLED Switch', 309.99, NULL, 2, 'images/NC3.jpg', 50),
(10, 'NSW-LITE1', 'Nintendo Switch Lite - Turquoise', 'Portable-only Switch', 199.99, NULL, 2, 'images/NC5.jpg', 50),
(11, 'NSW-JOY1', 'Nintendo Switch Joy-Con Pair: Blue/Yellow', 'Official Joy-Con controllers', 69.99, NULL, 3, 'images/NSC1.avif', 99),
(12, 'NSW-WHEEL1', 'Subsonic Red and Blue Duo Racing Wheels For Switch', 'Racing wheel accessories', 11.99, NULL, 3, 'images/NSC2.avif', 99),
(13, 'NSW-GRIP1', 'Numskull Joy Con Grips for Switch', 'Controller grips', 8.99, NULL, 3, 'images/NSC3.avif', 99),
(14, 'NSW-WAVE1', 'Afterglow Wave Wireless Controller White', 'Third-party controller', 45.99, NULL, 3, 'images/NSC4.avif', 100),
(15, 'NSW-PRIS1', 'Prismatic Switch Wireless Controller', 'Wireless controller', 30.99, NULL, 3, 'images/NSC5.avif', 100),
(16, 'NSO-12M', 'Nintendo Switch Online 12 Month Membership', 'Online service subscription', 19.99, NULL, 4, 'images/NS12M.jpg', 999),
(17, 'NSO-EXP12M', 'Nintendo NSO + Expansion Pack 12 Month Membership', 'Premium online subscription', 34.99, NULL, 4, 'images/NS12EXPANSION.jpg', 999),
(18, 'NSO-3M', 'Nintendo Switch Online 3 Month Membership', 'Short-term online subscription', 6.99, NULL, 4, 'images/NS2M.jpg', 999),
(19, 'NSW-MARIO-PASS', 'Mario Kart 8 Deluxe Booster Course Pass', 'DLC for Mario Kart 8', 24.99, NULL, 4, 'images/NSMARIOPASS.jpg', 999),
(20, 'NSW-POKE-PASS', 'Pokémon Scarlet or Violet Expansion Pass', 'DLC for Pokemon games', 35.00, NULL, 4, 'images/NSPPASS.jpg', 999),
(21, 'TB-REC50', 'Turtle Beach Recon 50 Headset - Black', 'Entry-level gaming headset', 15.99, NULL, 5, 'images/HEADSET 1.avif', 99),
(22, 'RZ-KRK-V3X', 'Razer Kraken V3 X USB Wired Gaming Headset', 'USB gaming headset', 69.99, NULL, 5, 'images/HEADSET 2.avif', 97),
(23, 'TB-REC70', 'Turtle Beach Recon 70 Headset for PC', 'Gaming headset', 29.99, NULL, 5, 'images/HEADSET 3.avif', 100),
(24, 'RZ-FORT-HS', 'Razer - Fortnite Wired PC Gaming Headset', 'Fortnite themed headset', 39.99, NULL, 5, 'images/HEADSET 6.avif', 100),
(25, 'JBL-QUANTUM', 'JBL Quantum Gaming Headset for PC', 'Premium gaming headset', 149.99, NULL, 5, 'images/HEADSET 4.avif', 100),
(26, 'TR-GXT865', 'Trust GXT 865 Asta Mechanical Keyboard', 'Mechanical gaming keyboard', 69.99, NULL, 6, 'images/KB1.avif', 100),
(27, 'TR-GXT833W', 'Trust GXT 833W Thado TKL Keyboard - White', 'TKL keyboard', 22.99, NULL, 6, 'images/KB3.avif', 100),
(28, 'RZ-DA-ESS', 'Razer DeathAdder Essential Mouse - Black', 'Gaming mouse', 24.99, NULL, 7, 'images/M1.avif', 100),
(29, 'TR-GXT109B', 'Trust GXT 109B Felox Gaming Mouse', 'Budget gaming mouse', 9.99, NULL, 7, 'images/M2.avif', 100),
(30, 'LOG-G203', 'Logitech G203 Lightsync Gaming Mouse', 'RGB gaming mouse', 23.00, NULL, 7, 'images/M3.avif', 100),
(31, 'HX-QUAD', 'HyperX Quadcast Microphone', 'Streaming microphone', 89.99, NULL, 8, 'images/MIC1.jpg', 50),
(32, 'RZ-SEIREN-V3', 'Razer Seiren V3 Chroma Microphone', 'Premium RGB microphone', 189.99, NULL, 8, 'images/MIC2.avif', 50),
(33, 'NS-LED-MIC', 'Numskull LED Microphone', 'LED gaming microphone', 24.99, NULL, 8, 'images/MIC3.avif', 50),
(34, 'TR-GXT234', 'TRUST GXT234 YUNIX USB MIC', 'USB microphone', 29.99, NULL, 8, 'images/MIC4.avif', 50),
(35, 'RZ-SV3-MINI', 'Seiren V3 Mini Microphone - White', 'Compact microphone', 59.99, NULL, 8, 'images/MIC6.avif', 50),
(36, 'MSI-G27CQ4', 'MSI G27CQ4 E2 Gaming Monitor', 'Curved gaming monitor', 218.99, NULL, 9, 'images/Monitor1.avif', 30),
(37, 'ASUS-VG249', 'ASUS TUF Gaming VG249QL3A Monitor', 'Gaming monitor', 199.99, NULL, 9, 'images/Monitor2.avif', 30),
(38, 'ASUS-CG32UQ', 'ASUS CG32UQ HDR Console Gaming Monitor - 32inch 4K', '4K HDR monitor', 449.99, NULL, 9, 'images/Monitor3.avif', 30),
(39, 'LG-27UG', 'LG PC KB LG 27 UG QHD MNTR 165hz', 'QHD gaming monitor', 279.99, NULL, 9, 'images/Monitor4.avif', 30),
(40, 'MSI-G255F', 'MSI G255F Gaming Monitor', 'Gaming monitor', 149.99, NULL, 9, 'images/Monitor5.avif', 30),
(41, 'PS5-SLIM', 'PlayStation 5 Slim (Disc Version)', 'Latest slim model PS5', 479.99, NULL, 10, 'images/ps5-slim.jpg', 45),
(42, 'PS5-DE', 'PlayStation 5 Digital Edition', 'Digital edition console', 389.99, NULL, 10, 'images/digitaledition-ps5.jpg', 50),
(43, 'PS5-FORT', 'PS5 Fortnite Bundle', 'PS5 console with Fortnite extras', 499.99, NULL, 10, 'images/PS FORTNITE DEAL.avif', 48),
(44, 'PS5-COD', 'PS5 Call of Duty: Modern Warfare II Bundle', 'PS5 with COD MWII', 499.99, NULL, 10, 'images/Callofdutyps5bundle.jpg', 50),
(45, 'PS5-SPM', 'PS5 Marvel\'s Spider-Man 2 Bundle', 'PS5 with Spider-Man 2', 499.99, NULL, 10, 'images/spidermanps5bundle.jpg', 50),
(46, 'PS5-FC25', 'EA Sports FC 25', 'Latest football game', 69.99, NULL, 11, 'images/Trending - Fifa.webp', 10),
(47, 'PS5-SM2', 'Marvel\'s Spider-Man 2', 'Spider-Man sequel', 59.99, NULL, 11, 'images/spiderman2ps5.jpg', 100),
(48, 'PS5-MW3', 'Call of Duty: Modern Warfare III', 'Latest COD game', 64.99, NULL, 11, 'images/mw3ps5.jpg', 99),
(49, 'PS5-NBA24', 'NBA 2K24', 'Basketball simulation', 54.99, NULL, 11, 'images/Nba2k24ps5.jpg', 99),
(50, 'PS5-HL', 'Hogwarts Legacy', 'Harry Potter RPG', 49.99, NULL, 11, 'images/hogwartslegacyps5.jpg', 100),
(51, 'PS5-DS', 'DualSense Wireless Controller', 'Standard PS5 controller', 59.99, NULL, 12, 'images/ps5-controller.jpg', 100),
(52, 'PS5-PULSE', 'PULSE 3D Wireless Headset', 'Official PS5 headset', 89.99, NULL, 12, 'images/ps5-headphones.jpg', 100),
(53, 'PS5-CHRG', 'DualSense Charging Station', 'Controller charging dock', 34.99, NULL, 12, 'images/chargingstationps5.jpg', 100),
(54, 'PS5-PORT', 'PS5 Portable', 'Remote play device', 249.99, NULL, 12, 'images/ps5portal.jpg', 48),
(55, 'PS5-CAM', 'PS5 HD Camera', 'HD camera for streaming', 49.99, NULL, 12, 'images/ps5camera.jpg', 50),
(56, 'PS-PLUS-ESS', 'PlayStation Plus Essential - 12 Months', 'Basic PS Plus subscription', 59.99, NULL, 13, 'images/psplus-essential.jpg', 999),
(57, 'PS-PLUS-EXT', 'PlayStation Plus Extra - 12 Months', 'Premium PS Plus subscription', 99.99, NULL, 13, 'images/ps5plus-extra.png', 999),
(58, 'PSN-20', 'PlayStation Store Gift Card - £20', '£20 PSN credit', 20.00, NULL, 13, 'images/20GBPps5.jpg', 999),
(59, 'PSN-50', 'PlayStation Store Gift Card - £50', '£50 PSN credit', 50.00, NULL, 13, 'images/50GBPps5.jpg', 999),
(60, 'PSN-100', 'PlayStation Store Gift Card - £100', '£100 PSN credit', 100.00, NULL, 13, 'images/100GBPps5.jpg', 999),
(61, 'XBX-SERX', 'Microsoft Xbox Series X', 'Premium Xbox console', 459.99, NULL, 14, 'images/XBOXCONSOLE1.avif', 46),
(62, 'XBX-SERS-512', 'Microsoft Xbox Series S 512GB', 'Digital-only Xbox', 209.99, NULL, 14, 'images/XBOXCONSOLE2.avif', 50),
(63, 'XBX-SERS-1TB', 'Microsoft Xbox Series S 1TB Robot White', 'Digital-only Xbox with larger storage', 299.99, NULL, 14, 'images/XBOXCONSOLE3.avif', 50),
(64, 'XBX-FC25', 'EA Sports FC 25', 'Football game for xbox', 60.00, NULL, 15, 'images/FC25 XBOX.avif', 100),
(65, 'XBX-MC', 'MINECRAFT', 'Building game for xbox', 19.99, NULL, 15, 'images/MINECRAFT XBOX.avif', 98),
(66, 'XBX-FS25', 'Farming Simulator 25', 'Farming simulation', 52.99, NULL, 15, 'images/FARMSIMU XBOX.avif', 100),
(67, 'XBX-SW-OUT', 'Star Wars - Outlaws', 'Star Wars action game', 34.99, NULL, 15, 'images/STARWARS XBOX.avif', 100),
(68, 'XBX-UFC5', 'EA Sports UFC 5', 'Fighting game', 59.99, NULL, 15, 'images/UFC25 XBOX.avif', 100),
(69, 'XBX-WWE24', 'WWE 2K24', 'Wrestling game', 20.00, NULL, 15, 'images/WWE2K24 XBOX.jpg', 100),
(70, 'XBX-LS10X', 'LucidSound LS10X Wired Gaming Headset', 'Gaming headset', 19.99, NULL, 16, 'images/XBOXHS1.avif', 100),
(71, 'XBX-TB500', 'Turtle Beach Stealth 500 Headset', 'Premium headset', 89.99, NULL, 16, 'images/XBOXHS2.avif', 100),
(72, 'XBX-TB70', 'Turtle Beach Recon 70 Multi-Platform Black Headset', 'Multi-platform headset', 24.99, NULL, 16, 'images/XBOXHS3.avif', 99),
(73, 'XBX-CTRL-BLK', 'Xbox Series X & S Controller - Carbon Black', 'Standard controller', 49.99, NULL, 16, 'images/XBOXBLACK.avif', 100),
(74, 'XBX-CTRL-GRN', 'Xbox Wireless Controller - Velocity Green', 'Green controller', 49.99, NULL, 16, 'images/XBOXGREEN.avif', 100),
(75, 'XBX-CTRL-WHT', 'Xbox Series X & S Controller - Robot White', 'White controller', 49.99, NULL, 16, 'images/XBOXWHITE.avif', 100),
(76, 'XBX-GP-12M', 'Xbox Game Pass Core - 12 Month Membership', 'Year subscription', 49.99, NULL, 17, 'images/12GP.avif', 999),
(77, 'XBX-GP-3M', 'Xbox Game Pass Core - 3 Month Membership', 'Quarter subscription', 19.99, NULL, 17, 'images/3GP.avif', 999),
(78, 'XBX-GC-50', '£50 Xbox Gift Card - Digital Code', '£50 credit', 50.00, NULL, 17, 'images/50GC.webp', 999),
(79, 'XBX-GC-10', '£10 Xbox Gift Card - Digital Code', '£10 credit', 10.00, NULL, 17, 'images/10GC.webp', 999),
(80, 'XBX-GC-20', '£20 Xbox Gift Card - Digital Code', '£20 credit', 20.00, NULL, 17, 'images/20GF.avif', 999),
(81, 'XBX-GC-15', '£15 Xbox Gift Card - Digital Code', '£15 credit', 15.00, NULL, 17, 'images/15GC.webp', 999),
(82, 'MQ3-128', 'Meta Quest 3 (128GB)', 'Latest Meta Quest', 529.99, NULL, 18, 'images/New Releases - MQ.webp', 49),
(83, 'HTC-VP2', 'HTC Vive Pro 2', 'Premium VR headset', 719.99, NULL, 18, 'images/vive.jpg', 48),
(84, 'MQ2-128', 'Meta Quest 2 (128GB)', 'Previous gen Meta Quest', 489.99, NULL, 18, 'images/quest2.jpg', 50),
(85, 'VR-BEATS', 'Beat Saber', 'Rhythm VR game', 29.99, NULL, 19, 'images/beat-saber.jpg', 100),
(86, 'VR-AZ2', 'Arizona Sunshine 2', 'Zombie VR game', 49.99, NULL, 19, 'images/arizona.jpg', 99),
(87, 'VR-AMONG', 'Among Us VR', 'Social deduction in VR', 14.99, NULL, 19, 'images/among-us-vr.png', 100),
(88, 'VR-RE4', 'Resident Evil 4 VR', 'Horror VR game', 39.99, NULL, 19, 'images/resident-evil-4.jpg', 100),
(89, 'VR-FACE', 'Premium VR Facial Interface', 'Comfort accessory', 29.99, NULL, 20, 'images/vr-facial-interface.png', 100),
(90, 'VR-STRAP', 'Elite Head Strap with Battery', 'Enhanced comfort strap', 89.99, NULL, 20, 'images/vr-headstrap.jpg', 100),
(91, 'VR-CASE', 'Premium VR Carrying Case', 'Protection case', 49.99, NULL, 20, 'images/vr-case.jpg', 100),
(92, 'VR-POWER', '10000mAh VR Power Bank', 'Extended battery life', 69.99, NULL, 20, 'images/vr-powerbank.jpeg', 100),
(93, 'BUN-PS5-SPM', 'PlayStation5 with spiderman game for FREE!', 'Console bundle', 329.99, NULL, 21, 'images/off1.png', 30),
(94, 'BUN-XBX-RZR', 'Razer Duo Bundle for Xbox', 'Accessory bundle', 89.99, NULL, 21, 'images/xboxb.png', 49),
(95, 'BUN-PC-STAR', 'STAR Gaming PC bundle', 'Complete PC setup', 599.99, NULL, 21, 'images/off4.png', 19),
(96, 'BUN-NSW-MK', 'Nintendo Switch with mariokart game for FREE!', 'Console bundle', 269.99, NULL, 21, 'images/off2.png', 30),
(97, 'BUN-VR-CTRL', 'VR Headset with two controllers', 'VR bundle', 459.99, NULL, 21, 'images/off5.png', 30),
(98, 'BUN-PS5-CTRL', 'Playstation 5 with two controllers', 'Console bundle', 299.99, NULL, 21, 'images/ps5a.png', 30),
(99, 'BUN-PS5-PORT', 'Playstation 5 with Playstation Portal', 'Console portal bundle', 449.99, NULL, 21, 'images/ps5b.png', 30),
(100, 'BUN-PS5-PULSE', 'Playstation 5 with Playstation (PULSE) Headset', 'Console audio bundle', 349.99, NULL, 21, 'images/ps5c.png', 30),
(101, 'BUN-XBX-FC24', 'Xbox Series X with FC 24 game', 'Console game bundle', 499.99, NULL, 21, 'images/xboxa.png', 30),
(102, 'BUN-XBX-GP24', 'Xbox Series X with 24 months Ultimate Gamepass', 'Console subscription bundle', 499.99, NULL, 21, 'images/xboxc.png', 30),
(103, 'BUN-XBX-CLD', 'Xbox Series X with CloudX headset', 'Console audio bundle', 359.99, NULL, 21, 'images/xboxd.png', 30),
(104, 'BUN-XBX-CTRL', 'Xbox Series X with two controllers', 'Console controller bundle', 529.99, NULL, 21, 'images/xboxe.png', 30),
(105, 'BUN-NSW-AC', 'Nintendo Switch Lite with Animal Crossing game', 'Console game bundle', 199.99, NULL, 21, 'images/nina.png', 30),
(106, 'BUN-NSW-CTRL', 'Nintendo Switch Lite with extra controller', 'Console controller bundle', 289.99, NULL, 21, 'images/ninb.png', 30),
(107, 'BUN-NSW-MARIO', 'Nintendo Switch OLED with Super Mario Bros + Switch Online 1 Year', 'Complete Nintendo bundle', 149.99, NULL, 21, 'images/ninc.png', 30),
(108, 'BUN-NSW-KART', 'Nintendo Switch OLED with Mario Kart + Racing Wheels', 'Racing bundle', 299.99, NULL, 21, 'images/nind.png', 30),
(109, 'BUN-PC-WRLS', 'Wireless Gaming Keyboard Mouse bundle', 'PC accessory bundle', 49.99, NULL, 21, 'images/pca.png', 50),
(110, 'BUN-PC-HX', 'HyperX Bundle', 'PC accessory bundle', 129.99, NULL, 21, 'images/pcb.png', 50),
(111, 'BUN-PC-STORM', 'Stormforce Onyx R5 16GB 1TB Gaming PC Bundle', 'Complete PC bundle', 649.99, NULL, 21, 'images/pcc.png', 20),
(112, 'BUN-PC-VIBOX', 'Vibox II-12 Gaming PC Bundle', 'Complete PC bundle', 729.99, NULL, 21, 'images/pcd.png', 20),
(113, 'BUN-VR-RE4', 'Meta Quest 2 256GB Resident Evil 4 Bundle', 'VR game bundle', 499.99, NULL, 21, 'images/vra.png', 30),
(114, 'BUN-VR-PSVR', 'Playstation Full VR Bundle', 'Complete VR bundle', 489.99, NULL, 21, 'images/vrb.png', 30),
(115, 'BUN-VR-PS-CAM', 'Sony PlayStation VR Bundle with Camera and 2 Motion Controllers', 'VR accessory bundle', 149.99, NULL, 21, 'images/psvr2.jpg', 29),
(116, 'BUN-VR-AIM', 'Aim Controller Farpoint Bundle', 'VR controller bundle', 199.99, NULL, 21, 'images/vrd.png', 30);

-- --------------------------------------------------------

--
-- Table structure for table `Returns`
--

CREATE TABLE `Returns` (
  `returnID` int NOT NULL,
  `orderID` int NOT NULL,
  `returnReason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci,
  `returnReasonExplanation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `Returns`
--

INSERT INTO `Returns` (`returnID`, `orderID`, `returnReason`, `returnReasonExplanation`) VALUES
(4, 5, 'notAsExpected', 'I got an elephant instead of a controller'),
(5, 22, 'broken', 'it got smashed'),
(6, 23, 'notAsExpected', 'They were both red'),
(7, 24, 'broken', 'I dropped it down the stairs'),
(8, 34, 'notAsExpected', 'I got a unicorn'),
(9, 35, 'unwantedGift', 'My stalker gave it to me'),
(10, 36, 'wrongItemSent', 'I got bananaes instead'),
(11, 36, 'wrongItemSent', 'I got bananaes instead'),
(12, 36, 'wrongItemSent', 'i got a foot isntead'),
(13, 13, 'notAsExpected', '');

-- --------------------------------------------------------

--
-- Table structure for table `Wishlist`
--

CREATE TABLE `Wishlist` (
  `wishlistID` int NOT NULL,
  `customerID` int NOT NULL,
  `createdDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `Wishlist`
--

INSERT INTO `Wishlist` (`wishlistID`, `customerID`, `createdDate`) VALUES
(1, 5, '2025-02-17'),
(2, 1, '2025-03-06'),
(3, 7, '2025-03-12'),
(4, 9, '2025-03-12'),
(5, 4, '2025-03-12'),
(6, 11, '2025-03-14');

-- --------------------------------------------------------

--
-- Table structure for table `WishlistItem`
--

CREATE TABLE `WishlistItem` (
  `wishlistItemID` int NOT NULL,
  `wishlistID` int NOT NULL,
  `productID` int NOT NULL,
  `Quantity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `WishlistItem`
--

INSERT INTO `WishlistItem` (`wishlistItemID`, `wishlistID`, `productID`, `Quantity`) VALUES
(27, 3, 46, 1),
(43, 6, 54, 1),
(44, 6, 15, 1),
(47, 5, 46, 1),
(51, 2, 82, 1),
(59, 1, 46, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Basket`
--
ALTER TABLE `Basket`
  ADD PRIMARY KEY (`basketID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `BasketItem`
--
ALTER TABLE `BasketItem`
  ADD PRIMARY KEY (`basketItemID`),
  ADD KEY `basketID` (`basketID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`customerID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `Employee`
--
ALTER TABLE `Employee`
  ADD PRIMARY KEY (`employeeID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `Inventory`
--
ALTER TABLE `Inventory`
  ADD PRIMARY KEY (`inventoryID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `ItemReview`
--
ALTER TABLE `ItemReview`
  ADD PRIMARY KEY (`itemReviewID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `OrderHistory`
--
ALTER TABLE `OrderHistory`
  ADD PRIMARY KEY (`orderHistoryID`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `orderID` (`orderID`);

--
-- Indexes for table `OrderItem`
--
ALTER TABLE `OrderItem`
  ADD PRIMARY KEY (`orderItemID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `OrderRatings`
--
ALTER TABLE `OrderRatings`
  ADD PRIMARY KEY (`ratingID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `paymentID` (`paymentID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `Payment`
--
ALTER TABLE `Payment`
  ADD PRIMARY KEY (`paymentID`);

--
-- Indexes for table `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`productID`),
  ADD UNIQUE KEY `ModelNo` (`ModelNo`),
  ADD KEY `categoryID` (`categoryID`);

--
-- Indexes for table `Returns`
--
ALTER TABLE `Returns`
  ADD PRIMARY KEY (`returnID`),
  ADD KEY `orderID` (`orderID`);

--
-- Indexes for table `Wishlist`
--
ALTER TABLE `Wishlist`
  ADD PRIMARY KEY (`wishlistID`),
  ADD KEY `customerID` (`customerID`);

--
-- Indexes for table `WishlistItem`
--
ALTER TABLE `WishlistItem`
  ADD PRIMARY KEY (`wishlistItemID`),
  ADD KEY `wishlistID` (`wishlistID`),
  ADD KEY `productID` (`productID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Basket`
--
ALTER TABLE `Basket`
  MODIFY `basketID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `BasketItem`
--
ALTER TABLE `BasketItem`
  MODIFY `basketItemID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `categoryID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `Customer`
--
ALTER TABLE `Customer`
  MODIFY `customerID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `Employee`
--
ALTER TABLE `Employee`
  MODIFY `employeeID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Inventory`
--
ALTER TABLE `Inventory`
  MODIFY `inventoryID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ItemReview`
--
ALTER TABLE `ItemReview`
  MODIFY `itemReviewID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `OrderHistory`
--
ALTER TABLE `OrderHistory`
  MODIFY `orderHistoryID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `OrderItem`
--
ALTER TABLE `OrderItem`
  MODIFY `orderItemID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `OrderRatings`
--
ALTER TABLE `OrderRatings`
  MODIFY `ratingID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Orders`
--
ALTER TABLE `Orders`
  MODIFY `orderID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `Payment`
--
ALTER TABLE `Payment`
  MODIFY `paymentID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `productID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `Returns`
--
ALTER TABLE `Returns`
  MODIFY `returnID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `Wishlist`
--
ALTER TABLE `Wishlist`
  MODIFY `wishlistID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `WishlistItem`
--
ALTER TABLE `WishlistItem`
  MODIFY `wishlistItemID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Basket`
--
ALTER TABLE `Basket`
  ADD CONSTRAINT `Basket_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `Customer` (`customerID`);

--
-- Constraints for table `BasketItem`
--
ALTER TABLE `BasketItem`
  ADD CONSTRAINT `BasketItem_ibfk_1` FOREIGN KEY (`basketID`) REFERENCES `Basket` (`basketID`),
  ADD CONSTRAINT `BasketItem_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `Products` (`productID`);

--
-- Constraints for table `Employee`
--
ALTER TABLE `Employee`
  ADD CONSTRAINT `Employee_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `Customer` (`customerID`);

--
-- Constraints for table `Inventory`
--
ALTER TABLE `Inventory`
  ADD CONSTRAINT `Inventory_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `Products` (`productID`);

--
-- Constraints for table `ItemReview`
--
ALTER TABLE `ItemReview`
  ADD CONSTRAINT `ItemReview_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `Products` (`productID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `OrderHistory`
--
ALTER TABLE `OrderHistory`
  ADD CONSTRAINT `OrderHistory_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `Customer` (`customerID`),
  ADD CONSTRAINT `OrderHistory_ibfk_2` FOREIGN KEY (`orderID`) REFERENCES `Orders` (`orderID`);

--
-- Constraints for table `OrderItem`
--
ALTER TABLE `OrderItem`
  ADD CONSTRAINT `OrderItem_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `Orders` (`orderID`),
  ADD CONSTRAINT `OrderItem_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `Products` (`productID`);

--
-- Constraints for table `OrderRatings`
--
ALTER TABLE `OrderRatings`
  ADD CONSTRAINT `OrderRatings_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `Orders` (`orderID`),
  ADD CONSTRAINT `OrderRatings_ibfk_2` FOREIGN KEY (`customerID`) REFERENCES `Customer` (`customerID`);

--
-- Constraints for table `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`paymentID`) REFERENCES `Payment` (`paymentID`),
  ADD CONSTRAINT `Orders_ibfk_2` FOREIGN KEY (`customerID`) REFERENCES `Customer` (`customerID`);

--
-- Constraints for table `Products`
--
ALTER TABLE `Products`
  ADD CONSTRAINT `Products_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `Category` (`categoryID`);

--
-- Constraints for table `Returns`
--
ALTER TABLE `Returns`
  ADD CONSTRAINT `orderID` FOREIGN KEY (`orderID`) REFERENCES `Orders` (`orderID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `Wishlist`
--
ALTER TABLE `Wishlist`
  ADD CONSTRAINT `Wishlist_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `Customer` (`customerID`);

--
-- Constraints for table `WishlistItem`
--
ALTER TABLE `WishlistItem`
  ADD CONSTRAINT `WishlistItem_ibfk_1` FOREIGN KEY (`wishlistID`) REFERENCES `Wishlist` (`wishlistID`),
  ADD CONSTRAINT `WishlistItem_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `Products` (`productID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
