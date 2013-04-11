-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 09, 2013 at 05:21 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `time_bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `pic_dept`
--

CREATE TABLE IF NOT EXISTS `pic_dept` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(450) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pic_sub_dept`
--

CREATE TABLE IF NOT EXISTS `pic_sub_dept` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dept_id` int(10) unsigned NOT NULL,
  `name` varchar(450) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_sub_dept_1` (`dept_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `temp_users`
--

CREATE TABLE IF NOT EXISTS `temp_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `password` varchar(500) NOT NULL,
  `email` varchar(450) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `mobile` varchar(45) NOT NULL,
  `birthdate` varchar(450) NOT NULL,
  `prof` varchar(450) NOT NULL,
  `job` varchar(450) NOT NULL,
  `city` varchar(450) NOT NULL,
  `travel` varchar(45) DEFAULT NULL,
  `faculty` varchar(450) DEFAULT NULL,
  `hobbit` varchar(500) NOT NULL,
  `about` varchar(500) DEFAULT NULL,
  `regist_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `key` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `password` varchar(500) NOT NULL,
  `email` varchar(450) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `mobile` varchar(45) NOT NULL,
  `birthdate` varchar(450) NOT NULL,
  `prof` varchar(450) NOT NULL,
  `job` varchar(450) NOT NULL,
  `city` varchar(450) NOT NULL,
  `time` varchar(45) NOT NULL,
  `travel` varchar(45) DEFAULT NULL,
  `faculty` varchar(450) DEFAULT NULL,
  `hobbit` varchar(500) NOT NULL,
  `about` varchar(500) DEFAULT NULL,
  `pic` varchar(500) NOT NULL DEFAULT 'default_pic.jpg',
  `rate` varchar(45) DEFAULT NULL,
  `regist_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `video` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `phone`, `mobile`, `birthdate`, `prof`, `job`, `city`, `time`, `travel`, `faculty`, `hobbit`, `about`, `pic`, `rate`, `regist_date`, `video`) VALUES
(1, 'temraz', '3c4b00d8fa41a8ccf28344a99c8c4ae2', 'temraz@yahoo.com', '123', '123323', '0', '0', 'qwweqe', 'qwe', '', NULL, NULL, 'qedad', NULL, 'default_pic.jpg', NULL, '2013-04-09 00:58:40', NULL),
(2, 'محمد', '202cb962ac59075b964b07152d234b70', 'y@yahoo.com', '1123', '123123', '0', '0', '???', '???', '', NULL, NULL, '?????', NULL, 'default_pic.jpg', NULL, '2013-04-09 01:14:27', NULL),
(3, 'temraz12', '202cb962ac59075b964b07152d234b70', 'temraz12@yahoo.com', '12', '12', '0', '0', '12432`', 'hjb', '', NULL, NULL, 'jb', NULL, 'default_pic.jpg', NULL, '2013-04-09 03:59:04', NULL),
(4, 'temraz', '81dc9bdb52d04dc20036dbd8313ed055', 'mohamed@yahoo.com', '4343', '4343', '0', '0', 'تاتا', 'تا', '', NULL, NULL, 'تا', NULL, 'default_pic.jpg', NULL, '2013-04-09 05:00:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_events`
--

CREATE TABLE IF NOT EXISTS `user_events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `event_id` int(10) unsigned NOT NULL,
  `confirm` varchar(45) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_user_events_1` (`user_id`),
  KEY `FK_user_events_2` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_messages`
--

CREATE TABLE IF NOT EXISTS `user_messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(450) NOT NULL,
  `content` text NOT NULL,
  `confirm` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_user_messages_1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_pic`
--

CREATE TABLE IF NOT EXISTS `user_pic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_pic_1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_posts`
--

CREATE TABLE IF NOT EXISTS `user_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` varchar(450) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_posts_1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `vedios`
--

CREATE TABLE IF NOT EXISTS `vedios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `link` varchar(500) NOT NULL,
  `details` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `video_dept`
--

CREATE TABLE IF NOT EXISTS `video_dept` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(450) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `video_sup_dept`
--

CREATE TABLE IF NOT EXISTS `video_sup_dept` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dept_id` int(10) unsigned NOT NULL,
  `name` varchar(450) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_video_sup_dept_1` (`dept_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pic_sub_dept`
--
ALTER TABLE `pic_sub_dept`
  ADD CONSTRAINT `FK_sub_dept_1` FOREIGN KEY (`dept_id`) REFERENCES `pic_dept` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_events`
--
ALTER TABLE `user_events`
  ADD CONSTRAINT `FK_user_events_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_messages`
--
ALTER TABLE `user_messages`
  ADD CONSTRAINT `FK_user_messages_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_posts`
--
ALTER TABLE `user_posts`
  ADD CONSTRAINT `FK_user_posts_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
