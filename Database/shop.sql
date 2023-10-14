-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2023 at 08:56 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Arrange` int(11) NOT NULL,
  `Visibllity` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT '0',
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `Arrange`, `Visibllity`, `Allow_Comment`, `Allow_Ads`) VALUES
(1, 'Games', ' In Here You Will Find Any Game You Think of', 1, 1, 1, 1),
(3, 'PCs', 'Best Collection In The World', 7, 0, 0, 0),
(4, 'Phones', 'Any Thing With Electisety', 4, 0, 0, 0),
(5, 'Home Made', 'Home made Stuffe', 4, 1, 1, 1),
(6, 'Pages', 'asdasd', 5, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `ID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Item_ID` int(11) NOT NULL,
  `Approved` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`ID`, `Comment`, `User_ID`, `Item_ID`, `Approved`) VALUES
(1, '                Hello World             asdasd ', 10, 1, 1),
(2, '                Hello World 2   asdasd           ', 10, 1, 1),
(3, 'Hello World 3', 11, 1, 1),
(4, 'Hello World 4', 11, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `Made_Country` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `Image` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approved` tinyint(4) NOT NULL DEFAULT '0',
  `Cat_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ID`, `Name`, `Description`, `Price`, `Date`, `Made_Country`, `Image`, `Status`, `Rating`, `Approved`, `Cat_ID`, `User_ID`) VALUES
(1, 'Gaming RGB PC', 'The Monster Of Gaming', '$2000', '2001-07-20', 'China', '', '1', 0, 1, 3, 8),
(2, 'Back Page', ' asdfaiusdh', '$10', '2023-08-10', 'Syria', '', '1', 0, 1, 6, 8),
(3, 'iPhone 6 s ', 'A Nice Phone', '$600', '2023-08-14', 'China', '', '1', 0, 1, 4, 8),
(4, 'Iphone x ', 'A Nice Phone 2', '$1800', '2023-08-14', 'china', '', '1', 0, 1, 4, 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL COMMENT 'User Identify',
  `Username` varchar(255) NOT NULL COMMENT 'Name To Login',
  `Password` varchar(255) NOT NULL COMMENT 'Password To Login',
  `Email` varchar(255) NOT NULL,
  `Fullname` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0' COMMENT 'Identify User Group',
  `TrustStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'Seller Rank',
  `Approved` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'User Aprovel',
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `Username`, `Password`, `Email`, `Fullname`, `GroupID`, `TrustStatus`, `Approved`, `Date`) VALUES
(8, 'Abood', '44b5a029d79117ab40de9c44a0f3d3041e454941', 'Abdsadalden@gmail.com', 'Abd Alrhman Saad Aldeen', 1, 1, 1, '2001-07-20'),
(10, 'Ahmad', '44b5a029d79117ab40de9c44a0f3d3041e454941', 'Ahmad@gmail.com', 'Ahmad', 0, 0, 1, '2023-08-05'),
(11, 'Omar', '2cd2de8e52de5691f59352a91777416be46035a6', 'omar@gmail.com', 'Omar Saad Alden', 0, 0, 1, '2023-08-05'),
(12, 'Amiad', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 'Amjad@gmail.com', 'Amjad ', 0, 0, 1, '2023-08-10'),
(13, 'Hamza', '44b5a029d79117ab40de9c44a0f3d3041e454941', 'hamza@gmail.com', 'Hamza', 0, 0, 1, '2023-08-10'),
(14, 'mohamad', '44b5a029d79117ab40de9c44a0f3d3041e454941', 'mohamad@gmail.com', 'mohamad', 0, 0, 1, '2023-08-10'),
(15, 'mahmod', '44b5a029d79117ab40de9c44a0f3d3041e454941', 'mahmod@gmail.com', 'asdasd', 0, 0, 1, '2023-08-17'),
(16, 'asd', 'd5644e8105ad77c3c3324ba693e83d8fffd54950', 'sadasd@asdad.com', 'asdad', 0, 0, 0, '2023-08-17'),
(17, 'asd', 'd5644e8105ad77c3c3324ba693e83d8fffd54950', 'sadasd@asdad.com', 'asdad', 0, 0, 0, '2023-08-17'),
(18, 'asd', 'd5644e8105ad77c3c3324ba693e83d8fffd54950', 'sadasd@asdad.com', 'asdad', 0, 0, 0, '2023-08-17'),
(19, 'asd', 'd5644e8105ad77c3c3324ba693e83d8fffd54950', 'sadasd@asdad.com', 'asdad', 0, 0, 0, '2023-08-17'),
(20, 'asd', 'd5644e8105ad77c3c3324ba693e83d8fffd54950', 'sadasd@asdad.com', 'asdad', 0, 0, 0, '2023-08-17'),
(21, 'hasan', '44b5a029d79117ab40de9c44a0f3d3041e454941', 'hasan@gmail.com', 'hasan', 0, 0, 0, '2023-08-17'),
(22, 'rama', '44b5a029d79117ab40de9c44a0f3d3041e454941', 'rama@gmail.com', 'rama', 0, 0, 0, '2023-08-17'),
(23, 'sad', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'asdasd@gmail.com', 'asdasd', 0, 0, 0, '2023-08-19'),
(24, 'sss', '601f1889667efaebb33b8c12572835da3f027f78', 'sss@gmail.com', 'sss', 0, 0, 0, '2023-08-19'),
(25, 'eee', '601f1889667efaebb33b8c12572835da3f027f78', 'eee@gmail.com', 'eee', 0, 0, 1, '2023-08-19'),
(26, 'hhh', '281446ac89c045e94c5768398fa27040f58d59dc', 'hhh@gmail.com', 'hhh', 0, 0, 0, '2023-08-20'),
(27, 'er', '44b5a029d79117ab40de9c44a0f3d3041e454941', 'er@gmail.com', 'er', 0, 0, 0, '2023-08-20'),
(28, 'ww', '44b5a029d79117ab40de9c44a0f3d3041e454941', 'w@gmail.com', 'w', 0, 0, 0, '2023-08-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `comment_item` (`Item_ID`),
  ADD KEY `Comment_User` (`User_ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `member_1` (`User_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User Identify', AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Comment_User` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_item` FOREIGN KEY (`Item_ID`) REFERENCES `items` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
