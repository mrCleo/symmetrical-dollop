-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2020 at 04:06 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food-order`
--

-- --------------------------------------------------------

--
-- Table structure for table `finalorder`
--

CREATE TABLE `finalorder` (
  `FinalID` int(11) NOT NULL,
  `orderKey` int(11) NOT NULL,
  `restaurant` varchar(255) NOT NULL,
  `totalPrice` float NOT NULL,
  `UserID` int(11) NOT NULL,
  `orderComments` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finalorder`
--

INSERT INTO `finalorder` (`FinalID`, `orderKey`, `restaurant`, `totalPrice`, `UserID`, `orderComments`, `status`, `date`) VALUES
(18, 2101813796, 'Burgers', 11, 68, 'Now!!!', 'Delivered', '12-13-2020 12:50:00'),
(20, 1440393247, 'Pizza Shack', 11, 72, 'Test', 'Canceled', ''),
(21, 1898539766, 'Pizza Shack', 5.5, 72, 'Yay!!!!!!!!!!!!', 'pending', ''),
(22, 161789413, 'Pizza Shack', 5.5, 68, 'Now', 'pending', ''),
(23, 902209486, 'Pizza Shack', 5.5, 72, 'test', 'pending', '');

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `FoodID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `restaurant` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `featured` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`FoodID`, `title`, `description`, `restaurant`, `price`, `image_name`, `featured`, `active`) VALUES
(1, 'Cheesy Pizza', 'A cheesy pizza!', 'Pizza Shack', 5.5, 'Food-Name-8141.jpg', 'Yes', 'Yes'),
(2, 'Burger', 'Big Burger', 'Burgers', 5.5, 'Food-Name-3434.jpg', 'Yes', 'Yes'),
(3, 'Beef Pizza', 'Beefy', 'Pizza Shack', 8.55, '', 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `orderKey` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `FoodID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `restaurant` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `orderKey`, `UserID`, `FoodID`, `title`, `restaurant`, `price`, `date`) VALUES
(137, 2101813796, 68, 0, 'Burger', 'Burgers', 5.5, '12-13-2020 12:49:23'),
(138, 2101813796, 68, 0, 'Burger', 'Burgers', 5.5, '12-13-2020 12:49:31'),
(139, 1253379414, 68, 0, 'Cheesy Pizza', 'Pizza Shack', 5.5, '12-13-2020 03:44:04'),
(140, 1440393247, 72, 1, 'Cheesy Pizza', 'Pizza Shack', 5.5, ''),
(141, 1440393247, 72, 1, 'Cheesy Pizza', 'Pizza Shack', 5.5, ''),
(142, 1898539766, 72, 1, 'Cheesy Pizza', 'Pizza Shack', 5.5, ''),
(144, 161789413, 68, 1, 'Cheesy Pizza', 'Pizza Shack', 5.5, '12-13-2020 10:05:08'),
(145, 902209486, 72, 1, 'Cheesy Pizza', 'Pizza Shack', 5.5, '12-13-2020 10:57:59');

-- --------------------------------------------------------

--
-- Table structure for table `review_food`
--

CREATE TABLE `review_food` (
  `ReviewFoodID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `FoodID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Rating` float NOT NULL,
  `Timestamp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review_food`
--

INSERT INTO `review_food` (`ReviewFoodID`, `UserID`, `FoodID`, `Comment`, `Rating`, `Timestamp`) VALUES
(9, 62, 0, 'hello', 8, '12-12-2020'),
(13, 68, 2, '2', 2, '12-13-2020'),
(16, 68, 3, 'Bad', 1, '12-13-2020');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `full_name`, `username`, `password`) VALUES
(2, 'bob', 'tan', '5f4dcc3b5aa765d61d8327deb882cf99');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Address1` varchar(255) NOT NULL,
  `Contact` varchar(255) NOT NULL,
  `City` varchar(255) DEFAULT NULL,
  `State` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `PostalCode` int(11) NOT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Privilege` int(11) NOT NULL,
  `DOB` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `FirstName`, `LastName`, `Username`, `Address1`, `Contact`, `City`, `State`, `Email`, `PostalCode`, `Password`, `Privilege`, `DOB`) VALUES
(68, 'Jag', 'Guirey', 'jalg83', '5 Simei Street 3 Tower 3B #03-16', '96655118', 'SG', 'SG', 'alvinguirey@gmail.com', 529892, '$2y$10$juty9Fdf0rBsQdKJUCqCwOmRr9VYb9flg7kBIwaWwgIcKXkVC7w9m', 1, '08-03-2002'),
(70, 'Alvin', 'Guirey', 'r2d3', '5 Simei Street 3 Tower 3B #03-16', '96655118', 'SG', 'SG', 'alvinjo@gmail.com', 529894, '$2y$10$Zq2G5sxqkkoNXhbTLStoE.oEQzLQjLHaYxg4uxSc2wg3GkV7GpB7O', 1, '08-23-1970'),
(72, 'Jo', 'Guirey', 'Joy', '5 Simei Street 3 Tower 3B #03-16', '96655118', 'SG', 'SG', 'janguirey38@gmail.com', 529892, '$2y$10$phmjOJh3UVykPmhjmTJ2LeAlP.xwZ8U28ziDZCWh516P70rV8.i4.', 1, '08-03-2002'),
(74, 'Admin', 'Admi', 'Admin1', 'Nowhere', '98366420', 'SG', 'SG', 'alvinjo', 1234, '$2y$10$D0glklV/N3gKzwQiM8VQQOt5Pn9oaL/j9MMJvW/714iL3dg.iA8MW', 3, '08-03-2000'),
(75, 'Admin', 'Admi', 'Admin2', 'Nowhere', '98366420', 'SG', 'SG', 'alvinjo', 1234, '$2y$10$UiCCIO9uJGgbUP6qWrwSBOKehbqIv6MmDU3haPYX5BGr5NRzoIHBS', 3, '08-03-2000'),
(76, 'Test', 'Boy', 'r2d5', '5 Simei Street 3 Tower 3B #03-16', '96655118', 'SG', 'SG', 'alvinguirey@gmail.com', 1234, '$2y$10$o2iALSsL5vosdvVYOFjFAO1G8t7b83.cH86oaoCYEmxYeApbwfzBu', 1, '08-03-1999');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `finalorder`
--
ALTER TABLE `finalorder`
  ADD PRIMARY KEY (`FinalID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`FoodID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `FoodID` (`FoodID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `review_food`
--
ALTER TABLE `review_food`
  ADD PRIMARY KEY (`ReviewFoodID`),
  ADD KEY `FK_UserID` (`UserID`),
  ADD KEY `FK_FoodID` (`FoodID`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `finalorder`
--
ALTER TABLE `finalorder`
  MODIFY `FinalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `FoodID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `review_food`
--
ALTER TABLE `review_food`
  MODIFY `ReviewFoodID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `finalorder`
--
ALTER TABLE `finalorder`
  ADD CONSTRAINT `finalorder_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
