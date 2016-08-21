-- 
-- Database: `voice_vote`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `call_logs`
-- 

CREATE TABLE `call_logs` (
  `rec_num` int(5) NOT NULL auto_increment,
  `log_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `session_id` varchar(32) NOT NULL default '',
  `cutoff` int(1) NOT NULL default '0',
  `status` int(1) NOT NULL default '0',
  `ed` int(3) NOT NULL default '0',
  `rd` int(3) NOT NULL default '0',
  `sd` int(3) NOT NULL default '0',
  `error` int(1) NOT NULL default '0',
  `noinput` int(1) NOT NULL default '0',
  `nomatch` int(1) NOT NULL default '0',
  `call_length` int(5) NOT NULL default '0',
  PRIMARY KEY  (`rec_num`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- 
-- Dumping data for table `call_logs`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `offices`
-- 

CREATE TABLE `offices` (
  `off_num` int(3) NOT NULL default '0',
  `off_name` varchar(50) NOT NULL default '',
  `cand_num` int(3) NOT NULL default '0',
  `ed` int(3) NOT NULL default '0',
  `cand_f_name` varchar(50) NOT NULL default '',
  `cand_l_name` varchar(50) NOT NULL default '',
  `party` char(1) NOT NULL default '',
  `vote_total` int(9) NOT NULL default '0',
  UNIQUE KEY `cand_num` (`cand_num`),
  KEY `ed` (`ed`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `offices`
-- 

INSERT INTO `offices` VALUES (101, 'Governor', 1, 3, 'Rock', 'Hudson', 'D', 0);
INSERT INTO `offices` VALUES (101, 'Governor', 2, 3, 'Marilyn', 'Manson', 'R', 0);
INSERT INTO `offices` VALUES (102, 'Mayor', 3, 3, 'Chappy', 'McDonald', 'R', 0);
INSERT INTO `offices` VALUES (102, 'Mayor', 4, 3, 'Patches', 'Douglas', 'D', 0);
INSERT INTO `offices` VALUES (103, 'Treasurer', 5, 3, 'Albert', 'Jones', 'R', 0);
INSERT INTO `offices` VALUES (103, 'Treasurer', 6, 3, 'Molly', 'Johnson', 'D', 0);
INSERT INTO `offices` VALUES (104, 'Super Stud', 7, 3, 'Bo', 'Johnson', 'R', 0);
INSERT INTO `offices` VALUES (104, 'Super Stud', 8, 3, 'Lance', 'Murdock', 'D', 0);

-- --------------------------------------------------------

-- 
-- Table structure for table `vote_history`
-- 

CREATE TABLE `vote_history` (
  `number` int(9) NOT NULL default '0',
  `attempts` int(2) NOT NULL default '0',
  `vote_try` datetime NOT NULL default '0000-00-00 00:00:00',
  `vote_finish` datetime NOT NULL default '0000-00-00 00:00:00',
  `vote_confirm` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `vote_history`
-- 

INSERT INTO `vote_history` VALUES (1, 1, '2006-11-28 00:00:00', '2006-11-28 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `vote_history` VALUES (2, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `vote_history` VALUES (3, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

-- 
-- Table structure for table `voters`
-- 

CREATE TABLE `voters` (
  `number` int(9) NOT NULL default '0',
  `f_name` varchar(50) NOT NULL default '',
  `l_name` varchar(50) NOT NULL default '',
  `ani` varchar(10) NOT NULL default '',
  `id` varchar(32) NOT NULL default '0',
  `ed` int(3) NOT NULL default '0',
  `rd` int(3) NOT NULL default '0',
  `sd` int(3) NOT NULL default '0',
  `status` int(1) NOT NULL default '0',
  PRIMARY KEY  (`number`),
  KEY `ani` (`ani`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `voters`
-- 

INSERT INTO `voters` VALUES (1, 'Hugh', 'Sarf', '2125551212', '25f9e794323b453885f5181f1b624d0b', 3, 10, 17, 1);
INSERT INTO `voters` VALUES (2, 'Charles', 'VanNostren', '4102578963', '25f9e794323b453885f5181f1b624d0b', 3, 10, 17, 0);
INSERT INTO `voters` VALUES (3, 'Art', 'Vandelay', '3157894568', 'c1476bbe95e3a3c9f6877611fefe8625', 3, 10, 17, 0);
