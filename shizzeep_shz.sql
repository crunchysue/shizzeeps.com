-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 12, 2009 at 11:27 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shizzeep_shz`
--

-- --------------------------------------------------------

--
-- Table structure for table `Messages`
--

DROP TABLE IF EXISTS `Messages`;
CREATE TABLE IF NOT EXISTS `Messages` (
  `MsgId` int(11) NOT NULL auto_increment,
  `MsgFrom` varchar(20) NOT NULL,
  `MsgTo` varchar(20) NOT NULL,
  `MsgTime` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `MsgText` varchar(200) NOT NULL,
  PRIMARY KEY  (`MsgId`),
  KEY `MsgTo` (`MsgTo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `Storage`
--

DROP TABLE IF EXISTS `Storage`;
CREATE TABLE IF NOT EXISTS `Storage` (
  `Data` longtext NOT NULL,
  `City` varchar(3) NOT NULL,
  `StoreDate` timestamp NOT NULL default CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
