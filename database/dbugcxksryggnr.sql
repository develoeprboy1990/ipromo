-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 16, 2023 at 09:40 AM
-- Server version: 5.7.39-42-log
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbugcxksryggnr`
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `CompanyID` bigint(20) UNSIGNED NOT NULL,
  `Name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Name2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `TRN` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'tax registration no',
  `Currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Contact` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Address` text COLLATE utf8mb4_unicode_ci,
  `Logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `BackgroundLogo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Signature` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DigitalSignature` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EstimateInvoiceTitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `SaleInvoiceTitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DeliveryChallanTitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CreditNoteTitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PurchaseInvoiceTitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DebitNoteTitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`CompanyID`, `Name`, `Name2`, `TRN`, `Currency`, `Mobile`, `Contact`, `Email`, `Website`, `Address`, `Logo`, `BackgroundLogo`, `Signature`, `DigitalSignature`, `EstimateInvoiceTitle`, `SaleInvoiceTitle`, `DeliveryChallanTitle`, `CreditNoteTitle`, `PurchaseInvoiceTitle`, `DebitNoteTitle`, `created_at`, `updated_at`) VALUES
(1, 'Promo Deals', '(PVT) LTD', '123456789', 'MYR', NULL, '009232323232', 'info@promo.ae', 'www.roomsos.com', 'Adress', '1680632089.png', '1680632089.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-28 09:46:01', '2023-07-28 09:46:01');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerID` int(11) NOT NULL,
  `AgentID` int(11) DEFAULT NULL,
  `CustomerName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CustomerPhone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CustomerEmail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CustomerCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `AgentID`, `CustomerName`, `CustomerPhone`, `CustomerEmail`, `CustomerCreated`) VALUES
(1, 2, 'Ibrar', '093423252345', NULL, '2023-07-28 07:40:00'),
(2, 7, 'Mudasir', '42423432432', NULL, '2023-07-30 07:37:07'),
(3, 7, 'Shah', '398487283947', NULL, '2023-07-28 10:33:22'),
(4, 2, 'Test', '12345', NULL, '2023-07-31 15:14:46'),
(5, 2, 'Andrew Mak', '01126926899', NULL, '2023-07-30 18:00:07'),
(6, 2, 'Sajjad', '03479806600', NULL, '2023-08-02 06:43:01'),
(7, 7, 'Andrew Mak', '12345678', NULL, '2023-08-15 09:16:30');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `OfferID` int(11) NOT NULL,
  `Title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Description` text COLLATE utf8mb4_unicode_ci,
  `Image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Days` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Created_At` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`OfferID`, `Title`, `Description`, `Image`, `Days`, `Created_At`) VALUES
(1, 'Signup before this timer is up, to get this mini fridge, Act Now!', 'Signup before this timer is up, to get this mini fridge, Act Now!', 'mini_fridge.jpg', '2', '2023-07-27 20:20:00'),
(2, '(You have missed the 1st Offer)', 'Signup before this timer is up, to get this mini washer, Act Now!', 'mini_washing.jpg', '3', '2023-07-29 04:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` bigint(20) UNSIGNED NOT NULL,
  `FullName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `UserType` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Active` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `FullName`, `Email`, `Password`, `Phone`, `UserType`, `Active`, `eDate`) VALUES
(1, 'Admin', 'demo@test.com', '123456', '12345678', 'Admin', 'Yes', '2023-07-29 15:05:18'),
(2, 'Ahsan', 'user@test.com', '123456', '12345678', 'Agent', 'Yes', '2023-07-28 19:00:00'),
(7, 'Andrew', 'Andrew', '123456', '01126926899', 'Agent', 'Yes', '2023-07-30 09:20:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`CompanyID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`OfferID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `user_email_unique` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `CompanyID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `OfferID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
