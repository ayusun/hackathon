-- phpMyAdmin SQL Dump
-- version 4.2.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 01, 2014 at 02:31 PM
-- Server version: 5.5.38-0ubuntu0.12.04.1
-- PHP Version: 5.3.10-1ubuntu3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `spotfix`
--

-- --------------------------------------------------------

--
-- Table structure for table `spotfixattendees`
--

CREATE TABLE IF NOT EXISTS `spotfixattendees` (
`id` int(11) NOT NULL,
  `eventid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `spotfixevents`
--

CREATE TABLE IF NOT EXISTS `spotfixevents` (
`id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` varchar(300) DEFAULT NULL,
  `photo` varchar(50) DEFAULT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `byuser` int(11) NOT NULL,
  `closetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `isreported` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `spotfixreports`
--

CREATE TABLE IF NOT EXISTS `spotfixreports` (
  `eventid` int(11) NOT NULL,
  `beforepic` varchar(50) NOT NULL,
  `afterpic` varchar(50) NOT NULL,
  `Description` varchar(400) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
`id` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `passwd` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `Name`, `username`, `passwd`) VALUES
(1, 'Ayush', 'ayush', '2147aa348383f7cc243fbb58bd89ebe161e80d69'),
(2, 'Sunny', 'sunny', 'b892f067921d231448e8f0a591107de8b2ad3202');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `spotfixattendees`
--
ALTER TABLE `spotfixattendees`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spotfixevents`
--
ALTER TABLE `spotfixevents`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spotfixreports`
--
ALTER TABLE `spotfixreports`
 ADD PRIMARY KEY (`eventid`), ADD KEY `eventid` (`eventid`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `spotfixattendees`
--
ALTER TABLE `spotfixattendees`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `spotfixevents`
--
ALTER TABLE `spotfixevents`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `spotfixreports`
--
ALTER TABLE `spotfixreports`
ADD CONSTRAINT `report_events_fk` FOREIGN KEY (`eventid`) REFERENCES `spotfixevents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
