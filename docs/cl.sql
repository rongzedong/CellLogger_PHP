-- phpMyAdmin SQL Dump
-- version 3.3.7deb5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 20, 2012 at 11:01 PM
-- Server version: 5.0.51
-- PHP Version: 5.3.8-1~dotdeb.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cl`
--

-- --------------------------------------------------------

--
-- Table structure for table `station_cell`
--

CREATE TABLE IF NOT EXISTS `station_cell` (
  `station_id` int(11) NOT NULL,
  `lac` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `time_create` int(10) unsigned NOT NULL,
  UNIQUE KEY `c` (`station_id`,`lac`,`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user_record`
--

CREATE TABLE IF NOT EXISTS `user_record` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `client_id` varchar(100) NOT NULL,
  `seq` int(11) NOT NULL,
  `network` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `lac` int(11) NOT NULL,
  `station_id` int(11) NOT NULL,
  `signal_strength` int(11) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `time_upload` int(10) unsigned NOT NULL,
  `time_update` int(10) unsigned NOT NULL,
  `approved` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `record_constraint` (`client_id`,`seq`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=218 ;
