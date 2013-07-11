-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 12, 2013 at 05:43 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `suekarea_bd`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `alias`, `name`) VALUES
(1, 'film', 'Film'),
(2, 'tv-serial', 'TV Serial'),
(3, 'anime', 'Anime'),
(4, 'cartoon', 'Cartoon');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `comment` longtext NOT NULL,
  `comment_time` datetime NOT NULL,
  `is_publish` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `link`, `comment`, `comment_time`, `is_publish`) VALUES
(1, 0, '', 'asdd 2 23', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `post_type_id` int(11) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` longtext NOT NULL,
  `thumbnail` varchar(50) NOT NULL,
  `create_date` datetime NOT NULL,
  `publish_date` datetime NOT NULL,
  `view_count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `user_id`, `category_id`, `post_type_id`, `alias`, `name`, `desc`, `thumbnail`, `create_date`, `publish_date`, `view_count`) VALUES
(4, 1, 1, 2, 'g-i-joe-retaliation-2013', 'G.I.Joe Retaliation (2013)', '<div><font face="arial, helvetica, clean, sans-serif"><span style="font-size: 12px;">The G.I. Joes are not only fighting their mortal enemy Cobra; they are forced to contend with threats from within the government that jeopardize their very existence.</span></font></div><div><font face="arial, helvetica, clean, sans-serif"><span style="font-size: 12px;"><br></span></font></div><div><font face="arial, helvetica, clean, sans-serif"><span style="font-size: 12px;">Director: Jon M. Chu</span></font></div><div><font face="arial, helvetica, clean, sans-serif"><span style="font-size: 12px;">Writers: Rhett Reese, Paul Wernick</span></font></div><div><font face="arial, helvetica, clean, sans-serif"><span style="font-size: 12px;">Stars: Dwayne Johnson, Byung-hun Lee, Adrianne Palicki | See full cast and crew</span></font></div>', '2013/07/11/20130711_063511_1427.jpg', '2013-07-11 06:34:00', '2013-07-11 05:31:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_type`
--

CREATE TABLE IF NOT EXISTS `post_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `post_type`
--

INSERT INTO `post_type` (`id`, `name`) VALUES
(1, 'Draft'),
(2, 'Publish');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE IF NOT EXISTS `request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `request_time` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `request`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_type_id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) NOT NULL,
  `passwd` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `register_date` datetime NOT NULL,
  `login_last_date` datetime NOT NULL,
  `is_active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_type_id`, `email`, `fullname`, `passwd`, `address`, `register_date`, `login_last_date`, `is_active`) VALUES
(1, 1, 'her0satr@yahoo.com', 'Herry', 'fe30fa79056939db8cbe99c8d601de74', NULL, '2013-07-04 00:00:00', '2013-07-12 04:54:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE IF NOT EXISTS `user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'Member');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
