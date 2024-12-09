-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 09, 2024 at 10:24 AM
-- Server version: 8.0.40-0ubuntu0.20.04.1
-- PHP Version: 8.3.14

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
(1, 1, '2024-12-09');

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
(1, 1, 6, 1),
(4, 1, 46, 1),
(10, 1, 54, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE `Category` (
  `categoryID` int NOT NULL,
  `categoryName` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL
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
(21, 'Bundle Deals'),
(22, 'Nintendo Games'),
(23, 'Nintendo Consoles'),
(24, 'Nintendo Controllers'),
(25, 'Nintendo Digital'),
(26, 'PC Headsets'),
(27, 'PC Keyboards'),
(28, 'PC Mice'),
(29, 'PC Microphones'),
(30, 'PC Monitors'),
(31, 'PS5 Consoles'),
(32, 'PS5 Games'),
(33, 'PS5 Accessories'),
(34, 'PS5 Digital'),
(35, 'XBOX Consoles'),
(36, 'XBOX Games'),
(37, 'XBOX Accessories'),
(38, 'XBOX Digital'),
(39, 'VR Headsets'),
(40, 'VR Games'),
(41, 'VR Accessories'),
(42, 'Bundle Deals'),
(43, 'Nintendo Games'),
(44, 'Nintendo Consoles'),
(45, 'Nintendo Controllers'),
(46, 'Nintendo Digital'),
(47, 'PC Headsets'),
(48, 'PC Keyboards'),
(49, 'PC Mice'),
(50, 'PC Microphones'),
(51, 'PC Monitors'),
(52, 'PS5 Consoles'),
(53, 'PS5 Games'),
(54, 'PS5 Accessories'),
(55, 'PS5 Digital'),
(56, 'XBOX Consoles'),
(57, 'XBOX Games'),
(58, 'XBOX Accessories'),
(59, 'XBOX Digital'),
(60, 'VR Headsets'),
(61, 'VR Games'),
(62, 'VR Accessories'),
(63, 'Bundle Deals');

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `customerID` int NOT NULL,
  `fullName` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `RegistrationDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`customerID`, `fullName`, `Email`, `Password`, `RegistrationDate`) VALUES
(1, 'cameron hisham', 'abc@gmail.com', '$2y$10$8u01LuOcPbkk6BEibgiZm.TIXrcFGMnLyEz3WFPLw0OTtwXtkMjlm', '2024-12-09');

-- --------------------------------------------------------

--
-- Table structure for table `Employee`
--

CREATE TABLE `Employee` (
  `employeeID` int NOT NULL,
  `fullName` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `position` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Inventory`
--

CREATE TABLE `Inventory` (
  `inventoryID` int NOT NULL,
  `thresholdLevel` int NOT NULL,
  `productID` int NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `InventoryAlert`
--

CREATE TABLE `InventoryAlert` (
  `alertID` int NOT NULL,
  `inventoryID` int NOT NULL,
  `alertType` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `alertDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `OrderHistory`
--

CREATE TABLE `OrderHistory` (
  `orderHistoryID` int NOT NULL,
  `customerID` int NOT NULL,
  `orderID` int NOT NULL,
  `Action` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `ActionDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE `Orders` (
  `orderID` int NOT NULL,
  `customerID` int DEFAULT NULL,
  `totalPrice` decimal(10,2) NOT NULL,
  `orderDate` date NOT NULL,
  `orderStatus` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `shippingDate` date DEFAULT NULL,
  `BillingAddress` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `ShippingAddress` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `paymentID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Payment`
--

CREATE TABLE `Payment` (
  `paymentID` int NOT NULL,
  `orderID` int DEFAULT NULL,
  `paymentDate` date NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `paymentMethod` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `productID` int NOT NULL,
  `ModelNo` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `fullName` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `Description` text COLLATE utf8mb4_unicode_520_ci,
  `Price` decimal(10,2) NOT NULL,
  `Supplier` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `categoryID` int NOT NULL,
  `imgURL` text COLLATE utf8mb4_unicode_520_ci,
  `stockQuantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`productID`, `ModelNo`, `fullName`, `Description`, `Price`, `Supplier`, `categoryID`, `imgURL`, `stockQuantity`) VALUES
(1, 'NJUST25', 'Just Dance 2025', 'Dance game for Nintendo Switch', 30.00, NULL, 1, 'images/NITENDO GAME 1.avif', 100),
(2, 'NMINE01', 'Minecraft for Nintendo Switch', 'Nintendo Switch version of Minecraft', 22.99, NULL, 1, 'images/NITENDO GAME 3.avif', 100),
(3, 'NMARIO1', 'Super Mario Bros. Wonder', 'Latest Mario adventure', 44.99, NULL, 1, 'images/NITENDO GAME 4.avif', 100),
(4, 'NFC25', 'EA Sports FC 25', 'Football game for Nintendo Switch', 40.00, NULL, 1, 'images/NITENDO GAME 5.avif', 100),
(5, 'NCRASH1', 'Crash Bandicoot N. Sane Trilogy', 'Classic Crash Bandicoot collection', 20.00, NULL, 1, 'images/NITENDO GAME 6.avif', 100),
(6, 'NSW-OLED1', 'Nintendo Switch (OLED model) + Mario Wonder + 12 Months NSO', 'OLED Switch bundle', 299.99, NULL, 2, 'images/Trending - switch.webp', 50),
(7, 'NSW-NEON1', 'Nintendo Switch - Neon (Improved Battery)', 'Standard Switch with better battery', 249.99, NULL, 2, 'images/NC2.jpg', 50),
(8, 'NSW-SPORT1', 'Nintendo Switch (Neon Red/Neon Blue) Switch Sports + 12 Months NSO', 'Switch Sports bundle', 249.99, NULL, 2, 'images/NC4.jpg', 50),
(9, 'NSW-OLED2', 'Nintendo Switch - White (OLED Model)', 'White OLED Switch', 309.99, NULL, 2, 'images/NC3.jpg', 50),
(10, 'NSW-LITE1', 'Nintendo Switch Lite - Turquoise', 'Portable-only Switch', 199.99, NULL, 2, 'images/NC5.jpg', 50),
(11, 'NSW-JOY1', 'Nintendo Switch Joy-Con Pair: Blue/Yellow', 'Official Joy-Con controllers', 69.99, NULL, 3, 'images/NSC1.avif', 100),
(12, 'NSW-WHEEL1', 'Subsonic Red and Blue Duo Racing Wheels For Switch', 'Racing wheel accessories', 11.99, NULL, 3, 'images/NSC2.avif', 100),
(13, 'NSW-GRIP1', 'Numskull Joy Con Grips for Switch', 'Controller grips', 8.99, NULL, 3, 'images/NSC3.avif', 100),
(14, 'NSW-WAVE1', 'Afterglow Wave Wireless Controller White', 'Third-party controller', 45.99, NULL, 3, 'images/NSC4.avif', 100),
(15, 'NSW-PRIS1', 'Prismatic Switch Wireless Controller', 'Wireless controller', 30.99, NULL, 3, 'images/NSC5.avif', 100),
(16, 'NSO-12M', 'Nintendo Switch Online 12 Month Membership', 'Online service subscription', 19.99, NULL, 4, 'images/NS12M.jpg', 999),
(17, 'NSO-EXP12M', 'Nintendo NSO + Expansion Pack 12 Month Membership', 'Premium online subscription', 34.99, NULL, 4, 'images/NS12EXPANSION.jpg', 999),
(18, 'NSO-3M', 'Nintendo Switch Online 3 Month Membership', 'Short-term online subscription', 6.99, NULL, 4, 'images/NS2M.jpg', 999),
(19, 'NSW-MARIO-PASS', 'Mario Kart 8 Deluxe Booster Course Pass', 'DLC for Mario Kart 8', 24.99, NULL, 4, 'images/NSMARIOPASS.jpg', 999),
(20, 'NSW-POKE-PASS', 'Pokémon Scarlet or Violet Expansion Pass', 'DLC for Pokemon games', 35.00, NULL, 4, 'images/NSPPASS.jpg', 999),
(21, 'TB-REC50', 'Turtle Beach Recon 50 Headset - Black', 'Entry-level gaming headset', 15.99, NULL, 5, 'images/HEADSET 1.avif', 100),
(22, 'RZ-KRK-V3X', 'Razer Kraken V3 X USB Wired Gaming Headset', 'USB gaming headset', 69.99, NULL, 5, 'images/HEADSET 2.avif', 100),
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
(41, 'PS5-SLIM', 'PlayStation 5 Slim (Disc Version)', 'Latest slim model PS5', 479.99, NULL, 10, 'images/ps5-slim.jpg', 50),
(42, 'PS5-DE', 'PlayStation 5 Digital Edition', 'Digital edition console', 389.99, NULL, 10, 'images/digitaledition-ps5.jpg', 50),
(43, 'PS5-FORT', 'PS5 Fortnite Bundle', 'PS5 console with Fortnite extras', 499.99, NULL, 10, 'images/PS FORTNITE DEAL.avif', 50),
(44, 'PS5-COD', 'PS5 Call of Duty: Modern Warfare II Bundle', 'PS5 with COD MWII', 499.99, NULL, 10, 'images/Callofdutyps5bundle.jpg', 50),
(45, 'PS5-SPM', 'PS5 Marvel\'s Spider-Man 2 Bundle', 'PS5 with Spider-Man 2', 499.99, NULL, 10, 'images/spidermanps5bundle.jpg', 50),
(46, 'PS5-FC25', 'EA Sports FC 25', 'Latest football game', 69.99, NULL, 11, 'images/Trending - Fifa.webp', 100),
(47, 'PS5-SM2', 'Marvel\'s Spider-Man 2', 'Spider-Man sequel', 59.99, NULL, 11, 'images/spiderman2ps5.jpg', 100),
(48, 'PS5-MW3', 'Call of Duty: Modern Warfare III', 'Latest COD game', 64.99, NULL, 11, 'images/mw3ps5.jpg', 100),
(49, 'PS5-NBA24', 'NBA 2K24', 'Basketball simulation', 54.99, NULL, 11, 'images/Nba2k24ps5.jpg', 100),
(50, 'PS5-HL', 'Hogwarts Legacy', 'Harry Potter RPG', 49.99, NULL, 11, 'images/hogwartslegacyps5.jpg', 100),
(51, 'PS5-DS', 'DualSense Wireless Controller', 'Standard PS5 controller', 59.99, NULL, 12, 'images/ps5-controller.jpg', 100),
(52, 'PS5-PULSE', 'PULSE 3D Wireless Headset', 'Official PS5 headset', 89.99, NULL, 12, 'images/ps5-headphones.jpg', 100),
(53, 'PS5-CHRG', 'DualSense Charging Station', 'Controller charging dock', 34.99, NULL, 12, 'images/chargingstationps5.jpg', 100),
(54, 'PS5-PORT', 'PS5 Portable', 'Remote play device', 249.99, NULL, 12, 'images/ps5portal.jpg', 50),
(55, 'PS5-CAM', 'PS5 HD Camera', 'HD camera for streaming', 49.99, NULL, 12, 'images/ps5camera.jpg', 50),
(56, 'PS-PLUS-ESS', 'PlayStation Plus Essential - 12 Months', 'Basic PS Plus subscription', 59.99, NULL, 13, 'images/psplus-essential.jpg', 999),
(57, 'PS-PLUS-EXT', 'PlayStation Plus Extra - 12 Months', 'Premium PS Plus subscription', 99.99, NULL, 13, 'images/ps5plus-extra.png', 999),
(58, 'PSN-20', 'PlayStation Store Gift Card - £20', '£20 PSN credit', 20.00, NULL, 13, 'images/20GBPps5.jpg', 999),
(59, 'PSN-50', 'PlayStation Store Gift Card - £50', '£50 PSN credit', 50.00, NULL, 13, 'images/50GBPps5.jpg', 999),
(60, 'PSN-100', 'PlayStation Store Gift Card - £100', '£100 PSN credit', 100.00, NULL, 13, 'images/100GBPps5.jpg', 999),
(61, 'XBX-SERX', 'Microsoft Xbox Series X', 'Premium Xbox console', 459.99, NULL, 14, 'images/XBOXCONSOLE1.avif', 50),
(62, 'XBX-SERS-512', 'Microsoft Xbox Series S 512GB', 'Digital-only Xbox', 209.99, NULL, 14, 'images/XBOXCONSOLE2.avif', 50),
(63, 'XBX-SERS-1TB', 'Microsoft Xbox Series S 1TB Robot White', 'Digital-only Xbox with larger storage', 299.99, NULL, 14, 'images/XBOXCONSOLE3.avif', 50),
(64, 'XBX-FC25', 'EA Sports FC 25', 'Football game for xbox', 60.00, NULL, 15, 'images/FC25 XBOX.avif', 100),
(65, 'XBX-MC', 'MINECRAFT', 'Building game for xbox', 19.99, NULL, 15, 'images/MINECRAFT XBOX.avif', 100),
(66, 'XBX-FS25', 'Farming Simulator 25', 'Farming simulation', 52.99, NULL, 15, 'images/FARMSIMU XBOX.avif', 100),
(67, 'XBX-SW-OUT', 'Star Wars - Outlaws', 'Star Wars action game', 34.99, NULL, 15, 'images/STARWARS XBOX.avif', 100),
(68, 'XBX-UFC5', 'EA Sports UFC 5', 'Fighting game', 59.99, NULL, 15, 'images/UFC25 XBOX.avif', 100),
(69, 'XBX-WWE24', 'WWE 2K24', 'Wrestling game', 20.00, NULL, 15, 'images/WWE2K24 XBOX.jpg', 100),
(70, 'XBX-LS10X', 'LucidSound LS10X Wired Gaming Headset', 'Gaming headset', 19.99, NULL, 16, 'images/XBOXHS1.avif', 100),
(71, 'XBX-TB500', 'Turtle Beach Stealth 500 Headset', 'Premium headset', 89.99, NULL, 16, 'images/XBOXHS2.avif', 100),
(72, 'XBX-TB70', 'Turtle Beach Recon 70 Multi-Platform Black Headset', 'Multi-platform headset', 24.99, NULL, 16, 'images/XBOXHS3.avif', 100),
(73, 'XBX-CTRL-BLK', 'Xbox Series X & S Controller - Carbon Black', 'Standard controller', 49.99, NULL, 16, 'images/XBOXBLACK.avif', 100),
(74, 'XBX-CTRL-GRN', 'Xbox Wireless Controller - Velocity Green', 'Green controller', 49.99, NULL, 16, 'images/XBOXGREEN.avif', 100),
(75, 'XBX-CTRL-WHT', 'Xbox Series X & S Controller - Robot White', 'White controller', 49.99, NULL, 16, 'images/XBOXWHITE.avif', 100),
(76, 'XBX-GP-12M', 'Xbox Game Pass Core - 12 Month Membership', 'Year subscription', 49.99, NULL, 17, 'images/12GP.avif', 999),
(77, 'XBX-GP-3M', 'Xbox Game Pass Core - 3 Month Membership', 'Quarter subscription', 19.99, NULL, 17, 'images/3GP.avif', 999),
(78, 'XBX-GC-50', '£50 Xbox Gift Card - Digital Code', '£50 credit', 50.00, NULL, 17, 'images/50GC.webp', 999),
(79, 'XBX-GC-10', '£10 Xbox Gift Card - Digital Code', '£10 credit', 10.00, NULL, 17, 'images/10GC.webp', 999),
(80, 'XBX-GC-20', '£20 Xbox Gift Card - Digital Code', '£20 credit', 20.00, NULL, 17, 'images/20GF.avif', 999),
(81, 'XBX-GC-15', '£15 Xbox Gift Card - Digital Code', '£15 credit', 15.00, NULL, 17, 'images/15GC.webp', 999),
(82, 'MQ3-128', 'Meta Quest 3 (128GB)', 'Latest Meta Quest', 529.99, NULL, 18, 'images/New Releases - MQ.webp', 50),
(83, 'HTC-VP2', 'HTC Vive Pro 2', 'Premium VR headset', 719.99, NULL, 18, 'images/vive.jpg', 50),
(84, 'MQ2-128', 'Meta Quest 2 (128GB)', 'Previous gen Meta Quest', 489.99, NULL, 18, 'images/quest2.jpg', 50),
(85, 'VR-BEATS', 'Beat Saber', 'Rhythm VR game', 29.99, NULL, 19, 'images/beat-saber.jpg', 100),
(86, 'VR-AZ2', 'Arizona Sunshine 2', 'Zombie VR game', 49.99, NULL, 19, 'images/arizona.jpg', 100),
(87, 'VR-AMONG', 'Among Us VR', 'Social deduction in VR', 14.99, NULL, 19, 'images/among-us-vr.png', 100),
(88, 'VR-RE4', 'Resident Evil 4 VR', 'Horror VR game', 39.99, NULL, 19, 'images/resident-evil-4.jpg', 100),
(89, 'VR-FACE', 'Premium VR Facial Interface', 'Comfort accessory', 29.99, NULL, 20, 'images/vr-facial-interface.png', 100),
(90, 'VR-STRAP', 'Elite Head Strap with Battery', 'Enhanced comfort strap', 89.99, NULL, 20, 'images/vr-headstrap.jpg', 100),
(91, 'VR-CASE', 'Premium VR Carrying Case', 'Protection case', 49.99, NULL, 20, 'images/vr-case.jpg', 100),
(92, 'VR-POWER', '10000mAh VR Power Bank', 'Extended battery life', 69.99, NULL, 20, 'images/vr-powerbank.jpeg', 100),
(93, 'BUN-PS5-SPM', 'PlayStation5 with spiderman game for FREE!', 'Console bundle', 329.99, NULL, 21, 'images/off1.png', 30),
(94, 'BUN-XBX-RZR', 'Razer Duo Bundle for Xbox', 'Accessory bundle', 89.99, NULL, 21, 'images/xboxb.png', 50),
(95, 'BUN-PC-STAR', 'STAR Gaming PC bundle', 'Complete PC setup', 599.99, NULL, 21, 'images/off4.png', 20),
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
(115, 'BUN-VR-PS-CAM', 'Sony PlayStation VR Bundle with Camera and 2 Motion Controllers', 'VR accessory bundle', 149.99, NULL, 21, 'images/psvr2.jpg', 30),
(116, 'BUN-VR-AIM', 'Aim Controller Farpoint Bundle', 'VR controller bundle', 199.99, NULL, 21, 'images/vrd.png', 30);

-- --------------------------------------------------------

--
-- Table structure for table `Wishlist`
--

CREATE TABLE `Wishlist` (
  `wishlistID` int NOT NULL,
  `customerID` int NOT NULL,
  `createdDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `WishlistItem`
--

CREATE TABLE `WishlistItem` (
  `wishlistItemID` int NOT NULL,
  `wishlistID` int NOT NULL,
  `productID` int NOT NULL,
  `addDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

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
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `Inventory`
--
ALTER TABLE `Inventory`
  ADD PRIMARY KEY (`inventoryID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `InventoryAlert`
--
ALTER TABLE `InventoryAlert`
  ADD PRIMARY KEY (`alertID`),
  ADD KEY `inventoryID` (`inventoryID`);

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
  MODIFY `basketID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `BasketItem`
--
ALTER TABLE `BasketItem`
  MODIFY `basketItemID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `Category`
--
ALTER TABLE `Category`
  MODIFY `categoryID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `Customer`
--
ALTER TABLE `Customer`
  MODIFY `customerID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Employee`
--
ALTER TABLE `Employee`
  MODIFY `employeeID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Inventory`
--
ALTER TABLE `Inventory`
  MODIFY `inventoryID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `InventoryAlert`
--
ALTER TABLE `InventoryAlert`
  MODIFY `alertID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `OrderHistory`
--
ALTER TABLE `OrderHistory`
  MODIFY `orderHistoryID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `OrderItem`
--
ALTER TABLE `OrderItem`
  MODIFY `orderItemID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Orders`
--
ALTER TABLE `Orders`
  MODIFY `orderID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Payment`
--
ALTER TABLE `Payment`
  MODIFY `paymentID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `productID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `Wishlist`
--
ALTER TABLE `Wishlist`
  MODIFY `wishlistID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `WishlistItem`
--
ALTER TABLE `WishlistItem`
  MODIFY `wishlistItemID` int NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `Inventory`
--
ALTER TABLE `Inventory`
  ADD CONSTRAINT `Inventory_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `Products` (`productID`);

--
-- Constraints for table `InventoryAlert`
--
ALTER TABLE `InventoryAlert`
  ADD CONSTRAINT `InventoryAlert_ibfk_1` FOREIGN KEY (`inventoryID`) REFERENCES `Inventory` (`inventoryID`);

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
