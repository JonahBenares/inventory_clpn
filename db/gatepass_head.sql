-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2021 at 01:48 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_inventory1`
--

-- --------------------------------------------------------

--
-- Table structure for table `gatepass_head`
--

CREATE TABLE IF NOT EXISTS `gatepass_head` (
`gatepass_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `destination` varchar(50) NOT NULL,
  `vehicle_no` varchar(50) NOT NULL,
  `date_issued` varchar(50) NOT NULL,
  `date_returned` varchar(50) NOT NULL,
  `mgp_no` varchar(50) NOT NULL,
  `prepared_by` int(11) NOT NULL,
  `noted_by` int(11) NOT NULL,
  `approved_by` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `date_created` varchar(50) NOT NULL,
  `saved` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gatepass_head`
--
ALTER TABLE `gatepass_head`
 ADD PRIMARY KEY (`gatepass_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gatepass_head`
--
ALTER TABLE `gatepass_head`
MODIFY `gatepass_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
