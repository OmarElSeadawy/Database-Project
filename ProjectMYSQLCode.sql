-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 08, 2019 at 08:37 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

DROP TABLE IF EXISTS `area`;
CREATE TABLE IF NOT EXISTS `area` (
  `areaID` int(6) NOT NULL,
  `areaname` varchar(10) NOT NULL,
  `city` varchar(10) NOT NULL,
  PRIMARY KEY (`areaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

DROP TABLE IF EXISTS `branch`;
CREATE TABLE IF NOT EXISTS `branch` (
  `branchID` int(6) NOT NULL,
  `restaurantID` int(6) NOT NULL,
  `openinghrs` time NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`branchID`,`restaurantID`),
  KEY `restaurantID` (`restaurantID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `branchdeliveryarea`
--

DROP TABLE IF EXISTS `branchdeliveryarea`;
CREATE TABLE IF NOT EXISTS `branchdeliveryarea` (
  `branchID` int(6) NOT NULL,
  `restaurantID` int(6) NOT NULL,
  `areaID` int(6) NOT NULL,
  `deliverycost` decimal(4,2) NOT NULL,
  PRIMARY KEY (`branchID`,`restaurantID`,`areaID`),
  KEY `restaurantID` (`restaurantID`,`branchID`),
  KEY `areaID` (`areaID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `branchphoneno`
--

DROP TABLE IF EXISTS `branchphoneno`;
CREATE TABLE IF NOT EXISTS `branchphoneno` (
  `branchID` int(6) NOT NULL,
  `restaurantID` int(6) NOT NULL,
  `phoneno` varchar(11) NOT NULL,
  PRIMARY KEY (`branchID`,`restaurantID`,`phoneno`),
  KEY `branchID` (`branchID`,`restaurantID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `changepassword`
--

DROP TABLE IF EXISTS `changepassword`;
CREATE TABLE IF NOT EXISTS `changepassword` (
  `changeID` int(6) NOT NULL,
  `adminUUID` int(6) NOT NULL,
  `changedUUID` int(6) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`changeID`),
  KEY `adminUUID` (`adminUUID`),
  KEY `changedUUID` (`changedUUID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customitem`
--

DROP TABLE IF EXISTS `customitem`;
CREATE TABLE IF NOT EXISTS `customitem` (
  `customname` varchar(20) NOT NULL,
  `itemID` int(6) NOT NULL,
  `isAvailable` int(1) NOT NULL,
  `price` decimal(4,2) NOT NULL,
  PRIMARY KEY (`customname`,`itemID`),
  KEY `itemID` (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

DROP TABLE IF EXISTS `discount`;
CREATE TABLE IF NOT EXISTS `discount` (
  `discountID` int(6) NOT NULL,
  `discountpercentage` decimal(2,2) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  PRIMARY KEY (`discountID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `discountcode`
--

DROP TABLE IF EXISTS `discountcode`;
CREATE TABLE IF NOT EXISTS `discountcode` (
  `codeID` int(6) NOT NULL,
  `discountpercentage` decimal(2,2) NOT NULL,
  `uses` int(11) NOT NULL,
  PRIMARY KEY (`codeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `itemid` int(6) NOT NULL,
  `itemname` varchar(20) NOT NULL,
  `itemdescription` text NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `restaurantID` int(6) NOT NULL,
  `menuID` int(6) NOT NULL,
  `menutype` varchar(10) NOT NULL,
  `startsat` time NOT NULL,
  `endsat` time NOT NULL,
  PRIMARY KEY (`restaurantID`,`menuID`,`menutype`),
  KEY `restaurantID` (`restaurantID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menuitems`
--

DROP TABLE IF EXISTS `menuitems`;
CREATE TABLE IF NOT EXISTS `menuitems` (
  `restaurantID` int(6) NOT NULL,
  `menuID` int(6) NOT NULL,
  `menutype` varchar(10) NOT NULL,
  `itemID` int(6) NOT NULL,
  PRIMARY KEY (`restaurantID`,`menuID`,`menutype`,`itemID`),
  KEY `itemID` (`itemID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `modifyuser`
--

DROP TABLE IF EXISTS `modifyuser`;
CREATE TABLE IF NOT EXISTS `modifyuser` (
  `modificationID` int(6) NOT NULL,
  `uuid` int(6) NOT NULL,
  `modifieduuid` int(6) NOT NULL,
  `modificationType` int(1) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`modificationID`),
  KEY `modifieduuid` (`modifieduuid`),
  KEY `uuid` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orderaddress`
--

DROP TABLE IF EXISTS `orderaddress`;
CREATE TABLE IF NOT EXISTS `orderaddress` (
  `orderID` int(6) NOT NULL,
  `uuid` int(6) NOT NULL,
  `addressid` int(6) NOT NULL,
  PRIMARY KEY (`orderID`,`uuid`,`addressid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

DROP TABLE IF EXISTS `orderitems`;
CREATE TABLE IF NOT EXISTS `orderitems` (
  `orderID` int(6) NOT NULL,
  `itemID` int(6) NOT NULL,
  `customname` varchar(20) NOT NULL,
  PRIMARY KEY (`orderID`,`itemID`,`customname`),
  KEY `itemID` (`itemID`,`customname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `branchID` int(6) NOT NULL,
  `restaurantID` int(6) NOT NULL,
  `orderID` int(6) NOT NULL,
  `discountID` int(6) NOT NULL,
  `codeID` int(6) NOT NULL,
  `orderstatus` varchar(10) NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`orderID`),
  KEY `branchID` (`branchID`,`restaurantID`),
  KEY `codeID` (`codeID`),
  KEY `discountID` (`discountID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

DROP TABLE IF EXISTS `restaurant`;
CREATE TABLE IF NOT EXISTS `restaurant` (
  `restaurantID` int(6) NOT NULL,
  `restaurantname` text NOT NULL,
  PRIMARY KEY (`restaurantID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `restaurantcuisine`
--

DROP TABLE IF EXISTS `restaurantcuisine`;
CREATE TABLE IF NOT EXISTS `restaurantcuisine` (
  `restaurantID` int(6) NOT NULL,
  `cuisineType` varchar(10) NOT NULL,
  PRIMARY KEY (`restaurantID`,`cuisineType`),
  KEY `restaurantID` (`restaurantID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `UUID` int(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  `bdate` date NOT NULL,
  `gender` char(1) NOT NULL,
  `usertype` int(1) NOT NULL,
  `fname` varchar(16) NOT NULL,
  `lname` varchar(16) NOT NULL,
  `email` text NOT NULL,
  `isActive` int(1) NOT NULL,
  PRIMARY KEY (`UUID`),
  UNIQUE KEY `unique_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UUID`, `username`, `password`, `bdate`, `gender`, `usertype`, `fname`, `lname`, `email`, `isActive`) VALUES
(1, 'admin', 'admin', '1997-03-26', 'M', 0, 'Omar', 'ElSeadawy', 'omarelseadawy@aucegypt.edu', 1),
(16, 'Omar', 'afk4lifE', '1997-03-26', 'M', 2, 'Omar', 'Ashraf', 'omarelseadawy@outlook.com', 1),
(17, 'FarahChedid', '4321', '1997-04-27', 'F', 1, 'Farah', 'Chedid', 'farahchedid@aucegypt.edu', 1);

-- --------------------------------------------------------

--
-- Table structure for table `useraddress`
--

DROP TABLE IF EXISTS `useraddress`;
CREATE TABLE IF NOT EXISTS `useraddress` (
  `uuid` int(6) NOT NULL,
  `addressid` int(6) NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`uuid`,`addressid`),
  KEY `uuid` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branch`
--
ALTER TABLE `branch`
  ADD CONSTRAINT `branch_ibfk_1` FOREIGN KEY (`restaurantID`) REFERENCES `restaurant` (`restaurantID`);

--
-- Constraints for table `branchdeliveryarea`
--
ALTER TABLE `branchdeliveryarea`
  ADD CONSTRAINT `branchdeliveryarea_ibfk_1` FOREIGN KEY (`restaurantID`,`branchID`) REFERENCES `branch` (`restaurantID`, `branchID`),
  ADD CONSTRAINT `branchdeliveryarea_ibfk_2` FOREIGN KEY (`areaID`) REFERENCES `area` (`areaID`);

--
-- Constraints for table `branchphoneno`
--
ALTER TABLE `branchphoneno`
  ADD CONSTRAINT `branchphoneno_ibfk_1` FOREIGN KEY (`branchID`,`restaurantID`) REFERENCES `branch` (`branchID`, `restaurantID`);

--
-- Constraints for table `changepassword`
--
ALTER TABLE `changepassword`
  ADD CONSTRAINT `changepassword_ibfk_1` FOREIGN KEY (`adminUUID`) REFERENCES `user` (`UUID`),
  ADD CONSTRAINT `changepassword_ibfk_2` FOREIGN KEY (`changedUUID`) REFERENCES `user` (`UUID`);

--
-- Constraints for table `customitem`
--
ALTER TABLE `customitem`
  ADD CONSTRAINT `customitem_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `item` (`itemid`);

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`restaurantID`) REFERENCES `restaurant` (`restaurantID`);

--
-- Constraints for table `menuitems`
--
ALTER TABLE `menuitems`
  ADD CONSTRAINT `menuitems_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `item` (`itemid`),
  ADD CONSTRAINT `menuitems_ibfk_2` FOREIGN KEY (`restaurantID`,`menuID`,`menutype`) REFERENCES `menu` (`restaurantID`, `menuID`, `menutype`);

--
-- Constraints for table `modifyuser`
--
ALTER TABLE `modifyuser`
  ADD CONSTRAINT `modifyuser_ibfk_2` FOREIGN KEY (`modifieduuid`) REFERENCES `user` (`UUID`),
  ADD CONSTRAINT `modifyuser_ibfk_3` FOREIGN KEY (`uuid`) REFERENCES `user` (`UUID`);

--
-- Constraints for table `orderaddress`
--
ALTER TABLE `orderaddress`
  ADD CONSTRAINT `orderaddress_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`);

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`itemID`,`customname`) REFERENCES `customitem` (`itemID`, `customname`),
  ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`branchID`,`restaurantID`) REFERENCES `branch` (`branchID`, `restaurantID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`codeID`) REFERENCES `discountcode` (`codeID`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`discountID`) REFERENCES `discount` (`discountID`);

--
-- Constraints for table `restaurantcuisine`
--
ALTER TABLE `restaurantcuisine`
  ADD CONSTRAINT `restaurantcuisine_ibfk_1` FOREIGN KEY (`restaurantID`) REFERENCES `restaurant` (`restaurantID`);

--
-- Constraints for table `useraddress`
--
ALTER TABLE `useraddress`
  ADD CONSTRAINT `useraddress_UUID_fk` FOREIGN KEY (`uuid`) REFERENCES `user` (`UUID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
