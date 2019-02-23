-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2019 at 09:32 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bb_otp3`
--

-- --------------------------------------------------------

--
-- Table structure for table `bb_players`
--

CREATE TABLE `bb_players` (
  `mobile_number` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `verification_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=Verified, 0=Not verified',
  `wp_id` int(10) NOT NULL DEFAULT '0' COMMENT 'wordpress id',
  `wp_jwt` varchar(250) NOT NULL DEFAULT '0' COMMENT 'wordpress jwt',
  `bb_tg_id` int(10) NOT NULL DEFAULT '0' COMMENT 'bb_telegram_id',
  `bb_mail_id` int(10) NOT NULL DEFAULT '0' COMMENT 'bb_email_id'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vb_user`
--

CREATE TABLE `vb_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mac` varchar(12) NOT NULL,
  `code` int(4) NOT NULL,
  `namefa` varchar(35) DEFAULT NULL,
  `familynamefa` varchar(50) NOT NULL,
  `firstnamefa` varchar(40) NOT NULL,
  `fathersnamefa` varchar(40) NOT NULL,
  `nameunicode` varchar(20) NOT NULL,
  `telegram` varchar(35) DEFAULT NULL,
  `instagram` varchar(35) NOT NULL,
  `priority` int(3) NOT NULL,
  `chat_id` varchar(12) NOT NULL,
  `pushe_id` varchar(60) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `passphrase` varchar(4) NOT NULL,
  `height` varchar(11) NOT NULL,
  `weight` varchar(11) NOT NULL,
  `city` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `urbanfa` varchar(30) NOT NULL,
  `provincefa` varchar(30) NOT NULL,
  `age` varchar(11) NOT NULL,
  `birthdayyear` int(4) NOT NULL DEFAULT '1399',
  `birthdaymonth` int(2) NOT NULL DEFAULT '0',
  `birthdayday` int(2) NOT NULL DEFAULT '0',
  `sex` tinyint(1) NOT NULL,
  `coach` varchar(35) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `teamname` varchar(35) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `experience` varchar(11) NOT NULL,
  `experienceofficial` varchar(30) NOT NULL,
  `nationalcode` varchar(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `postalcode` varchar(11) NOT NULL,
  `telegramphone` varchar(13) NOT NULL,
  `telegramcellphone` varchar(14) NOT NULL,
  `homephone` varchar(14) NOT NULL,
  `cellphone` varchar(14) NOT NULL,
  `presented` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
