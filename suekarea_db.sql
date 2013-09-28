-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 28, 2013 at 04:32 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `suekarea_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `adsense_html`
--

CREATE TABLE IF NOT EXISTS `adsense_html` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adsense_owner_id` int(11) NOT NULL,
  `adsense_type_id` int(11) NOT NULL,
  `adsense_code` longtext NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `adsense_html`
--

INSERT INTO `adsense_html` (`id`, `adsense_owner_id`, `adsense_type_id`, `adsense_code`, `create_date`) VALUES
(1, 0, 0, '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `adsense_owner`
--

CREATE TABLE IF NOT EXISTS `adsense_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `adsense_owner`
--

INSERT INTO `adsense_owner` (`id`, `name`, `priority`) VALUES
(2, 'Adstar', 10),
(3, 'Adplus', 9);

-- --------------------------------------------------------

--
-- Table structure for table `adsense_type`
--

CREATE TABLE IF NOT EXISTS `adsense_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `adsense_type`
--

INSERT INTO `adsense_type` (`id`, `name`, `alias`) VALUES
(3, '300 x 250', '300-x-250');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
