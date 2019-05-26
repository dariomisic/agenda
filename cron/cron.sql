-- phpMyAdmin SQL Dump
-- version 2.8.0.1
-- http://www.phpmyadmin.net
-- 
-- Host: custsql-ipg06.eigbox.net
-- Generation Time: Nov 21, 2014 at 06:21 PM
-- Server version: 5.5.32
-- PHP Version: 4.4.9
-- 
-- Database: `kubed`
-- 

TRUNCATE `activity`;
TRUNCATE `city`;
TRUNCATE `client`;
TRUNCATE `department`;
TRUNCATE `event`;
TRUNCATE `function`;
TRUNCATE `project`;
TRUNCATE `tariff`;
TRUNCATE `user`;
TRUNCATE `user_levels`;
TRUNCATE `workday`;
TRUNCATE `working`;
TRUNCATE `working_on_project`;
TRUNCATE `files`;

-- --------------------------------------------------------

-- 
-- Table structure for table `activity`
-- 

CREATE TABLE IF NOT EXISTS `activity` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `project` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `hours` int(11) NOT NULL,
  `tarrif` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `employee` int(11) NOT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `dependency` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`activity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

-- 
-- Dumping data for table `activity`
-- 

INSERT INTO `activity` VALUES (1, 1, 'Logo concept', 'Brainstorming', 10, 1, 1, 9, 0, 0);
INSERT INTO `activity` VALUES (2, 1, 'Graphic design', 'Illustrator', 6, 1, 1, 8, 0, 0);
INSERT INTO `activity` VALUES (3, 2, 'Paperwork', 'Taxes', 5, 1, 1, 1, 0, 0);
INSERT INTO `activity` VALUES (4, 2, 'Contacting clients', 'Email', 5, 1, 1, 4, 0, 0);
INSERT INTO `activity` VALUES (5, 3, 'Market Research', 'Research', 5, 1, 1, 3, 0, 0);
INSERT INTO `activity` VALUES (6, 3, 'Strategy Planning', 'Planning', 5, 1, 1, 2, 0, 0);
INSERT INTO `activity` VALUES (7, 3, 'Article Planning', 'Articles', 5, 1, 1, 3, 0, 0);
INSERT INTO `activity` VALUES (8, 4, 'Database Architecture', 'Build db.', 5, 1, 1, 3, 0, 0);
INSERT INTO `activity` VALUES (9, 4, 'CSS', 'Stylesheets', 5, 1, 1, 2, 0, 0);
INSERT INTO `activity` VALUES (10, 4, 'Client Side Scripting', 'Develop', 5, 1, 1, 5, 0, 0);
INSERT INTO `activity` VALUES (11, 4, 'Server Side Programming', 'Develop', 5, 1, 1, 2, 0, 0);
INSERT INTO `activity` VALUES (12, 4, 'Proofreading', 'Check', 5, 1, 1, 3, 0, 10);
INSERT INTO `activity` VALUES (13, 5, 'Tax management', 'Tax', 5, 1, 1, 2, 0, 0);
INSERT INTO `activity` VALUES (14, 5, 'Salary management', 'Salary', 5, 1, 1, 2, 0, 0);
INSERT INTO `activity` VALUES (15, 5, 'Mortgage research', 'Mortgage', 5, 1, 1, 3, 0, 0);
INSERT INTO `activity` VALUES (16, 5, 'Subsidies calculation', 'Subsidies', 6, 1, 1, 7, 0, 14);
INSERT INTO `activity` VALUES (17, 6, 'Logo design', 'Logo', 5, 1, 1, 9, 0, 0);
INSERT INTO `activity` VALUES (18, 6, 'Flyer design', 'Flyer', 5, 1, 1, 6, 0, 17);
INSERT INTO `activity` VALUES (19, 6, 'Online marketing', 'Marketing', 5, 1, 1, 3, 0, 0);
INSERT INTO `activity` VALUES (20, 6, 'Supervision', 'Management', 5, 1, 1, 1, 0, 0);
INSERT INTO `activity` VALUES (21, 6, 'Video production', 'Video', 4, 1, 1, 2, 0, 19);
INSERT INTO `activity` VALUES (22, 7, 'Print design', 'Print', 5, 1, 1, 6, 0, 0);
INSERT INTO `activity` VALUES (23, 7, 'Video distribution', 'Video', 5, 1, 1, 7, 0, 0);
INSERT INTO `activity` VALUES (24, 7, 'Proofreading', 'Proofreading', 5, 1, 1, 3, 0, 0);
INSERT INTO `activity` VALUES (25, 8, 'Checking balance', 'Balance', 5, 1, 1, 3, 0, 0);
INSERT INTO `activity` VALUES (26, 8, 'Supervising accounting', 'Accounting', 5, 1, 1, 1, 0, 0);
INSERT INTO `activity` VALUES (27, 8, 'Salary calculation', 'Salary', 5, 1, 1, 2, 0, 0);
INSERT INTO `activity` VALUES (28, 8, 'Employee rating', 'Employee', 5, 1, 1, 6, 0, 0);
INSERT INTO `activity` VALUES (29, 8, 'Tax reduction', 'Tax', 5, 1, 1, 3, 0, 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `city`
-- 

CREATE TABLE IF NOT EXISTS `city` (
  `city_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `city`
-- 

INSERT INTO `city` VALUES (1, 'Nashville TN');
INSERT INTO `city` VALUES (2, 'Los Angeles CA');
INSERT INTO `city` VALUES (3, 'Houston TX');
INSERT INTO `city` VALUES (4, 'Charlotte NC');

-- --------------------------------------------------------

-- 
-- Table structure for table `client`
-- 

CREATE TABLE IF NOT EXISTS `client` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_status` tinyint(4) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `city` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `kvk` varchar(20) NOT NULL,
  `btw` varchar(20) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `sex` enum('M','F') NOT NULL DEFAULT 'M',
  `hphone` varchar(50) NOT NULL,
  `mphone` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `p_address` varchar(255) NOT NULL,
  `mailbox` varchar(50) NOT NULL,
  `p_zip` varchar(20) NOT NULL,
  `p_city` varchar(255) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- 
-- Dumping data for table `client`
-- 

INSERT INTO `client` VALUES (1, 1, 'Sunburst''s Garden Management', '708 Emily Renzelli Boulevard', '93901', 'Salinas CA', '831-520-3088', '56461', '5354', 'Charles', 'Johnson', 'M', '831-520-3088', '831-520-3088', 'charles@gmail.com', '', '', '', '');
INSERT INTO `client` VALUES (2, 1, 'Checker Auto Parts', '2512 John Avenue', '48864', 'Okemos MI', '517-930-5714', '87798', '879789', 'Patricia', 'Davidson', 'F', '517-930-5714', '517-930-5714', 'patricia@gmail.com', '', '', '', '');
INSERT INTO `client` VALUES (3, 1, 'W. Bell & Co.', '4927 Burton Avenue', '38111', 'Memphis TN', '901-743-2265', '8876', '88668', 'Christina', 'Foley', 'F', '901-743-2265', '901-743-2265', 'christina@gmail.com', '', '', '', '');
INSERT INTO `client` VALUES (4, 1, 'Libera', '4477 Caldwell Road', '14428', 'Churchville NY', '585-293-8816', '786787', '6866867', 'David', 'Cress', 'M', '585-293-8816', '585-293-8816', 'david@gmail.com', '', '', '', '');
INSERT INTO `client` VALUES (5, 1, 'Envirotecture Design Service', '662 Hilltop Street', '413-627-3414', 'Springfield MA', '413-627-3414', '767757', '6759765', 'Richard', 'Gravitt', 'M', '909-626-5838', '413-627-3414', 'richard@gmail.com', '', '', '', '');
INSERT INTO `client` VALUES (6, 1, 'Sunny''s Surplus', '2695 Paradise Lane', '91711', 'Claremont CA', '909-626-5838', '534534', '5432542', 'Kimberly', 'Malone', 'F', '909-626-5838', '909-626-5838', 'kimberly@gmail.com', '', '', '', '');
INSERT INTO `client` VALUES (7, 1, 'Canal Villere', '2267 Coventry Court', '39501', 'Gulfport MS', '228-237-2104', '8527395', '98743284', 'Maria', 'Dever', 'F', '228-237-2104', '228-237-2104', 'maria@mail.com', '', '', '', '');
INSERT INTO `client` VALUES (8, 1, 'Hoyden', '4678 Mapleview Drive', '33566', 'Plant City FL', '727-946-1972', '66876', '687687', 'Eric', 'White', 'M', '727-946-1972', '727-946-1972', 'eric@gmail.com', '', '', '', '');
INSERT INTO `client` VALUES (9, 1, 'Grass Yard Services', '2077 Big Indian', '70112', 'New Orleans LA', '504-664-6410', '6342', '4328489', 'Samuel', 'Williams', 'M', '504-664-6410', '504-664-6410', 'samuel@gmail.com', '', '', '', '');
INSERT INTO `client` VALUES (10, 1, 'Gold Touch', '4125 Burwell Heights Road', '77591', 'Texas City TX', '409-643-5070', '67787', '867887', 'Ashley', 'Stroud', 'F', '409-643-5070', '409-643-5070', 'ashley@gmail.com', '', '', '', '');
INSERT INTO `client` VALUES (11, 1, 'Express Merchant Service', '3322 Still Pastures Drive', '29102', 'North Manning SC', '803-473-9166', '8678', '866786', 'Charles', 'Evans', 'M', '803-473-9166', '803-473-9166', 'charlesevans@gmail.com', '', '', '', '');
INSERT INTO `client` VALUES (12, 1, 'Whitlocks Auto Supply', '4996 Brooklyn Street', '97401', 'Eugene OR', '541-217-5506', '375432', '735834', 'Bobby', 'Marshall', 'M', '541-217-5506', '541-217-5506', 'bobby@gmail.com', '', '', '', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `department`
-- 

CREATE TABLE IF NOT EXISTS `department` (
  `department_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `department`
-- 

INSERT INTO `department` VALUES (1, 'Administration');
INSERT INTO `department` VALUES (2, 'Subsidies');
INSERT INTO `department` VALUES (3, 'Tax');
INSERT INTO `department` VALUES (4, 'Consultancy');
INSERT INTO `department` VALUES (5, 'Technical');
INSERT INTO `department` VALUES (6, 'Support');

-- --------------------------------------------------------

-- 
-- Table structure for table `event`
-- 

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity` int(11) NOT NULL,
  `title` varchar(512) CHARACTER SET utf8 NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `done` tinyint(4) NOT NULL DEFAULT '0',
  `allday` tinyint(4) NOT NULL DEFAULT '0',
  `employee` int(11) NOT NULL DEFAULT '0',
  `place` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `app` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

-- 
-- Dumping data for table `event`
-- 

INSERT INTO `event` VALUES (1, 1, 'Logo concept', '2014-11-18 07:00:00', '2014-11-18 11:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (2, 1, 'Logo concept', '2014-11-21 07:30:00', '2014-11-21 10:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (3, 2, 'Graphic design', '2014-11-19 00:00:00', '2014-11-19 00:00:00', 0, 0, 1, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (4, 3, 'Paperwork', '2014-11-19 07:00:00', '2014-11-19 08:30:00', 0, 1, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (5, 3, 'Paperwork', '2014-11-22 08:00:00', '2014-11-22 09:30:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (7, 4, 'Contacting clients', '2014-11-20 07:30:00', '2014-11-20 09:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (8, 4, 'Contacting clients', '2014-11-21 10:00:00', '2014-11-21 12:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (9, 5, 'Market Research', '2014-11-18 07:00:00', '2014-11-18 09:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (10, 5, 'Market Research', '2014-11-21 06:30:00', '2014-11-21 09:30:00', 0, 1, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (11, 6, 'Strategy Planning', '2014-11-18 07:30:00', '2014-11-18 09:30:00', 0, 1, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (12, 6, 'Strategy Planning', '2014-11-21 00:00:00', '2014-11-21 00:00:00', 0, 0, 1, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (13, 7, 'Article Planning', '2014-11-20 07:30:00', '2014-11-20 09:00:00', 0, 1, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (14, 7, 'Article Planning', '2014-11-19 00:00:00', '2014-11-19 00:00:00', 0, 0, 1, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (16, 8, 'Database Architecture', '2014-11-19 08:00:00', '2014-11-19 10:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (17, 8, 'Database Architecture', '2014-11-22 06:30:00', '2014-11-22 08:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (18, 9, 'CSS', '2014-11-19 07:30:00', '2014-11-19 11:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (19, 9, 'CSS', '2014-11-20 00:00:00', '2014-11-20 00:00:00', 0, 0, 1, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (20, 10, 'Client Side Scripting', '2014-11-19 00:00:00', '2014-11-19 00:00:00', 0, 0, 1, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (21, 10, 'Client Side Scripting', '2014-11-21 00:00:00', '2014-11-21 00:00:00', 0, 0, 1, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (22, 11, 'Server Side Programming', '2014-11-18 10:30:00', '2014-11-18 14:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (23, 12, 'Proofreading', '2014-11-17 06:30:00', '2014-11-17 10:30:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (24, 12, 'Proofreading', '2014-11-17 14:30:00', '2014-11-17 17:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (25, 0, 'Revision', '2014-11-20 09:30:00', '2014-11-20 12:00:00', 0, 0, 0, 1, NULL, NULL, 1);
INSERT INTO `event` VALUES (26, 0, 'Meeting with the clients', '2014-11-17 07:00:00', '2014-11-17 09:00:00', 0, 1, 0, 1, 'Main office', '333-222-22', 1);
INSERT INTO `event` VALUES (27, 0, 'Project brainstorming', '2014-11-22 10:00:00', '2014-11-22 12:00:00', 0, 1, 0, 3, 'Main office', '432-222-022', 1);
INSERT INTO `event` VALUES (28, 0, 'Project brainstorming', '2014-11-21 08:00:00', '2014-11-21 11:30:00', 0, 1, 0, 2, 'Main office', '323-3232-22', 1);
INSERT INTO `event` VALUES (29, 0, 'Project maintenance', '2014-11-16 08:00:00', '2014-11-16 09:30:00', 0, 1, 0, 2, 'Main building', '23123-31-2', 1);
INSERT INTO `event` VALUES (30, 0, 'Arrange papers', '2014-11-20 07:30:00', '2014-11-20 09:30:00', 0, 1, 0, 2, NULL, NULL, 1);
INSERT INTO `event` VALUES (31, 13, 'Tax management', '2014-11-17 06:00:00', '2014-11-17 08:30:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (32, 13, 'Tax management', '2014-11-17 10:30:00', '2014-11-17 12:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (33, 14, 'Salary management', '2014-11-14 07:30:00', '2014-11-14 10:00:00', 0, 1, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (34, 14, 'Salary management', '2014-11-10 07:00:00', '2014-11-10 09:30:00', 0, 1, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (35, 15, 'Mortgage research', '2014-11-11 08:30:00', '2014-11-11 11:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (36, 15, 'Mortgage research', '2014-11-14 06:30:00', '2014-11-14 08:30:00', 0, 1, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (37, 16, 'Subsidies calculation', '2014-11-18 07:30:00', '2014-11-18 09:30:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (38, 16, 'Subsidies calculation', '2014-11-21 06:00:00', '2014-11-21 08:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (39, 17, 'Logo design', '2014-11-11 07:00:00', '2014-11-11 09:30:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (40, 17, 'Logo design', '2014-11-14 09:00:00', '2014-11-14 10:30:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (41, 18, 'Flyer design', '2014-11-11 07:30:00', '2014-11-11 10:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (42, 18, 'Flyer design', '2014-11-13 07:00:00', '2014-11-13 09:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (43, 19, 'Online marketing', '2014-11-12 07:30:00', '2014-11-12 09:00:00', 0, 1, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (44, 19, 'Online marketing', '2014-11-10 00:00:00', '2014-11-10 00:00:00', 0, 0, 1, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (45, 20, 'Supervision', '2014-11-11 06:30:00', '2014-11-11 09:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (46, 20, 'Supervision', '2014-11-14 07:00:00', '2014-11-14 08:30:00', 0, 1, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (47, 21, 'Video production', '2014-11-12 07:00:00', '2014-11-12 08:00:00', 0, 1, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (48, 21, 'Video production', '2014-11-11 09:00:00', '2014-11-11 12:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (49, 0, 'Supervision', '2014-11-12 07:00:00', '2014-11-12 08:30:00', 0, 1, 0, 1, 'Main office', '222-222-2', 1);
INSERT INTO `event` VALUES (50, 0, 'Planning', '2014-11-10 06:00:00', '2014-11-10 08:00:00', 0, 1, 0, 3, 'Main office', '22-22-22', 1);
INSERT INTO `event` VALUES (51, 0, 'Supervision', '2014-11-10 07:30:00', '2014-11-10 10:00:00', 0, 0, 0, 1, NULL, NULL, 1);
INSERT INTO `event` VALUES (52, 0, 'Planning', '2014-11-13 07:30:00', '2014-11-13 09:30:00', 0, 0, 0, 2, NULL, NULL, 1);
INSERT INTO `event` VALUES (53, 22, 'Print design', '2014-11-05 07:30:00', '2014-11-05 09:30:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (54, 22, 'Print design', '2014-11-07 06:30:00', '2014-11-07 08:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (55, 23, 'Video distribution', '2014-11-04 06:30:00', '2014-11-04 09:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (56, 23, 'Video distribution', '2014-11-05 07:00:00', '2014-11-05 08:30:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (57, 24, 'Proofreading', '2014-11-04 07:00:00', '2014-11-04 09:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (58, 24, 'Proofreading', '2014-11-03 00:00:00', '2014-11-03 00:00:00', 0, 0, 1, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (59, 25, 'Checking balance', '2014-11-24 07:00:00', '2014-11-24 09:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (60, 25, 'Checking balance', '2014-11-27 06:30:00', '2014-11-27 09:30:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (61, 26, 'Supervising accounting', '2014-11-27 00:00:00', '2014-11-27 00:00:00', 0, 0, 1, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (62, 26, 'Supervising accounting', '2014-11-25 07:00:00', '2014-11-25 09:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (63, 27, 'Salary calculation', '2014-11-25 07:00:00', '2014-11-25 09:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (64, 27, 'Salary calculation', '2014-11-28 08:00:00', '2014-11-28 09:30:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (65, 28, 'Employee rating', '2014-11-19 07:00:00', '2014-11-19 09:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (66, 28, 'Employee rating', '2014-11-20 07:00:00', '2014-11-20 10:00:00', 0, 0, 0, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (67, 29, 'Tax reduction', '2014-11-28 00:00:00', '2014-11-28 00:00:00', 0, 0, 1, 0, NULL, NULL, 1);
INSERT INTO `event` VALUES (68, 0, 'Supervising Tax reduction', '2014-11-27 07:00:00', '2014-11-27 11:30:00', 0, 0, 0, 1, NULL, NULL, 1);
INSERT INTO `event` VALUES (69, 0, 'Meeting with Waz inc.', '2014-11-24 07:00:00', '2014-11-24 09:30:00', 0, 1, 0, 1, 'Main office', '22-11-11', 1);
INSERT INTO `event` VALUES (70, 0, 'Meeting with the client', '2014-11-26 07:00:00', '2014-11-26 08:30:00', 0, 1, 0, 3, 'Main office', '222-222-222', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `function`
-- 

CREATE TABLE IF NOT EXISTS `function` (
  `function_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`function_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- Dumping data for table `function`
-- 

INSERT INTO `function` VALUES (1, 'CEO');
INSERT INTO `function` VALUES (2, 'Manager');
INSERT INTO `function` VALUES (3, 'Accountant');
INSERT INTO `function` VALUES (4, 'Assistant Accountant');
INSERT INTO `function` VALUES (5, 'Administration Worker');
INSERT INTO `function` VALUES (6, 'Subsidies Advisor');
INSERT INTO `function` VALUES (7, 'Journalist');
INSERT INTO `function` VALUES (8, 'Web Developer');
INSERT INTO `function` VALUES (9, 'Graphic Designer');

-- --------------------------------------------------------

-- 
-- Table structure for table `project`
-- 

CREATE TABLE IF NOT EXISTS `project` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` enum('internal','external') NOT NULL DEFAULT 'external',
  `client` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `manager` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- 
-- Dumping data for table `project`
-- 

INSERT INTO `project` VALUES (1, 'Branding and Logo', 'Branding services.', 'external', 1, 55, 1, 44, '2014-11-20', '2015-02-19', 1);
INSERT INTO `project` VALUES (2, 'Accounting', 'Tax and salaries', 'external', 1, 22, 1, 32, '2014-11-20', '2015-02-13', 1);
INSERT INTO `project` VALUES (3, 'Marketing', 'Promotion', 'external', 4, 55, 2, 44, '2014-11-12', '2015-03-13', 1);
INSERT INTO `project` VALUES (4, 'App Development', 'Develop', 'external', 12, 55, 1, 55, '2014-11-10', '2015-01-16', 1);
INSERT INTO `project` VALUES (5, 'Accounting', 'Paperwork', 'external', 3, 44, 2, 55, '2014-10-04', '2015-01-16', 1);
INSERT INTO `project` VALUES (6, 'Branding', 'Branding', 'external', 11, 55, 2, 55, '2014-10-07', '2014-12-12', 1);
INSERT INTO `project` VALUES (7, 'Marketing', 'Marketing', 'external', 5, 44, 1, 55, '2014-09-02', '2015-01-09', 1);
INSERT INTO `project` VALUES (8, 'Accounting', 'Accounting', 'external', 6, 55, 1, 55, '2014-11-11', '2014-12-13', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `tariff`
-- 

CREATE TABLE IF NOT EXISTS `tariff` (
  `tariff_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`tariff_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `tariff`
-- 

INSERT INTO `tariff` VALUES (1, 'Default Tariff');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`user_id` int(11) NOT NULL,
  `user_level` tinyint(4) NOT NULL DEFAULT '3',
  `user_active` tinyint(4) NOT NULL DEFAULT '1',
  `username` varchar(20) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sex` enum('M','F') NOT NULL DEFAULT 'F',
  `birthdate` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `residence` varchar(255) NOT NULL,
  `hphone` varchar(50) NOT NULL,
  `mphone` varchar(50) NOT NULL,
  `function` tinyint(4) NOT NULL,
  `department` tinyint(4) NOT NULL,
  `d_employment` date NOT NULL,
  `d_service` date NOT NULL,
  `hour_wage` float NOT NULL,
  `tarrif` tinyint(4) NOT NULL,
  `min_hours` tinyint(4) NOT NULL,
  `city` tinyint(4) NOT NULL,
  `skin` enum('light','dark') NOT NULL DEFAULT 'light',
  `layout` enum('fluid','fixed') NOT NULL DEFAULT 'fluid',
  `avatar` varchar(30) NOT NULL DEFAULT 'icon-young19'
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_level`, `user_active`, `username`, `fname`, `lname`, `email`, `password`, `timestamp`, `sex`, `birthdate`, `address`, `zip`, `residence`, `hphone`, `mphone`, `function`, `department`, `d_employment`, `d_service`, `hour_wage`, `tarrif`, `min_hours`, `city`, `skin`, `layout`, `avatar`) VALUES
(1, 1, 1, 'admin', 'Janice', 'Gaston', 'admin@google.com', 'e00cf25ad42683b3df678c61f42c6bda', '2014-11-19 17:25:31', 'F', '1981-11-19', '85 Wilkinson Street', '37201', 'Nashville', '615-427-1307', '615-427-1307', 1, 1, '2014-07-15', '2015-04-16', 2, 1, 5, 1, 'light', 'fluid', 'icon-woman104'),
(2, 2, 1, 'manager', 'Robert', 'Martin', 'manager@gmail.com', 'c240642ddef994358c96da82c0361a58', '2014-11-20 09:10:41', 'M', '1987-11-29', '3237 Corbin Branch Road', '37921', 'Knoxville TN', '423-427-5841', '423-427-5841', 2, 1, '2010-11-03', '2018-02-20', 2, 1, 5, 1, 'light', 'fluid', 'icon-young19'),
(3, 3, 1, 'employee', 'Oscar', 'Kirk', 'employee@gmail.com', '03a395eaf1edb673e0f99c7ca8eb156a', '2014-11-20 09:14:30', 'M', '1981-08-13', '1475 Shady Pines Drive', '42431', 'Madisonville KY', '270-963-6152', '270-963-6152', 3, 3, '2010-11-06', '2020-11-14', 2, 1, 5, 2, 'light', 'fluid', 'icon-nerd8'),
(4, 3, 1, 'michael', 'Michael', 'McFarland', 'michael@gmail.com', '8f9b97bf3fad640ca17e9627e6bba1fd', '2014-11-20 09:18:45', 'M', '1988-07-02', '4130 Post Avenue', '55708', 'Biwabik MN', '218-865-1777', '218-865-1777', 5, 6, '2010-08-11', '2018-11-22', 4, 1, 5, 3, 'light', 'fluid', 'icon-young19'),
(5, 3, 1, 'lavonne', 'Lavonne', 'Clark', 'lavonne@gmail.com', '66160be3b6c78efb954959964985ca9e', '2014-11-20 09:21:35', 'F', '1990-06-12', '3385 Kovar Road', '02142', 'Cambridge MA', '508-613-8702', '508-613-8702', 9, 5, '2010-05-21', '2019-11-12', 5, 1, 6, 3, 'light', 'fluid', 'icon-young19'),
(6, 3, 1, 'samuel', 'Samuel', 'Butler', 'samuel@gmail.com', 'c5c03284a4259a21a453417472af2b83', '2014-11-20 09:23:56', 'M', '1980-11-08', '511 Sardis Station', '55402', 'Minneapolis', '612-397-6749', '612-397-6749', 8, 5, '2010-08-13', '2018-11-01', 5, 1, 5, 3, 'light', 'fluid', 'icon-young19'),
(7, 3, 1, 'judy', 'Judy', 'Farmer', 'judy@gmail.com', 'f85be1a4a869f887a90887bcf3d3848d', '2014-11-20 09:27:15', 'F', '1981-07-03', '1220 Leroy Lane', '40507', 'Lexington KY', '606-236-8170', '606-236-8170', 7, 4, '2010-11-05', '2019-11-05', 6, 1, 3, 3, 'light', 'fluid', 'icon-young19'),
(8, 3, 1, 'beverly', 'Beverly', 'McGrath', 'beverly@gmail.com', '9536637df923b3aad6dde0a80d7cd7e4', '2014-11-20 09:30:20', 'F', '1990-09-02', '3337 John Calvin Drive', '60300', 'Oak Park IL', '708-848-9875', '708-848-9875', 7, 4, '2010-11-06', '2019-01-15', 5, 1, 5, 3, 'light', 'fluid', 'icon-young19'),
(9, 3, 1, 'calvin', 'Calvin', 'Chandler', 'calvin@gmail.com', '0d10816f0747122b364be502ad5a360c', '2014-11-20 09:33:17', 'M', '1990-07-08', '3954 Trails End Road', '33131', 'Miami FL', '954-283-4768', '954-283-4768', 6, 1, '2010-11-08', '2018-11-09', 5, 1, 5, 3, 'light', 'fluid', 'icon-young19');

-- --------------------------------------------------------

-- --------------------------------------------------------

-- 
-- Table structure for table `user_levels`
-- 

CREATE TABLE IF NOT EXISTS `user_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `level` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `user_levels`
-- 

INSERT INTO `user_levels` VALUES (1, 'Administrator', 1);
INSERT INTO `user_levels` VALUES (2, 'Manager', 2);
INSERT INTO `user_levels` VALUES (3, 'Employee', 3);

-- --------------------------------------------------------

-- 
-- Table structure for table `workday`
-- 

CREATE TABLE IF NOT EXISTS `workday` (
  `workday_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `en` varchar(20) NOT NULL,
  `nl` varchar(20) NOT NULL,
  PRIMARY KEY (`workday_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `workday`
-- 

INSERT INTO `workday` VALUES (1, 'Monday', 'Maandag');
INSERT INTO `workday` VALUES (2, 'Tuesday', 'Dinsdag');
INSERT INTO `workday` VALUES (3, 'Wednesday', 'Woensdag');
INSERT INTO `workday` VALUES (4, 'Thursday', 'Donderdag');
INSERT INTO `workday` VALUES (5, 'Friday', 'Vrijdag');
INSERT INTO `workday` VALUES (6, 'Saturday', 'Zaterdag');
INSERT INTO `workday` VALUES (7, 'Sunday', 'Zondag');

-- --------------------------------------------------------

-- 
-- Table structure for table `working`
-- 

CREATE TABLE IF NOT EXISTS `working` (
  `user` tinyint(4) NOT NULL,
  `workday` tinyint(4) NOT NULL,
  PRIMARY KEY (`user`,`workday`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `working`
-- 

INSERT INTO `working` VALUES (1, 1);
INSERT INTO `working` VALUES (1, 2);
INSERT INTO `working` VALUES (1, 3);
INSERT INTO `working` VALUES (1, 4);
INSERT INTO `working` VALUES (1, 5);
INSERT INTO `working` VALUES (2, 1);
INSERT INTO `working` VALUES (2, 2);
INSERT INTO `working` VALUES (2, 3);
INSERT INTO `working` VALUES (2, 4);
INSERT INTO `working` VALUES (2, 5);
INSERT INTO `working` VALUES (3, 1);
INSERT INTO `working` VALUES (3, 2);
INSERT INTO `working` VALUES (3, 3);
INSERT INTO `working` VALUES (3, 4);
INSERT INTO `working` VALUES (3, 5);
INSERT INTO `working` VALUES (4, 1);
INSERT INTO `working` VALUES (4, 2);
INSERT INTO `working` VALUES (4, 3);
INSERT INTO `working` VALUES (4, 4);
INSERT INTO `working` VALUES (4, 5);
INSERT INTO `working` VALUES (5, 1);
INSERT INTO `working` VALUES (5, 2);
INSERT INTO `working` VALUES (5, 3);
INSERT INTO `working` VALUES (5, 4);
INSERT INTO `working` VALUES (5, 5);
INSERT INTO `working` VALUES (6, 1);
INSERT INTO `working` VALUES (6, 2);
INSERT INTO `working` VALUES (6, 3);
INSERT INTO `working` VALUES (6, 4);
INSERT INTO `working` VALUES (6, 5);
INSERT INTO `working` VALUES (7, 1);
INSERT INTO `working` VALUES (7, 2);
INSERT INTO `working` VALUES (7, 3);
INSERT INTO `working` VALUES (7, 4);
INSERT INTO `working` VALUES (7, 5);
INSERT INTO `working` VALUES (8, 1);
INSERT INTO `working` VALUES (8, 2);
INSERT INTO `working` VALUES (8, 3);
INSERT INTO `working` VALUES (8, 4);
INSERT INTO `working` VALUES (8, 5);
INSERT INTO `working` VALUES (9, 1);
INSERT INTO `working` VALUES (9, 2);
INSERT INTO `working` VALUES (9, 3);
INSERT INTO `working` VALUES (9, 4);

-- --------------------------------------------------------

-- 
-- Table structure for table `working_on_project`
-- 

CREATE TABLE IF NOT EXISTS `working_on_project` (
  `user` int(11) NOT NULL,
  `project` int(11) NOT NULL,
  PRIMARY KEY (`user`,`project`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `working_on_project`
-- 

INSERT INTO `working_on_project` VALUES (1, 4);
INSERT INTO `working_on_project` VALUES (1, 5);
INSERT INTO `working_on_project` VALUES (1, 7);
INSERT INTO `working_on_project` VALUES (1, 8);
INSERT INTO `working_on_project` VALUES (2, 4);
INSERT INTO `working_on_project` VALUES (2, 6);
INSERT INTO `working_on_project` VALUES (2, 8);
INSERT INTO `working_on_project` VALUES (3, 4);
INSERT INTO `working_on_project` VALUES (4, 7);
INSERT INTO `working_on_project` VALUES (4, 8);
INSERT INTO `working_on_project` VALUES (5, 5);
INSERT INTO `working_on_project` VALUES (5, 7);
INSERT INTO `working_on_project` VALUES (5, 8);
INSERT INTO `working_on_project` VALUES (6, 5);
INSERT INTO `working_on_project` VALUES (6, 6);
INSERT INTO `working_on_project` VALUES (7, 5);
INSERT INTO `working_on_project` VALUES (8, 6);



--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
`id` int(11) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `activity` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `name`, `size`, `type`, `url`, `title`, `description`, `activity`) VALUES
(1, '0e5712f87f8e17e4035afdec16f038e9.xlsx', 27347, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', NULL, 'Final calculations', NULL, 3),
(2, '879661bb0d6e54a6f39bc751a12d892f.pptx', 36273, 'application/vnd.openxmlformats-officedocument.presentationml.presentation', NULL, 'Team presentation', NULL, 3),
(3, '237528928227dfdfcbf8952621da64fe.jpg', 75850, 'image/jpeg', NULL, 'Employee chart', NULL, 3),
(8, '134ea31cccf1f8a63e5a80b5397918f2.docx', 27341, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', NULL, 'Research', NULL, 20),
(9, 'd3ee065b3c6e4caca921b97fce6d1dc7.xlsx', 27347, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', NULL, 'Workload table', NULL, 9),
(10, '454ac4437079fd824792d142a976f571.jpg', 75850, 'image/jpeg', NULL, 'Workload', NULL, 27),
(11, '18f539c543a1997181d191437a384689.docx', 27341, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', NULL, 'Agency list', NULL, 6),
(12, 'bae9cc40944e9230dac933c35de8a3cc.xlsx', 27347, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', NULL, 'Basic data', NULL, 5),
(13, '47d6f612c4fef9c1945a1997b59b4c90.xlsx', 27347, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', NULL, 'Company data', NULL, 12),
(14, '2abf0b45878930d3e5547a9821224963.jpg', 75850, 'image/jpeg', NULL, 'Users chart', NULL, 19);
