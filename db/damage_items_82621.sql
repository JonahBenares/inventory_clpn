-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2021 at 03:32 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `damage_items`
--

CREATE TABLE IF NOT EXISTS `damage_items` (
`damage_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL DEFAULT '0',
  `issuance_id` int(11) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0' COMMENT 'only add if items were from item list',
  `item_description` text NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `subcat_id` int(11) NOT NULL DEFAULT '0',
  `original_pn` varchar(100) NOT NULL,
  `unit_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `location_id` int(11) NOT NULL DEFAULT '0',
  `bin_id` int(11) NOT NULL DEFAULT '0',
  `warehouse_id` int(11) NOT NULL DEFAULT '0',
  `rack_id` int(11) NOT NULL DEFAULT '0',
  `barcode` varchar(100) NOT NULL,
  `picture1` varchar(250) NOT NULL,
  `picture2` varchar(250) NOT NULL,
  `picture3` varchar(250) NOT NULL,
  `weight` decimal(10,2) NOT NULL DEFAULT '0.00',
  `local_mnl` int(11) NOT NULL DEFAULT '0',
  `supplier_id` int(11) NOT NULL DEFAULT '0',
  `catalog_no` varchar(100) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `serial_id` int(11) DEFAULT NULL,
  `item_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `expiration` varchar(100) NOT NULL,
  `date_added` varchar(100) NOT NULL,
  `added_by` int(11) NOT NULL DEFAULT '0',
  `remarks` text
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `damage_items`
--

INSERT INTO `damage_items` (`damage_id`, `request_id`, `issuance_id`, `item_id`, `item_description`, `category_id`, `subcat_id`, `original_pn`, `unit_id`, `group_id`, `location_id`, `bin_id`, `warehouse_id`, `rack_id`, `barcode`, `picture1`, `picture2`, `picture3`, `weight`, `local_mnl`, `supplier_id`, `catalog_no`, `brand_id`, `serial_id`, `item_cost`, `quantity`, `expiration`, `date_added`, `added_by`, `remarks`) VALUES
(1, 0, 0, 0, 'sample 001', 0, 18, 'AUX-PAR_1435', 2, 5, 63, 4262, 3, 178, '231654', '', '', '', '0.00', 1, 5, '564654', 2384, 7063, '5042.00', '5.00', '', '2021-08-24 00:55:33', 1, 'sample sample sample'),
(2, 4508, 4401, 1434, 'Drill bit, Concrete, 1/4"', 1, 5, 'CON-CON_6373', 21, 0, 51, 60, 1, 160, '', '', '', '', '0.00', 0, 196, '', 14, NULL, '0.00', '3.00', '', '2021-08-26 09:19:52', 1, NULL),
(3, 4509, 4402, 2862, ' Hose, Flexible, Hydraulic, For Cylinder Head, 3/4", SAE100R2AT', 5, 21, 'ENG-SUL_1246', 21, 0, 51, 1772, 1, 46, '', '', '', '', '0.00', 0, 339, '', 116, 0, '0.00', '5.00', '', '2021-08-26 09:28:14', 1, ''),
(4, 4510, 4403, 2862, ' Hose, Flexible, Hydraulic, For Cylinder Head, 3/4", SAE100R2AT', 5, 21, 'ENG-SUL_1246', 21, 0, 51, 1772, 1, 46, '', '', '', '', '0.00', 0, 1, 'BEGBAL', 663, 0, '0.00', '6.00', '', '2021-08-26 09:31:24', 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `damage_items`
--
ALTER TABLE `damage_items`
 ADD PRIMARY KEY (`damage_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `damage_items`
--
ALTER TABLE `damage_items`
MODIFY `damage_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
