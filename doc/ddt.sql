-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 25, 2012 at 11:52 AM
-- Server version: 5.1.61
-- PHP Version: 5.3.10-1~dotdeb.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ddt`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_gift`
--

CREATE TABLE IF NOT EXISTS `daily_gift` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `from_uid` bigint(20) unsigned NOT NULL,
  `to_pid` varchar(100) NOT NULL,
  `gift_id` varchar(100) NOT NULL,
  `received` tinyint(3) unsigned NOT NULL,
  `date_create` date NOT NULL,
  `time_create` int(10) unsigned NOT NULL,
  `time_update` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `daily_constraint` (`to_pid`,`date_create`,`from_uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=109 ;

-- --------------------------------------------------------

--
-- Table structure for table `invite_log`
--

CREATE TABLE IF NOT EXISTS `invite_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `from_uid` bigint(20) unsigned NOT NULL,
  `to_pid` varchar(100) NOT NULL,
  `request_id` varchar(100) NOT NULL,
  `date_create` date NOT NULL,
  `time_create` int(10) unsigned NOT NULL,
  `time_update` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `daily_constraint` (`from_uid`,`to_pid`,`date_create`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invite_reward`
--

CREATE TABLE IF NOT EXISTS `invite_reward` (
  `uid` bigint(20) unsigned NOT NULL,
  `reward_5` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `reward_10` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `reward_15` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `time_create` int(10) unsigned NOT NULL,
  `time_update` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login_reward`
--

CREATE TABLE IF NOT EXISTS `login_reward` (
  `uid` bigint(20) unsigned NOT NULL,
  `last_login_date` date NOT NULL,
  `last_reward_date` date NOT NULL,
  `continous_login_days` int(10) unsigned NOT NULL,
  `time_create` int(10) unsigned NOT NULL,
  `time_update` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL,
  `pid` varchar(200) NOT NULL,
  `orderid` varchar(200) NOT NULL,
  `type` varchar(50) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `amount` double unsigned NOT NULL,
  `status` varchar(50) CHARACTER SET ucs2 NOT NULL,
  `server` varchar(50) NOT NULL,
  `server_uid` varchar(50) NOT NULL,
  `coin` int(11) NOT NULL,
  `time_create` int(10) unsigned NOT NULL,
  `time_update` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`orderid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payment_select_server`
--

CREATE TABLE IF NOT EXISTS `payment_select_server` (
  `uid` bigint(20) unsigned NOT NULL,
  `token` varchar(100) NOT NULL,
  `server` varchar(60) NOT NULL,
  `server_uid` varchar(50) NOT NULL,
  `time_update` int(10) unsigned NOT NULL,
  `time_create` int(10) unsigned NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE IF NOT EXISTS `session` (
  `session` varchar(64) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `session_last_write` int(10) unsigned NOT NULL,
  `session_data` text NOT NULL,
  `session_last_visit` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `ip` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`session`),
  KEY `session_last_write` (`session_last_write`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `trace_login`
--

CREATE TABLE IF NOT EXISTS `trace_login` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL,
  `ref` varchar(100) NOT NULL,
  `date_create` date NOT NULL,
  `time_create` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid_date` (`uid`,`date_create`),
  KEY `time_create` (`time_create`),
  KEY `ref` (`ref`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=403 ;

-- --------------------------------------------------------

--
-- Table structure for table `trace_pay`
--

CREATE TABLE IF NOT EXISTS `trace_pay` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL,
  `ref` varchar(100) NOT NULL,
  `amount` double NOT NULL,
  `time_create` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ref` (`ref`,`time_create`),
  KEY `time_create` (`time_create`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `uid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `platform` varchar(50) CHARACTER SET ascii NOT NULL,
  `platform_uid` varchar(100) NOT NULL,
  `platform_username` varchar(100) NOT NULL,
  `platform_userpic` varchar(200) CHARACTER SET ascii NOT NULL,
  `platform_email` varchar(200) NOT NULL,
  `platform_gender` enum('male','female') DEFAULT NULL,
  `time_create` int(10) unsigned NOT NULL,
  `time_update` int(10) unsigned NOT NULL,
  `invite_from_uid` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ref` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  KEY `invite_from_uid` (`invite_from_uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_config`
--

CREATE TABLE IF NOT EXISTS `user_config` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `time_create` int(10) unsigned NOT NULL,
  `time_update` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk` (`uid`,`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_server`
--

CREATE TABLE IF NOT EXISTS `user_server` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) unsigned NOT NULL,
  `server_id` varchar(50) NOT NULL,
  `time_create` int(10) unsigned NOT NULL,
  `time_update` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`,`server_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
