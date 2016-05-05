-- phpMyAdmin SQL Dump
-- version 4.0.10.15
-- http://www.phpmyadmin.net
--
-- Host: studentdb-maria.gl.umbc.edu
-- Generation Time: May 05, 2016 at 12:41 AM
-- Server version: 10.0.24-MariaDB-wsrep
-- PHP Version: 5.4.44

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xr43817`
--

-- --------------------------------------------------------

--
-- Table structure for table `ACTIVITIES`
--

CREATE TABLE IF NOT EXISTS `ACTIVITIES` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_name` varchar(64) NOT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `ACTIVITIES`
--

INSERT INTO `ACTIVITIES` (`activity_id`, `activity_name`) VALUES
(1, 'Swimming'),
(2, 'Walking'),
(3, 'Rock Climbing'),
(4, 'Hiking'),
(5, 'Biking'),
(6, 'Camping'),
(7, 'Canoeing'),
(8, 'Cliff Diving'),
(9, 'Bungie Jumping'),
(10, 'Base Jumping');

-- --------------------------------------------------------




--
-- Table structure for table `OVERLAYS`
--

CREATE TABLE IF NOT EXISTS `OVERLAYS` (
  `overlay_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL,
  `overlay_name` varchar(25) NOT NULL,
  `activity_name` varchar(65) NOT NULL,
  `description` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `private` tinyint(1) NOT NULL,
  PRIMARY KEY (`overlay_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `OVERLAYS`
--

INSERT INTO `OVERLAYS` (`overlay_id`, `type`, `overlay_name`, `activity_name`, `description`, `user_id`, `private`) VALUES
(1, 0, 'Swim Point!', 'Swimming', 'This is a great spot to swim from!', 1, 1),
(2, 0, 'Swim Point2!', 'Swimming', 'This is a great spot to swim from!', 1, 1),
(3, 0, 'Swim Point3!', 'Swimming', 'This is a great spot to swim from!', 1, 1),
(4, 0, 'Devil''s Jump', 'Bungie Jumping', 'Jump without fear!', 1, 0),
(5, 0, 'Bears and Walking', 'Walking', 'There were some cool bears here', 1, 0),
(9, 0, 'Bright Angel Campground', 'Camping', 'Very fun camping spot!', 4, 1),
(10, 0, '', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `POINTS`
--

CREATE TABLE IF NOT EXISTS `POINTS` (
  `point_id` int(11) NOT NULL AUTO_INCREMENT,
  `overlay_id` int(11) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  PRIMARY KEY (`point_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `POINTS`
--

INSERT INTO `POINTS` (`point_id`, `overlay_id`, `latitude`, `longitude`) VALUES
(1, 1, 36.09958513287829, -112.10053207352757),
(2, 2, 36.098588210325026, -112.09971668198705),
(3, 3, 36.100764085834555, -112.10370780900121),
(4, 4, 36.097669296595285, -112.0955109782517),
(5, 5, 36.099602470549904, -112.10371971130371),
(9, 9, 36.101795655159904, -112.0964241027832),
(10, 10, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ROUTES`
--

CREATE TABLE IF NOT EXISTS `ROUTES` (
  `route_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`route_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `ROUTES`
--

INSERT INTO `ROUTES` (`route_id`, `user_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ROUTE_OVERLAYS`
--

CREATE TABLE IF NOT EXISTS `ROUTE_OVERLAYS` (
  `route_id` int(11) NOT NULL,
  `overlay_id` int(11) NOT NULL,
  PRIMARY KEY (`overlay_id`,`route_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ROUTE_OVERLAYS`
--

INSERT INTO `ROUTE_OVERLAYS` (`route_id`, `overlay_id`) VALUES
(4, 4),
(5, 4),
(1, 8),
(2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE IF NOT EXISTS `USERS` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `user_name` varchar(25) NOT NULL,
  `password` varchar(16) NOT NULL,
  `retyped_password` varchar(16) NOT NULL,
  `user_email` varchar(64) NOT NULL,
  `retyped_email` varchar(64) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `USERNAME` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `USERS`
--

INSERT INTO `USERS` (`user_id`, `first_name`, `last_name`, `user_name`, `password`, `retyped_password`, `user_email`, `retyped_email`) VALUES
(1, 'gloria', 'ngo', 'gngo', 'pwd', '', 'xr43817@umbc.edu', ''),
(2, 'Hail', 'Mary', 'fullofgrace', 'grace', 'grace', 'god@loves.me', 'god@loves.me'),
(3, 'Dino', 'Man', 'Dino', 'dino', 'dino', 'dino@awesome.com', 'dino@awesome.com'),
(4, 'admin', 'admin', 'admin', 'admin', 'admin', 'admin@admin.com', 'admin@admin.com'),
(5, 'Jane', 'Doe', 'jane', 'jane', 'jane', 'janedoe@gmail.com', 'janedoe@gmail.com'),
(6, 'Steven', 'Nguyen', 'snguyen5', 'password', 'password', 'snguyen5@umbc.edu', 'snguyen5@umbc.edu'),
(7, 'Luke', 'Schubert', 'luke5', 'thing', 'thing', 'luke5@umbc.edu', 'luke5@umbc.edu');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
