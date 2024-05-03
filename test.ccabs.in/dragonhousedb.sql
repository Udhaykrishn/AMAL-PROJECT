-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 21, 2017 at 06:16 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dragonhousedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblaccomodation`
--

CREATE TABLE IF NOT EXISTS `tblaccomodation` (
  `ACCOMID` int(11) NOT NULL AUTO_INCREMENT,
  `ACCOMODATION` varchar(30) NOT NULL,
  `ACCOMDESC` varchar(90) NOT NULL,
  PRIMARY KEY (`ACCOMID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `tblaccomodation`
--

INSERT INTO `tblaccomodation` (`ACCOMID`, `ACCOMODATION`, `ACCOMDESC`) VALUES
(12, 'Standard Room', 'max 22hrs.'),
(13, 'Travelers Time', 'max of 12hrs.'),
(15, 'Bayanihan Room', 'max 22hrs.');

-- --------------------------------------------------------

--
-- Table structure for table `tblauto`
--

CREATE TABLE IF NOT EXISTS `tblauto` (
  `autoid` int(11) NOT NULL AUTO_INCREMENT,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  PRIMARY KEY (`autoid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tblauto`
--

INSERT INTO `tblauto` (`autoid`, `start`, `end`) VALUES
(1, 11122, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblfirstpartition`
--

CREATE TABLE IF NOT EXISTS `tblfirstpartition` (
  `FirstPID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstPTitle` text NOT NULL,
  `FirstPImage` varchar(99) NOT NULL,
  `FirstPSubTitle` text NOT NULL,
  `FirstPDescription` text NOT NULL,
  PRIMARY KEY (`FirstPID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tblfirstpartition`
--

INSERT INTO `tblfirstpartition` (`FirstPID`, `FirstPTitle`, `FirstPImage`, `FirstPSubTitle`, `FirstPDescription`) VALUES
(1, 'Welcome to Sea Luxure', '5page-img1.png', 'In our Hotel', 'Located on the hills of Nice, a short distance from the famous Promenade des Anglais, Hotel Anis is one of the hotels in the Costa Azzurra (or Blue Coast) able to satisfy the different needs of its guests with comfort and first rate services. It is only 2 km from the airport and from highway exits. The hotel has a large parking area , a real luxury in a city like Nice.');

-- --------------------------------------------------------

--
-- Table structure for table `tblguest`
--

CREATE TABLE IF NOT EXISTS `tblguest` (
  `GUESTID` int(11) NOT NULL AUTO_INCREMENT,
  `REFNO` int(11) NOT NULL,
  `G_FNAME` varchar(30) NOT NULL,
  `G_LNAME` varchar(30) NOT NULL,
  `G_CITY` varchar(90) NOT NULL,
  `G_ADDRESS` varchar(90) NOT NULL,
  `DBIRTH` date NOT NULL,
  `G_PHONE` varchar(20) NOT NULL,
  `G_NATIONALITY` varchar(30) NOT NULL,
  `G_COMPANY` varchar(90) NOT NULL,
  `G_CADDRESS` varchar(90) NOT NULL,
  `G_TERMS` tinyint(4) NOT NULL,
  `G_EMAIL` varchar(99) NOT NULL,
  `G_UNAME` varchar(255) NOT NULL,
  `G_PASS` varchar(255) NOT NULL,
  `ZIP` int(11) NOT NULL,
  `LOCATION` varchar(125) NOT NULL,
  PRIMARY KEY (`GUESTID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tblguest`
--


-- --------------------------------------------------------

--
-- Table structure for table `tblmeal`
--

CREATE TABLE IF NOT EXISTS `tblmeal` (
  `MealID` int(11) NOT NULL AUTO_INCREMENT,
  `MealType` varchar(90) NOT NULL,
  `MealPrice` double NOT NULL,
  PRIMARY KEY (`MealID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tblmeal`
--

INSERT INTO `tblmeal` (`MealID`, `MealType`, `MealPrice`) VALUES
(4, 'Lunch', 10),
(7, 'HB', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tblpayment`
--

CREATE TABLE IF NOT EXISTS `tblpayment` (
  `SUMMARYID` int(11) NOT NULL AUTO_INCREMENT,
  `TRANSDATE` datetime NOT NULL,
  `CONFIRMATIONCODE` varchar(30) NOT NULL,
  `PQTY` int(11) NOT NULL,
  `GUESTID` int(11) NOT NULL,
  `SPRICE` double NOT NULL,
  `MSGVIEW` tinyint(1) NOT NULL,
  `STATUS` varchar(30) NOT NULL,
  PRIMARY KEY (`SUMMARYID`),
  UNIQUE KEY `CONFIRMATIONCODE` (`CONFIRMATIONCODE`),
  KEY `GUESTID` (`GUESTID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tblpayment`
--


-- --------------------------------------------------------

--
-- Table structure for table `tblreservation`
--

CREATE TABLE IF NOT EXISTS `tblreservation` (
  `RESERVEID` int(11) NOT NULL AUTO_INCREMENT,
  `CONFIRMATIONCODE` varchar(50) NOT NULL,
  `TRANSDATE` date NOT NULL,
  `ROOMID` int(11) NOT NULL,
  `ARRIVAL` datetime NOT NULL,
  `DEPARTURE` datetime NOT NULL,
  `RPRICE` double NOT NULL,
  `GUESTID` int(11) NOT NULL,
  `PRORPOSE` varchar(30) NOT NULL,
  `STATUS` varchar(11) NOT NULL,
  `BOOKDATE` datetime NOT NULL,
  `REMARKS` text NOT NULL,
  `USERID` int(11) NOT NULL,
  PRIMARY KEY (`RESERVEID`),
  KEY `ROOMID` (`ROOMID`),
  KEY `GUESTID` (`GUESTID`),
  KEY `CONFIRMATIONCODE` (`CONFIRMATIONCODE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tblreservation`
--


-- --------------------------------------------------------

--
-- Table structure for table `tblroom`
--

CREATE TABLE IF NOT EXISTS `tblroom` (
  `ROOMID` int(11) NOT NULL AUTO_INCREMENT,
  `ROOMNUM` int(11) NOT NULL,
  `ACCOMID` int(11) NOT NULL,
  `ROOM` varchar(30) NOT NULL,
  `ROOMDESC` varchar(255) NOT NULL,
  `NUMPERSON` int(11) NOT NULL,
  `PRICE` double NOT NULL,
  `ROOMIMAGE` varchar(255) NOT NULL,
  `OROOMNUM` int(11) NOT NULL,
  `RoomTypeID` int(11) NOT NULL,
  PRIMARY KEY (`ROOMID`),
  KEY `ACCOMID` (`ACCOMID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `tblroom`
--

INSERT INTO `tblroom` (`ROOMID`, `ROOMNUM`, `ACCOMID`, `ROOM`, `ROOMDESC`, `NUMPERSON`, `PRICE`, `ROOMIMAGE`, `OROOMNUM`, `RoomTypeID`) VALUES
(11, 0, 12, 'Wing A', 'without TV', 1, 10, 'rooms/1.jpg', 1, 0),
(12, 0, 12, 'Wing A', 'Without TV', 2, 15, 'rooms/1.jpg', 1, 0),
(13, 1, 13, 'Wing A', 'Without TV', 1, 445, 'rooms/2.jpg', 3, 0),
(14, 2, 13, 'Wing A', 'Without TV', 2, 495, 'rooms/3.jpg', 4, 0),
(15, 1, 15, 'Wing A', 'Without TV | for groups - minimum of 5 pax | 250php per person', 5, 1250, 'rooms/4.jpg', 1, 0),
(16, -2, 12, 'Wing B and Ground Floor', 'With TV', 1, 725, 'rooms/3page-img13.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblroomtype`
--

CREATE TABLE IF NOT EXISTS `tblroomtype` (
  `RoomTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `RoomType` varchar(30) NOT NULL,
  PRIMARY KEY (`RoomTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tblroomtype`
--


-- --------------------------------------------------------

--
-- Table structure for table `tblslideshow`
--

CREATE TABLE IF NOT EXISTS `tblslideshow` (
  `SlideID` int(11) NOT NULL AUTO_INCREMENT,
  `SlideImage` text NOT NULL,
  `SlideCaption` text NOT NULL,
  PRIMARY KEY (`SlideID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `tblslideshow`
--

INSERT INTO `tblslideshow` (`SlideID`, `SlideImage`, `SlideCaption`) VALUES
(15, 'images.jpg', ''),
(16, 'slide-image-3.jpg', ''),
(17, 'header-bg1.jpg', ''),
(18, 'slide-image-3.jpg', ''),
(19, 'Desert.jpg', ''),
(20, 'Koala.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbltitle`
--

CREATE TABLE IF NOT EXISTS `tbltitle` (
  `TItleID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` text NOT NULL,
  `Subtitle` text NOT NULL,
  PRIMARY KEY (`TItleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbltitle`
--

INSERT INTO `tbltitle` (`TItleID`, `Title`, `Subtitle`) VALUES
(1, 'Sea Luxure', '24hrs.');

-- --------------------------------------------------------

--
-- Table structure for table `tbluseraccount`
--

CREATE TABLE IF NOT EXISTS `tbluseraccount` (
  `USERID` int(11) NOT NULL AUTO_INCREMENT,
  `UNAME` varchar(30) NOT NULL,
  `USER_NAME` varchar(30) NOT NULL,
  `UPASS` varchar(90) NOT NULL,
  `ROLE` varchar(30) NOT NULL,
  `PHONE` int(11) NOT NULL,
  PRIMARY KEY (`USERID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbluseraccount`
--

INSERT INTO `tbluseraccount` (`USERID`, `UNAME`, `USER_NAME`, `UPASS`, `ROLE`, `PHONE`) VALUES
(1, 'Anonymous', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrator', 912856478);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_setting_contact`
--

CREATE TABLE IF NOT EXISTS `tbl_setting_contact` (
  `SetCon_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SetConLocation` varchar(99) NOT NULL,
  `SetConEmail` varchar(99) NOT NULL,
  `SetConContactNo` varchar(99) NOT NULL,
  PRIMARY KEY (`SetCon_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_setting_contact`
--

INSERT INTO `tbl_setting_contact` (`SetCon_ID`, `SetConLocation`, `SetConEmail`, `SetConContactNo`) VALUES
(1, 'Beach Road, Manglore, Karnataka', 'info@sealuxure.com', '(7510173263');
