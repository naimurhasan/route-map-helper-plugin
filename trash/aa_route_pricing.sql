-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2021 at 08:30 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_aatransport`
--

-- --------------------------------------------------------

--
-- Table structure for table `aa_route_pricing`
--

CREATE TABLE `aa_route_pricing` (
  `id` int(11) NOT NULL,
  `_from` text NOT NULL,
  `heathrow_airport` text NOT NULL,
  `stanstead_airport` text NOT NULL,
  `gatwick_airport` text NOT NULL,
  `city_airport` text NOT NULL,
  `luton_airport` text NOT NULL,
  `toll` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `aa_route_pricing`
--

INSERT INTO `aa_route_pricing` (`id`, `_from`, `heathrow_airport`, `stanstead_airport`, `gatwick_airport`, `city_airport`, `luton_airport`, `toll`) VALUES
(2, 'DA1 DARTFORD', 'S-63/R-115', 'S-70/R-130', 'S-60/R-115', 'S-45/R-80', 'S-75/R-135', ''),
(3, 'DA2 DARTFORD', 'S-63/R-115', 'S-70/R-130', 'S-60/R-115', 'S-45/R-80', 'S-75/R-135', ''),
(4, 'DA3 LONGFIELD', 'S-65/R-120', 'S-70/R-130', 'S-60/R-115', 'S-45/R-80', 'S-84/R-162', ''),
(5, 'DA4 DARTFORD', 'S-63/R-115', 'S-70/R-130', 'S-60/R-115', 'S-45/R-80', 'S-75/R-135', ''),
(6, 'DA5 BEXLEY', 'S-59/R-110', 'S-65/R-120', 'S-60/R-115', 'S-40/R-70', 'S-70/R-130', ''),
(7, 'DA6 BEXLEYHEATH', 'S-59/R-110', 'S-65/R-120', 'S-60/R-115', 'S-40/R-70', 'S-70/R-130', ''),
(8, 'DA7 BEXLEYHEATH', 'S-59/R-110', 'S-65/R-120', 'S-60/R-115', 'S-40/R-70', 'S-70/R-130', ''),
(9, 'DA8 ERITH', 'S-62/R-115', 'S-65/R-120', 'S-60/R-115', 'S-45/R-80', 'S-75/R-135', ''),
(10, 'DA9 GREENHITE', 'S-65/R-120', 'S-67/R-120', 'S-62/R-120', 'S-45/R-80', 'S-84/R-160', ''),
(11, 'DA10 SWANSCOMBE', 'S-65/R-120', 'S-67/R-120', 'S-62/R-120', 'S-45/R-80', 'S-84/R-160', ''),
(12, 'DA11 GRAVESEND', 'S-75/R-120', 'S-70/R-130', 'S-75/R-130', 'S-52/R-105', 'S-87/R-170', ''),
(13, 'DA12GRAVESEND', 'S-75/R-120', 'S-70/R-130', 'S-75/R-130', 'S-52/R-105', 'S-87/R-170', ''),
(14, 'DA13 GRAVESEND', 'S-75/R-120', 'S-70/R-130', 'S-75/R-130', 'S-52/R-105', 'S-87/R-170', ''),
(15, 'DA14 SIDCUP', 'S-59/R-110', 'S-65/R-120', 'S-60/R-115', 'S-40/R-70', 'S-70/R-130', ''),
(16, 'DA15 SIDCUP', 'S-59/R-110', 'S-65/R-120', 'S-60/R-115', 'S-40/R-70', 'S-70/R-130', ''),
(17, 'DA16 WELLING', 'S-59/R-110', 'S-65/R-120', 'S-60/R-115', 'S-40/R-70', 'S-70/R-130', ''),
(18, 'DA17 BELVEDERE', 'S-59/R-110', 'S-67/R-120', 'S-60/R-115', 'S-40/R-70', 'S-75/R-135', ''),
(19, 'DA18 ERITH', 'S-62/R-115', 'S-67/R-120', 'S-60/R-115', 'S-40/R-70', 'S-75/R-135', ''),
(20, 'SE2 Abbey Wood', 'S-60/R-110', 'S-65/R-120', 'S-67/R-130', 'S-35/R-60', 'S-69/R-130', ''),
(21, 'SE3 Blackheath', 'S- 55/ R-105', 'S-65/R-120', 'S-67/R-130', 'S-30/R-55', 'S-68/R-130', ''),
(22, 'SE4 Brockley', 'S- 55/ R-105', 'S-65/R-120', 'S-67/R-130', 'S-30/R-55', 'S-68/R-131', ''),
(23, 'SE5 Camberwell', 'S- 55/ R-105', 'S-65/R-120', 'S-67/R-130', 'S-30/R-55', 'S-68/R-132', ''),
(24, 'SE6 Catford', 'S-60/R-110', 'S-65/R-120', 'S-67/R-130', 'S-35/R-66', 'S-68/R-133', ''),
(25, 'SE7 Charlton', 'S- 55/ R-105', 'S-65/R-120', 'S-67/R-130', 'S-30/R-55', 'S-68/R-130', ''),
(26, 'SE8 Deptford', 'S- 55/ R-105', 'S-65/R-120', 'S-67/R-130', 'S-30/R-55', 'S-68/R-130', ''),
(27, 'SE9 Eltham', 'S-60/R-110', 'S-65/R-120', 'S-67/R-130', 'S-35/R-60', 'S-68/R-131', ''),
(28, 'SE10 Greenwich', 'S- 55/ R-105', 'S-65/R-120', 'S-67/R-130', 'S-30/R-55', 'S-68/R-130', ''),
(29, 'SE11 Kennington', 'S-65/R-120', 'S-70/R-130', 'S-75/R-140', 'S-50/R-85', 'S-84/R-160', ''),
(30, 'SE12 Lee', 'S- 55/ R-105', 'S-65/R-120', 'S-67/R-130', 'S-30/R-55', 'S-68/R-130', ''),
(31, 'SE13 Lewisham', 'S- 55/ R-105', 'S-65/R-120', 'S-67/R-130', 'S-30/R-55', 'S-68/R-130', ''),
(32, 'SE14 New Cross', 'S- 55/ R-105', 'S-65/R-120', 'S-67/R-130', 'S-35/R-60', 'S-68/R-130', ''),
(33, 'SE15 Peckham', 'S- 55/ R-105', 'S-65/R-120', 'S-67/R-130', 'S-35/R-60', 'S-68/R-130', ''),
(34, 'SE16 Rotherhithe', 'S- 55/ R-105', 'S-65/R-120', 'S-67/R-130', 'S-40/R-70', 'S-68/R-130', ''),
(35, 'SE17 Walworth', 'S- 65/ R-120', 'S-70/R-130', 'S-75/R-140', 'S-50/R-85', 'S-68/R-130', ''),
(36, 'SE18 Woolwich', 'S- 55/ R-105', 'S-65/R-120', 'S-67/R-130', 'S-30/R-56', 'S-68/R-130', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aa_route_pricing`
--
ALTER TABLE `aa_route_pricing`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aa_route_pricing`
--
ALTER TABLE `aa_route_pricing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
