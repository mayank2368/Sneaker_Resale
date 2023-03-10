-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2021 at 10:39 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sneakerresale`
--

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE `bids` (
  `user` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `bid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bids`
--

INSERT INTO `bids` (`user`, `product`, `bid`) VALUES
('test@test.com', '1', 12345);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `user` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`user`, `product`) VALUES
('test@test.com', '1');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `user` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`user`, `name`, `email`, `message`) VALUES
('test@test.com', 'tester1', '123456890', 'alkfnals,f ');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `discription` varchar(255) NOT NULL,
  `feature1` varchar(255) NOT NULL,
  `feature2` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `bids` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `discription`, `feature1`, `feature2`, `price`, `img`, `user`, `bids`) VALUES
(1, 'Awesome Nike Shoes', 'good quality comfortable sports shoes size UK 8', 'Water-Resistant', 'Sports', '4050', 'https://res.cloudinary.com/mhmd/image/upload/v1556485076/shoes-1_gthops.jpg', 'test@test.com', 12345),
(2, 'Puma shoes for men', 'these are very comfortable shoes and useful for wearing to events', 'Fashionable', 'Casual', '2025', 'https://static.highsnobiety.com/thumbor/Nsod8XDsBdUWEvFvQ65tPJbdtns=/1200x720/static.highsnobiety.com/wp-content/uploads/2019/03/27120517/best-puma-kicks-feat.jpg', 'test@test.com', 0),
(5, 'Nike Jordans ', 'Nike shoes from the Jordans series size UK 9', 'limited edition', 'Other', '10000', 'https://static.highsnobiety.com/thumbor/DJ0Ih906YSNAeuZsdTj4jJ15t8E=/1600x1067/static.highsnobiety.com/wp-content/uploads/2020/04/02175856/nike-air-jordan-1-mid-light-ash-release-date-price-01.jpg', 'test@test.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `password`) VALUES
('test@test.com', '05e34a96e3c8e850e4a8677e370ea9c5');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`user`,`product`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`user`,`product`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`user`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
