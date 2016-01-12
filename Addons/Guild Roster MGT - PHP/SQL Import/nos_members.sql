-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2016 at 11:47 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `guilddb`
--

-- --------------------------------------------------------

--
-- Table structure for table `nos_members`
--

DROP TABLE IF EXISTS `nos_members`;
CREATE TABLE IF NOT EXISTS `nos_members` (
  `memberID` mediumint(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profession` varchar(100) DEFAULT NULL,
  `game_type` varchar(100) DEFAULT NULL,
  `division` varchar(20) DEFAULT NULL,
  `has_expansion` varchar(3) NOT NULL,
  `notes` mediumtext,
  PRIMARY KEY (`memberID`),
  KEY `memberID` (`memberID`),
  KEY `name` (`name`),
  KEY `email` (`email`),
  KEY `language` (`profession`,`game_type`,`division`,`has_expansion`),
  KEY `has_expansion` (`has_expansion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
